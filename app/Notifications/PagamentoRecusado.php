<?php

namespace App\Notifications;

use App\Models\Pagamento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PagamentoRecusado extends Notification
{
    use Queueable;

    public Pagamento $pagamento;

    public string $motivo;

    public function __construct(Pagamento $pagamento, string $motivo)
    {
        $this->pagamento = $pagamento;
        $this->motivo = $motivo;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titulo' => 'Pagamento Recusado',
            'mensagem' => "O seu pagamento foi recusado. Motivo: {$this->motivo}",
            'url' => route('plano'),
            'icone' => 'x-circle',
        ];
    }
}
