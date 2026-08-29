<?php

namespace Database\Factories;

use App\Models\PlanoSubscricao;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanoSubscricaoFactory extends Factory
{
    protected $model = PlanoSubscricao::class;

    public function definition(): array
    {
        return [
            'paciente_id' => \App\Models\Paciente::factory(),
            'plano_id' => \App\Models\Plano::factory(),
            'data_inicio' => now(),
            'data_validade' => now()->addYear(),
            'estado' => 'Activo',
            'sessoes_usadas' => 0,
        ];
    }
}
