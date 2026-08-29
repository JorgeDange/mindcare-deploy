<?php

namespace Database\Factories;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'paciente'])->id,
            'data_inicio' => now(),
        ];
    }

    public function comProfissional($profissional): static
    {
        return $this->state(fn (array $attrs) => [
            'profissional_id' => $profissional->id,
        ]);
    }
}
