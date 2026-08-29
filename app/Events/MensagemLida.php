<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class MensagemLida
{
    use Dispatchable;

    public int $conversaId;

    public function __construct(int $conversaId)
    {
        $this->conversaId = $conversaId;
    }
}
