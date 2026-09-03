<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasMessaging;
use App\Models\Consulta;
use App\Models\Documento;
use App\Models\Mensagem;
use App\Models\Paciente;
use App\Models\Pagamento;
use App\Notifications\ConsultaConfirmada;
use App\Notifications\NovoDocumento;
use App\Rules\UniqueConsultaSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfissionalController extends Controller
{
    use HasMessaging;

    protected $profissional;

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:profissional']);
    }

    private function getProfissional()
    {
        if (! $this->profissional) {
            $this->profissional = Auth::user()->loadMissing('profissional')->profissional;
            abort_if(! $this->profissional, 403, 'Perfil profissional não encontrado.');
        }

        return $this->profissional;
    }

    public function dashboard()
    {
        $profissional = $this->getProfissional();
        $hoje = now()->toDateString();

        $proximasConsultas = Consulta::where('profissional_id', $profissional->id)
            ->whereIn('estado', ['Agendada'])
            ->where('data', '>=', $hoje)
            ->orderBy('data')
            ->orderBy('hora')
            ->with('paciente.user')
            ->take(5)
            ->get();

        $totalPacientes = Paciente::where('profissional_id', $profissional->id)->count();

        $consultasHoje = Consulta::where('profissional_id', $profissional->id)
            ->whereDate('data', today())
            ->count();

        $mensagensNaoLidas = Mensagem::whereHas('conversa', fn ($q) => $q->where('profissional_id', $profissional->id))
            ->where('lida', false)
            ->where('remetente_id', '!=', Auth::id())
            ->count();

        $consultasMes = Consulta::where('profissional_id', $profissional->id)
            ->whereMonth('data', now()->month)
            ->whereYear('data', now()->year)
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        return view('profissional.dashboard', compact(
            'profissional',
            'proximasConsultas',
            'totalPacientes',
            'consultasHoje',
            'mensagensNaoLidas',
            'consultasMes'
        ));
    }

    public function agenda(Request $request)
    {
        $profissional = $this->getProfissional();

        $semanaParam = $request->query('semana');
        if ($semanaParam) {
            $inicio = Carbon::parse($semanaParam)->startOfWeek(Carbon::MONDAY);
        } else {
            $inicio = Carbon::now()->startOfWeek(Carbon::MONDAY);
        }
        $fim = $inicio->copy()->endOfWeek(Carbon::SUNDAY);

        $consultas = Consulta::where('profissional_id', $profissional->id)
            ->whereBetween('data', [$inicio->toDateString(), $fim->toDateString()])
            ->orderBy('data')
            ->orderBy('hora')
            ->with('paciente.user')
            ->get();

        $consultasPorDia = $consultas->groupBy(fn ($c) => $c->data->format('Y-m-d'));

        $pacientes = Paciente::where('profissional_id', $profissional->id)
            ->with('user')
            ->orderByRaw('(SELECT name FROM users WHERE users.id = pacientes.user_id)')
            ->get();

        return view('profissional.agenda', compact(
            'consultasPorDia',
            'inicio',
            'fim',
            'pacientes'
        ));
    }

    public function storeConsulta(Request $request)
    {
        $profissional = $this->getProfissional();

        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'data' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'tipo' => 'required|in:Individual,Casal,Familiar,Avaliação Inicial,Grupo',
            'modalidade' => 'required|in:online,presencial',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $paciente = Paciente::findOrFail($validated['paciente_id']);
        abort_if($paciente->profissional_id !== $profissional->id, 403);

        $paciente->load('subscricaoActiva.plano');
        $subscricao = $paciente->subscricaoActiva;
        if (! $subscricao || ! $subscricao->ativa()) {
            return back()->withErrors('Paciente não tem uma subscrição ativa.')->withInput();
        }
        if ($subscricao->esgotada()) {
            return back()->withErrors('As sessões do plano do paciente estão esgotadas.')->withInput();
        }
        if (Pagamento::where('paciente_id', $paciente->id)
            ->where('plano_subscricao_id', $subscricao->id)
            ->where('estado', 'Pendente')
            ->exists()) {
            return back()->withErrors('O plano do paciente ainda não foi aprovado pelo administrador.')->withInput();
        }

        $slotRule = new UniqueConsultaSlot(
            $profissional->id,
            $validated['data'],
            $validated['hora']
        );

        if (! $slotRule->passes('slot', null)) {
            return back()->withErrors('Já existe uma consulta agendada neste horário.')->withInput();
        }

        $consulta = Consulta::create([
            'paciente_id' => $validated['paciente_id'],
            'profissional_id' => $profissional->id,
            'data' => $validated['data'],
            'hora' => $validated['hora'],
            'tipo' => $validated['tipo'],
            'modalidade' => $validated['modalidade'],
            'observacoes' => $validated['observacoes'],
            'estado' => 'Agendada',
        ]);

        return back()->with('success', 'Consulta agendada com sucesso.');
    }

    public function updateEstado(Request $request, Consulta $consulta)
    {
        $profissional = $this->getProfissional();
        abort_if($consulta->profissional_id !== $profissional->id, 403);

        $validated = $request->validate([
            'estado' => 'required|in:confirmada,realizada,cancelada,falta',
        ]);

        $transicoes = [
            'Agendada' => ['confirmada', 'cancelada'],
        ];

        if ($consulta->confirmada && $consulta->estado === 'Agendada') {
            $transicoes['Agendada'] = ['realizada', 'cancelada', 'falta'];
        }

        if (! in_array($validated['estado'], $transicoes[$consulta->estado] ?? [])) {
            return back()->withErrors('Transição de estado inválida.');
        }

        if ($validated['estado'] === 'confirmada') {
            $consulta->update(['confirmada' => true]);
            $consulta->load('paciente.user');
            $consulta->paciente?->user?->notify(new ConsultaConfirmada($consulta));

            activity('consultas')
                ->causedBy(Auth::user())
                ->performedOn($consulta)
                ->withProperties(['estado_anterior' => 'Agendada', 'estado_novo' => 'confirmada'])
                ->log("Consulta #{$consulta->id} confirmada");

            return back()->with('success', 'Consulta confirmada com sucesso.');
        }

        $mapa = [
            'realizada' => 'Realizada',
            'cancelada' => 'Cancelada',
            'falta' => 'Faltou',
        ];
        $novoEstado = $mapa[$validated['estado']];
        $estadoAnterior = $consulta->estado;

        DB::transaction(function () use ($consulta, $novoEstado) {
            $consulta->update(['estado' => $novoEstado]);

            if ($novoEstado === 'Realizada') {
                $consulta->loadMissing(['paciente.user', 'paciente.subscricaoActiva', 'profissional.user']);

                $subscricao = $consulta->paciente->subscricaoActiva;
                if ($subscricao) {
                    $subscricao->increment('sessoes_usadas');
                }

                $dataFormatada = $consulta->data instanceof Carbon
                    ? $consulta->data->format('d/m/Y')
                    : Carbon::parse($consulta->data)->format('d/m/Y');

                $nomePaciente = $consulta->paciente?->user?->name ?? 'Paciente';
                $nomeProf = $consulta->profissional?->user?->name ?? 'Profissional';

                $conteudo = "RELATÓRIO DE SESSÃO CLÍNICA\n".
                    str_repeat('=', 40)."\n\n".
                    "Paciente: {$nomePaciente}\n".
                    "Profissional: {$nomeProf}\n".
                    "Data: {$dataFormatada}\n".
                    "Hora: {$consulta->hora}\n".
                    "Tipo: {$consulta->tipo}\n".
                    "Modalidade: {$consulta->modalidade}\n".
                    "Estado: Realizada\n\n".
                    str_repeat('-', 40)."\n".
                    "Sessão realizada com sucesso.\n".
                    "Este relatório foi gerado automaticamente pelo sistema MindCare.\n";

                $caminho = "documentos/pacientes/relatorio-sessao-{$consulta->id}.txt";
                Storage::disk('local')->put($caminho, $conteudo);

                Documento::create([
                    'paciente_id' => $consulta->paciente_id,
                    'partilhado_por' => Auth::id(),
                    'nome' => "Relatório de Sessão - {$dataFormatada}",
                    'tipo' => 'TXT',
                    'categoria' => 'clinico',
                    'descricao' => $conteudo,
                    'caminho' => $caminho,
                    'tamanho' => strlen($conteudo),
                    'novo' => true,
                ]);
            }
        });

        activity('consultas')
            ->causedBy(Auth::user())
            ->performedOn($consulta)
            ->withProperties(['estado_anterior' => $estadoAnterior, 'estado_novo' => $request->estado])
            ->log("Estado da consulta #{$consulta->id} alterado para {$request->estado}");

        return back()->with('success', 'Estado actualizado com sucesso.');
    }

    public function pacientes()
    {
        $profissional = $this->getProfissional();

        $pacientes = Paciente::where('profissional_id', $profissional->id)
            ->with(['user', 'subscricaoActiva.plano'])
            ->get()
            ->map(function ($p) {
                $plano = $p->subscricaoActiva?->plano;
                $p->sessoes_restantes = $plano
                    ? ($plano->sessoes_total - ($p->subscricaoActiva->sessoes_usadas ?? 0))
                    : 0;

                return $p;
            });

        return view('profissional.pacientes.index', compact('pacientes'));
    }

    public function showPaciente(Paciente $paciente)
    {
        $this->authorize('view', $paciente);

        $paciente->load(['user', 'subscricaoActiva.plano', 'consultas' => fn ($q) => $q->latest('data')->latest('hora')->take(10),
        ]);

        return view('profissional.pacientes.show', compact('paciente'));
    }

    public function fichaPaciente(Paciente $paciente)
    {
        $this->authorize('viewFicha', $paciente);

        $paciente->load('user');

        return view('profissional.pacientes.ficha', compact('paciente'));
    }

    public function updateFichaPaciente(Request $request, Paciente $paciente)
    {
        $this->authorize('updateFicha', $paciente);

        $validated = $request->validate([
            'diagnostico' => 'nullable|string|max:5000',
            'medicacao_atual' => 'nullable|string|max:5000',
            'historico_familiar' => 'nullable|string|max:5000',
            'observacoes_profissional' => 'nullable|string|max:5000',
            'plano_terapeutico' => 'nullable|string|max:5000',
        ]);

        $paciente->update($validated);

        return back()->with('success', 'Ficha clínica actualizada com sucesso.');
    }

    public function documentos()
    {
        $profissional = $this->getProfissional();

        $documentos = Documento::whereHas('paciente', fn ($q) => $q->where('profissional_id', $profissional->id))
            ->with('paciente.user')
            ->orderByDesc('created_at')
            ->paginate(20);

        $pacientes = Paciente::where('profissional_id', $profissional->id)
            ->with('user')
            ->get();

        return view('profissional.documentos.index', compact('documentos', 'pacientes'));
    }

    public function storeDocumento(Request $request)
    {
        $this->authorize('create', Documento::class);

        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'ficheiro' => 'required|file|mimes:pdf|max:10240',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'categoria' => 'required|in:relatorio,receita,atestado,outro',
        ]);

        $profissional = $this->getProfissional();
        $paciente = Paciente::findOrFail($validated['paciente_id']);
        abort_if($paciente->profissional_id !== $profissional->id, 403);

        $ficheiro = $request->file('ficheiro');
        $caminho = $ficheiro->store('documentos/pacientes', 'local');
        $extensao = strtoupper($ficheiro->extension());

        $documento = Documento::create([
            'paciente_id' => $validated['paciente_id'],
            'partilhado_por' => Auth::id(),
            'nome' => $validated['titulo'],
            'tipo' => $extensao,
            'categoria' => $validated['categoria'],
            'descricao' => $validated['descricao'],
            'caminho' => $caminho,
            'tamanho' => $ficheiro->getSize(),
            'novo' => true,
        ]);

        activity('documentos')
            ->causedBy(Auth::user())
            ->performedOn($documento)
            ->log("Documento '{$documento->nome}' criado para paciente #{$paciente->id}");

        $paciente->user->notify(new NovoDocumento($documento));

        return back()->with('success', 'Documento enviado com sucesso.');
    }

    public function downloadDocumento(Documento $documento)
    {
        $this->authorize('view', $documento);

        if (! Storage::exists($documento->caminho)) {
            return back()->with('error', 'Ficheiro não encontrado no servidor.');
        }

        $nomeSeguro = \Illuminate\Support\Str::ascii($documento->nome);
        $nomeSeguro = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $nomeSeguro);
        $extensao = strtolower($documento->tipo ?? 'pdf');
        $nomeCompleto = $nomeSeguro . '.' . $extensao;

        return Storage::download($documento->caminho, $nomeCompleto, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function perfil()
    {
        $user = Auth::user();

        return view('profissional.perfil', compact('user'));
    }

    protected function getMessagingOwner(): mixed
    {
        return $this->getProfissional();
    }

    protected function getMessagingOwnerField(): string
    {
        return 'profissional_id';
    }

    protected function getMessagingView(): string
    {
        return 'profissional.mensagens.index';
    }

    protected function getMessagingRoute(): string
    {
        return 'profissional.mensagens.index';
    }
}
