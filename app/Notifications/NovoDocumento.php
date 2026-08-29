<?php

namespace App\Notifications;

use App\Models\Documento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NovoDocumento extends Notification
{
    use Queueable;

    public Documento $documento;

    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titulo' => 'Novo Documento Disponível',
            'mensagem' => "O documento '{$this->documento->nome}' foi partilhado consigo.",
            'url' => route('documentos'),
            'icone' => 'file',
        ];
    }
}
