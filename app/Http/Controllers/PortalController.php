<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasMessaging;
use App\Models\Consulta;
use App\Models\Documento;
use App\Models\Paciente;
use App\Models\Pagamento;
use App\Models\Plano;
use App\Models\PlanoSubscricao;
use App\Models\Profissional;
use App\Rules\UniqueConsultaSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    use HasMessaging;

    /**
     * Obtém o paciente autenticado com eager loading.
     * Se não existir, cria automaticamente.
     */
    private function getPaciente(array $relations = [])
    {
        $paciente = Auth::user()->paciente;

        if (! $paciente) {
            $paciente = Paciente::create([
                'user_id' => Auth::id(),
                'data_inicio' => now(),
            ]);
        }

        if (! empty($relations)) {
            $paciente->load($relations);
        }

        return $paciente;
    }

    // ══════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════
    public function dashboard()
    {
        $paciente = $this->getPaciente([
            'documentos',
            'subscricaoActiva',
            'subscricaoActiva.plano',
            'profissional.user',
            'conversas.mensagens',
            'conversas.profissional.user',
        ]);

        $paciente->setRelation(
            'consultas',
            $paciente->consultas()
                ->orderBy('data')
                ->orderBy('hora')
                ->with('profissional.user')
                ->get()
        );

        return view('portal.dashboard', compact('paciente'));
    }

    // ══════════════════════════════════════════════
    // PERFIL (GET) — Passo 1
    // ══════════════════════════════════════════════
    public function perfil()
    {
        $user = Auth::user();

        $paciente = $this->getPaciente([
            'documentos' => fn ($q) => $q->latest()->limit(10),
            'subscricaoActiva',
            'subscricaoActiva.plano',
            'profissional.user',
        ]);

        $paciente->setRelation(
            'consultas',
            $paciente->consultas()
                ->orderBy('data', 'desc')
                ->with('profissional.user')
                ->get()
        );

        // Separar consultas para as tabs
        $consultasProximas = $paciente->consultas
            ->whereIn('estado', ['Agendada'])
            ->filter(fn ($c) => $c->data && $c->data->gte(now()->startOfDay()))
            ->take(5);

        $consultasHistorico = $paciente->consultas
            ->whereIn('estado', ['Realizada', 'Cancelada'])
            ->take(10);

        return view('portal.perfil', compact('paciente', 'consultasProximas', 'consultasHistorico'));
    }

    // ══════════════════════════════════════════════
    // PERFIL UPDATE (PUT) — Passo 2
    // ══════════════════════════════════════════════
    public function updatePerfil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:Masculino,Feminino,Outro',
            'bi_numero' => 'nullable|string|max:20',
            'morada' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:50',
            'contacto_emergencia' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string|max:1000',
            'motivo_consulta' => 'nullable|string|max:500',
            'condicoes' => 'nullable|string|max:1000',
            'medicacao' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'preferencias' => 'nullable|array',
        ]);

        $user = Auth::user();

        // Actualizar dados do User
        $user->update([
            'name' => $validated['name'],
            'telefone' => array_key_exists('telefone', $validated) ? $validated['telefone'] : $user->telefone,
            'telefone_alt' => array_key_exists('contacto_emergencia', $validated) ? $validated['contacto_emergencia'] : $user->telefone_alt,
            'data_nascimento' => array_key_exists('data_nascimento', $validated) ? $validated['data_nascimento'] : $user->data_nascimento,
            'genero' => array_key_exists('genero', $validated) ? $validated['genero'] : $user->genero,
            'bi_numero' => array_key_exists('bi_numero', $validated) ? $validated['bi_numero'] : $user->bi_numero,
            'morada' => array_key_exists('morada', $validated) ? $validated['morada'] : $user->morada,
            'provincia' => array_key_exists('provincia', $validated) ? $validated['provincia'] : $user->provincia,
        ]);

        // Actualizar dados do Paciente
        $paciente = $this->getPaciente();
        $paciente->update([
            'motivo_consulta' => array_key_exists('motivo_consulta', $validated) ? $validated['motivo_consulta'] : $paciente->motivo_consulta,
            'condicoes' => array_key_exists('condicoes', $validated) ? $validated['condicoes'] : $paciente->condicoes,
            'medicacao' => array_key_exists('medicacao', $validated) ? $validated['medicacao'] : $paciente->medicacao,
            'observacoes' => array_key_exists('observacoes', $validated) ? $validated['observacoes'] : $paciente->observacoes,
            'preferencias' => array_key_exists('preferencias', $validated) ? $validated['preferencias'] : $paciente->preferencias,
        ]);

        // Tratar upload de foto
        if ($request->hasFile('foto')) {
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }

            $path = $request->file('foto')->store('fotos-perfil', 'public');
            $user->update(['foto_perfil' => $path]);
        }

        return redirect()->back()->with('success', 'Perfil actualizado com sucesso!');
    }

    // ══════════════════════════════════════════════
    // DOWNLOAD DOCUMENTO — Passo 6
    // ══════════════════════════════════════════════
    public function downloadDocumento(Documento $documento)
    {
        abort_if($documento->paciente_id !== Auth::user()->paciente?->id, 403);

        if (! Storage::exists($documento->caminho)) {
            return redirect()->back()->with('error', 'O ficheiro solicitado ainda nao esta disponivel no servidor.');
        }

        $documento->forceFill(['novo' => false])->save();

        $nomeSeguro = \Illuminate\Support\Str::ascii($documento->nome);
        $nomeSeguro = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $nomeSeguro);
        $extensao = strtolower($documento->tipo ?? 'pdf');
        $nomeCompleto = $nomeSeguro . '.' . $extensao;

        return Storage::download($documento->caminho, $nomeCompleto, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function previewDocumento(Documento $documento)
    {
        abort_if($documento->paciente_id !== Auth::user()->paciente?->id, 403);

        if (! Storage::exists($documento->caminho)) {
            return redirect()->back()->with('error', 'O ficheiro solicitado ainda nao esta disponivel no servidor.');
        }

        $documento->forceFill(['novo' => false])->save();

        $path = Storage::path($documento->caminho);
        $mime = mime_content_type($path) ?: 'application/pdf';

        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $documento->nome . '.pdf"',
        ]);
    }

    public function infoDocumento(Documento $documento)
    {
        abort_if($documento->paciente_id !== Auth::user()->paciente?->id, 403);

        return response()->json([
            'nome' => $documento->nome,
            'descricao' => $documento->descricao,
            'data' => $documento->created_at->format('d/m/Y'),
            'partilhado_por' => $documento->partilhadoPor->name ?? 'Clínica',
        ]);
    }

    // ══════════════════════════════════════════════
    // CONSULTAS
    // ══════════════════════════════════════════════
    public function consultas(Request $request)
    {
        $weekParam = $request->query('week');
        if ($weekParam) {
            try {
                $startOfWeek = Carbon::parse($weekParam)->startOfWeek();
            } catch (\Exception $e) {
                $startOfWeek = now()->startOfWeek();
            }
        } else {
            $startOfWeek = now()->startOfWeek();
        }

        $endOfWeek = $startOfWeek->copy()->endOfWeek();
        $previousWeek = $startOfWeek->copy()->subWeek();
        $nextWeek = $startOfWeek->copy()->addWeek();

        $paciente = $this->getPaciente([
            'documentos',
            'subscricaoActiva',
            'profissional.user',
        ]);

        $paciente->load(['consultas' => fn ($q) => $q->with('profissional.user')->orderBy('data')->orderBy('hora')]);

        $estadoFilter = $request->query('estado');
        $mesFilter = $request->query('mes');

        $consultasQuery = $paciente->consultas()
            ->with('profissional.user')
            ->orderBy('data')
            ->orderBy('hora');

        if ($estadoFilter) {
            $consultasQuery->where('estado', $estadoFilter);
        }

        if ($mesFilter) {
            try {
                $mesDate = Carbon::parse($mesFilter.'-01');
                $consultasQuery->whereYear('data', $mesDate->year)
                    ->whereMonth('data', $mesDate->month);
            } catch (\Exception $e) {
                // ignore invalid mes
            }
        }

        $consultasQuery->whereBetween('data', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);

        $consultasFiltradas = $consultasQuery->get();

        $profissionais = Profissional::where('activo', true)
            ->with('user')
            ->orderBy('especialidade')
            ->get();

        $sub = $paciente->subscricaoActiva;

        return view('portal.consultas', compact(
            'paciente', 'profissionais', 'startOfWeek', 'endOfWeek', 'previousWeek', 'nextWeek',
            'consultasFiltradas', 'estadoFilter', 'mesFilter', 'sub'
        ));
    }

    // ══════════════════════════════════════════════
    // DOCUMENTOS (RELATÓRIOS)
    // ══════════════════════════════════════════════
    public function documentos()
    {
        $paciente = $this->getPaciente([
            'subscricaoActiva',
            'profissional.user',
        ]);

        $documentos = $paciente->documentos()->latest()->with('partilhadoPor')->paginate(15);

        $sessoesRealizadas = $paciente->consultas()
            ->where('estado', 'Realizada')
            ->with('profissional.user')
            ->latest('data')
            ->take(20)
            ->get();

        return view('portal.documentos', compact('paciente', 'documentos', 'sessoesRealizadas'));
    }

    // ══════════════════════════════════════════════
    // PLANO
    // ══════════════════════════════════════════════
    public function plano()
    {
        $planos = Plano::where('activo', true)->orderBy('preco')->get();
        $subscricaoActiva = Auth::user()->paciente->subscricaoActiva;
        $planoAtivoId = $subscricaoActiva?->plano_id ?? null;
        $temPagamentoPendente = $subscricaoActiva && Pagamento::where('paciente_id', Auth::user()->paciente->id)
            ->where('plano_subscricao_id', $subscricaoActiva->id)
            ->where('estado', 'Pendente')
            ->exists();

        return view('portal.plano', compact('planos', 'subscricaoActiva', 'planoAtivoId', 'temPagamentoPendente'));
    }

    public function aderirPlano(Request $request)
    {
        $validated = $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'metodo' => 'required|string|max:80',
            'comprovativo' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
        ]);

        $plano = Plano::where('activo', true)->findOrFail($validated['plano_id']);
        $paciente = $this->getPaciente(['subscricaoActiva']);

        // Cancela anterior se existir
        if ($paciente->subscricaoActiva) {
            $paciente->subscricaoActiva->update(['estado' => 'Cancelado']);
        }

        $sub = PlanoSubscricao::create([
            'paciente_id' => $paciente->id,
            'plano_id' => $plano->id,
            'data_inicio' => now(),
            'data_validade' => now()->addYear(),
            'estado' => 'Activo',
        ]);

        $ref = 'COMP_'.now()->timestamp;
        $comprovativoPath = null;
        if ($request->hasFile('comprovativo')) {
            $comprovativoPath = $request->file('comprovativo')->store('comprovativos', 'public');
        }

        Pagamento::create([
            'paciente_id' => $paciente->id,
            'plano_id' => $plano->id,
            'plano_subscricao_id' => $sub->id,
            'valor' => $plano->preco,
            'moeda' => $plano->moeda,
            'metodo' => $validated['metodo'],
            'estado' => 'Pendente',
            'data_pagamento' => now(),
            'referencia' => $ref,
            'comprovativo_path' => $comprovativoPath,
        ]);

        return redirect()->back()->with('success', 'Pedido de adesão submetido com sucesso! Será notificado após validação do pagamento.');
    }

    public function trocarPlano(Request $request)
    {
        $validated = $request->validate([
            'plano_id' => 'required|exists:planos,id',
            'comprovativo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $paciente = $this->getPaciente(['subscricaoActiva.plano']);
        $subscricaoActiva = $paciente->subscricaoActiva;

        abort_if(! $subscricaoActiva, 422, 'Não tem uma subscrição ativa.');

        $planoIdAtual = $subscricaoActiva->plano_id;
        if ((int) $validated['plano_id'] === $planoIdAtual) {
            return redirect()->back()->with('error', 'Já está inscrito neste plano.');
        }

        $pendente = Pagamento::where('paciente_id', $paciente->id)
            ->where('estado', 'Pendente')
            ->exists();

        if ($pendente) {
            return redirect()->back()->with('error', 'Já tem um pagamento pendente. Aguarde aprovação.');
        }

        $planoNovo = Plano::where('activo', true)->findOrFail($validated['plano_id']);

        $subscricaoActiva->update(['estado' => 'Cancelado']);

        $sub = PlanoSubscricao::create([
            'paciente_id' => $paciente->id,
            'plano_id' => $planoNovo->id,
            'data_inicio' => now(),
            'data_validade' => now()->addYear(),
            'estado' => 'Activo',
        ]);

        $ref = 'TROC_'.now()->timestamp;
        $comprovativoPath = $request->file('comprovativo')->store('comprovativos', 'public');

        Pagamento::create([
            'paciente_id' => $paciente->id,
            'plano_id' => $planoNovo->id,
            'plano_subscricao_id' => $sub->id,
            'valor' => $planoNovo->preco,
            'moeda' => $planoNovo->moeda,
            'metodo' => 'Transferência Bancária',
            'estado' => 'Pendente',
            'data_pagamento' => now(),
            'referencia' => $ref,
            'comprovativo_path' => $comprovativoPath,
        ]);

        return redirect()->back()->with('info', 'Pedido de troca submetido. Aguarde aprovação do administrador.');
    }

    // ══════════════════════════════════════════════
    // CONSULTA (STORE)
    // ══════════════════════════════════════════════
    public function storeConsulta(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date|after_or_equal:today|before:+6 months',
            'hora' => 'required|date_format:H:i',
            'modalidade' => 'required|in:online,presencial',
            'tipo' => 'required|in:Individual,Casal,Familiar,Avaliação Inicial,Grupo',
            'profissional_id' => 'nullable|exists:profissionais,id',
            'especialidade' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string|max:500',
        ]);

        $paciente = $this->getPaciente();
        $paciente->load('subscricaoActiva.plano');

        $subscricao = $paciente->subscricaoActiva;
        if (! $subscricao || ! $subscricao->ativa()) {
            return redirect()->back()->withInput()->with('error', 'Não tem uma subscrição ativa. Por favor renove o seu plano.');
        }
        if ($subscricao->esgotada()) {
            return redirect()->back()->withInput()->with('error', 'As sessões do seu plano estão esgotadas. Por favor renove ou faça upgrade do plano.');
        }
        if (Pagamento::where('paciente_id', $paciente->id)
            ->where('plano_subscricao_id', $subscricao->id)
            ->where('estado', 'Pendente')
            ->exists()) {
            return redirect()->back()->withInput()->with('error', 'O seu plano ainda não foi aprovado. Aguarde a confirmação do administrador.');
        }

        $profissional = Profissional::query()
            ->where('activo', true)
            ->when($validated['profissional_id'] ?? null, fn ($query, $id) => $query->where('id', $id))
            ->when(! ($validated['profissional_id'] ?? null) && ($validated['especialidade'] ?? null), fn ($query) => $query->where('especialidade', $validated['especialidade']))
            ->first();

        if (! $profissional) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nao encontramos um profissional disponivel para a consulta pedida.');
        }

        // Validar que o slot não está ocupado
        $slotValidator = \Validator::make([], []);
        $slotValidator->after(function ($validator) use ($profissional, $validated) {
            $slotRule = new UniqueConsultaSlot(
                $profissional->id,
                $validated['data'],
                $validated['hora']
            );

            if (! $slotRule->passes('slot', null)) {
                $validator->errors()->add('slot', 'Este horário com este profissional já está ocupado.');
            }
        });
        $slotValidator->validate();

        Consulta::create([
            'paciente_id' => $paciente->id,
            'profissional_id' => $profissional->id,
            'data' => $validated['data'],
            'hora' => $validated['hora'],
            'modalidade' => $validated['modalidade'],
            'estado' => 'Agendada',
            'tipo' => $validated['tipo'],
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Consulta agendada com sucesso!');
    }

    public function confirmarConsulta(Consulta $consulta)
    {
        $this->authorizeConsulta($consulta);

        if ($consulta->estado !== 'Agendada') {
            return redirect()->back()->with('error', 'Apenas consultas agendadas podem ser confirmadas.');
        }

        $consulta->update(['confirmada' => true]);

        return redirect()->back()->with('success', 'Presenca confirmada com sucesso.');
    }

    public function cancelarConsulta(Consulta $consulta)
    {
        $this->authorizeConsulta($consulta);

        if ($consulta->estado !== 'Agendada') {
            return redirect()->back()->with('error', 'Apenas consultas agendadas podem ser canceladas.');
        }

        $consulta->update([
            'estado' => 'Cancelada',
            'confirmada' => false,
        ]);

        return redirect()->back()->with('success', 'Consulta cancelada com sucesso.');
    }

    public function reagendarConsulta(Request $request, Consulta $consulta)
    {
        $this->authorizeConsulta($consulta);

        if ($consulta->estado !== 'Agendada') {
            return redirect()->back()->with('error', 'Apenas consultas agendadas podem ser reagendadas.');
        }

        $validated = $request->validate([
            'data' => 'required|date|after_or_equal:today',
            'hora' => 'required',
        ]);

        $consulta->update([
            'data' => $validated['data'],
            'hora' => $validated['hora'],
            'confirmada' => false, // Resetar a confirmacao
        ]);

        return redirect()->back()->with('success', 'Consulta reagendada com sucesso para a nova data e hora.');
    }

    private function authorizeConsulta(Consulta $consulta): void
    {
        abort_if($consulta->paciente_id !== Auth::user()->paciente?->id, 403);
    }

    // ══════════════════════════════════════════════
    // FICHA CLÍNICA
    // ══════════════════════════════════════════════
    public function ficha()
    {
        $paciente = $this->getPaciente([
            'documentos',
            'subscricaoActiva',
            'subscricaoActiva.plano',
            'profissional.user',
        ]);

        $paciente->setRelation(
            'consultas',
            $paciente->consultas()
                ->orderBy('data', 'desc')
                ->with('profissional.user')
                ->get()
        );

        return view('portal.ficha', compact('paciente'));
    }

    public function updateFicha(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date|before:today',
            'genero' => 'nullable|in:Masculino,Feminino,Outro',
            'bi_numero' => 'nullable|string|max:20',
            'morada' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:50',
            'motivo_consulta' => 'nullable|string|max:1000',
            'condicoes' => 'nullable|string|max:1000',
            'medicacao' => 'nullable|string|max:1000',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $paciente = $this->getPaciente();
        Auth::user()->update([
            'name' => $validated['name'],
            'telefone' => $validated['telefone'] ?? null,
            'data_nascimento' => $validated['data_nascimento'] ?? null,
            'genero' => $validated['genero'] ?? null,
            'bi_numero' => $validated['bi_numero'] ?? null,
            'morada' => $validated['morada'] ?? null,
            'provincia' => $validated['provincia'] ?? null,
        ]);

        $paciente->update([
            'motivo_consulta' => $validated['motivo_consulta'] ?? null,
            'condicoes' => $validated['condicoes'] ?? null,
            'medicacao' => $validated['medicacao'] ?? null,
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Ficha clínica gravada com sucesso!');
    }

    protected function getMessagingOwner(): mixed
    {
        return $this->getPaciente();
    }

    protected function getMessagingOwnerField(): string
    {
        return 'paciente_id';
    }

    protected function getMessagingView(): string
    {
        return 'portal.mensagens';
    }

    protected function getMessagingRoute(): string
    {
        return 'mensagens';
    }
}
