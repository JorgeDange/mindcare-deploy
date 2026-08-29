<?php

namespace App\Http\Controllers\Concerns;

use App\Events\MensagemLida;
use App\Events\NovaMensagem;
use App\Models\Conversa;
use App\Models\Mensagem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

trait HasMessaging
{
    abstract protected function getMessagingOwner(): mixed;

    abstract protected function getMessagingOwnerField(): string;

    abstract protected function getMessagingView(): string;

    abstract protected function getMessagingRoute(): string;

    public function mensagens(Request $request)
    {
        $owner = $this->getMessagingOwner();
        $field = $this->getMessagingOwnerField();

        $conversas = Conversa::where($field, $owner->id)
            ->with([
                'mensagens' => fn ($q) => $q->latest()->take(1),
                $this->getMessagingOwnerField() === 'profissional_id' ? 'paciente.user' : 'profissional.user',
            ])
            ->withCount(['mensagens as nao_lidas' => fn ($q) => $q->where('remetente_id', '!=', Auth::id())->where('lida', false),
            ])
            ->orderByDesc('updated_at')
            ->get();

        $conversaActiva = null;
        if ($request->has('conversa')) {
            $conversaActiva = Conversa::where('id', $request->conversa)
                ->where($field, $owner->id)
                ->with(['mensagens' => fn ($q) => $q->orderBy('created_at')])
                ->with('profissional.user', 'paciente.user')
                ->firstOrFail();
        } elseif ($conversas->isNotEmpty()) {
            $conversaActiva = $conversas->first();
        }

        if ($conversaActiva) {
            $conversaActiva->mensagens()
                ->where('remetente_id', '!=', Auth::id())
                ->where('lida', false)
                ->update(['lida' => true]);

            $conversaActiva->load(['mensagens' => fn ($q) => $q->orderBy('created_at')]);
        }

        return view($this->getMessagingView(), compact('conversas', 'conversaActiva', 'owner'));
    }

    public function storeMensagem(Request $request)
    {
        $owner = $this->getMessagingOwner();
        $field = $this->getMessagingOwnerField();

        $validated = $request->validate([
            'conversa_id' => [
                'required',
                Rule::exists('conversas', 'id')->where($field, $owner->id),
            ],
            'texto' => 'required|string|max:2000',
            'anexo' => 'nullable|file|mimes:pdf,png,jpg,jpeg,doc,docx|max:5120',
        ]);

        $anexoPath = null;
        if ($request->hasFile('anexo')) {
            $anexoPath = $request->file('anexo')->store('mensagens/'.$owner->id, 'public');
        }

        $mensagem = Mensagem::create([
            'conversa_id' => $validated['conversa_id'],
            'remetente_id' => Auth::id(),
            'texto' => $validated['texto'],
            'anexo_path' => $anexoPath,
            'lida' => false,
        ]);

        $conversa = Conversa::find($validated['conversa_id']);
        broadcast(new NovaMensagem($mensagem, $conversa, Auth::user()))->toOthers();

        return redirect()
            ->route($this->getMessagingRoute(), ['conversa' => $validated['conversa_id']])
            ->with('success', 'Mensagem enviada com sucesso.');
    }

    public function novasMensagens(Request $request, Conversa $conversa)
    {
        $owner = $this->getMessagingOwner();
        $field = $this->getMessagingOwnerField();
        abort_if($conversa->{$field} !== $owner->id, 403);

        $desde = $request->query('desde');
        $timestamp = Carbon::createFromTimestamp((int) $desde);

        $mensagens = $conversa->mensagens()
            ->where('created_at', '>', $timestamp)
            ->orderBy('created_at')
            ->get();

        $naoLidas = $mensagens->where('remetente_id', '!=', Auth::id())->where('lida', false);
        if ($naoLidas->isNotEmpty()) {
            foreach ($naoLidas as $msg) {
                $msg->update(['lida' => true]);
            }
            broadcast(new MensagemLida($conversa->id))->toOthers();
        }

        return response()->json([
            'mensagens' => $mensagens->map(fn ($m) => [
                'id' => $m->id,
                'remetente_id' => $m->remetente_id,
                'texto' => nl2br(e($m->texto)),
                'anexo_url' => $m->anexo_path ? Storage::url($m->anexo_path) : null,
                'hora' => $m->created_at->format('H:i'),
            ]),
        ]);
    }
}
