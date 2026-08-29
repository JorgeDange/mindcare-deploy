<?php

namespace App\Notifications;

use App\Models\PlanoSubscricao;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscricaoAExpirar extends Notification
{
    use Queueable;

    public PlanoSubscricao $subscricao;

    public int $dias;

    public function __construct(PlanoSubscricao $subscricao, int $dias)
    {
        $this->subscricao = $subscricao;
        $this->dias = $dias;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titulo' => 'Subscrição a Expirar',
            'mensagem' => "A sua subscrição expira em {$this->dias} dias.",
            'url' => route('plano'),
            'icone' => 'clock',
        ];
    }
}
