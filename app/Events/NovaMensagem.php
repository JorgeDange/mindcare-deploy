<?php

namespace App\Events;

use App\Models\Conversa;
use App\Models\Mensagem;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class NovaMensagem
{
    use Dispatchable;

    public Mensagem $mensagem;

    public Conversa $conversa;

    public User $remetente;

    public function __construct(Mensagem $mensagem, Conversa $conversa, User $remetente)
    {
        $this->mensagem = $mensagem;
        $this->conversa = $conversa;
        $this->remetente = $remetente;
    }
}
