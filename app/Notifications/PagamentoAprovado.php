<?php

namespace App\Notifications;

use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PagamentoAprovado extends Notification
{
    use Queueable;

    public Pagamento $pagamento;

    public function __construct(Pagamento $pagamento)
    {
        $this->pagamento = $pagamento;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titulo' => 'Pagamento Aprovado',
            'mensagem' => "O seu pagamento foi aprovado. O plano {$this->pagamento->plano?->nome} está ativo.",
            'url' => route('plano'),
            'icone' => 'check-circle',
        ];
    }
}
