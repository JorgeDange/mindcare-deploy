<?php

namespace App\Notifications;

use App\Models\Consulta;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConsultaConfirmada extends Notification
{
    use Queueable;

    public Consulta $consulta;

    public function __construct(Consulta $consulta)
    {
        $this->consulta = $consulta;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titulo' => 'Consulta Confirmada',
            'mensagem' => "A sua consulta de {$this->consulta->data->format('d/m/Y')} foi confirmada.",
            'url' => route('consultas'),
            'icone' => 'calendar-check',
        ];
    }
}
