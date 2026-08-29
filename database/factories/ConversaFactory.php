<?php

namespace Database\Factories;

use App\Models\Conversa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversaFactory extends Factory
{
    protected $model = Conversa::class;

    public function definition(): array
    {
        return [
            'paciente_id' => \App\Models\Paciente::factory(),
            'contacto' => fake()->name(),
            'iniciais' => strtoupper(fake()->randomLetter() . fake()->randomLetter()),
        ];
    }

    public function comPaciente($paciente): static
    {
        return $this->state(fn (array $attrs) => [
            'paciente_id' => $paciente->id,
            'profissional_id' => $paciente->profissional_id,
            'contacto' => $paciente->profissional?->user?->name ?? 'Profissional',
            'iniciais' => strtoupper(substr($paciente->profissional?->user?->name ?? 'DR', 0, 2)),
        ]);
    }
}
