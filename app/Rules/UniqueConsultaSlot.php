<?php

namespace App\Rules;

use App\Models\Consulta;
use Illuminate\Contracts\Validation\Rule;

class UniqueConsultaSlot implements Rule
{
    private $profissionalId;

    private $data;

    private $hora;

    private $message = 'Este horário com este profissional já está ocupado.';

    public function __construct($profissionalId, $data, $hora)
    {
        $this->profissionalId = $profissionalId;
        $this->data = $data;
        $this->hora = $hora;
    }

    public function passes($attribute, $value)
    {
        // Verificar se existe consulta no mesmo profissional, data e hora
        // Excluir apenas consultas canceladas
        $exists = Consulta::where('profissional_id', $this->profissionalId)
            ->where('data', $this->data)
            ->where('hora', $this->hora)
            ->where('estado', '!=', 'Cancelada')
            ->exists();

        return ! $exists;
    }

    public function message()
    {
        return $this->message;
    }
}
