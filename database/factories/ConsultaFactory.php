<?php

namespace Database\Factories;

use App\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultaFactory extends Factory
{
    protected $model = Consulta::class;

    public function definition(): array
    {
        return [
            'paciente_id' => \App\Models\Paciente::factory(),
            'profissional_id' => \App\Models\Profissional::factory(),
            'data' => fake()->dateTimeBetween('today', '+1 month')->format('Y-m-d'),
            'hora' => fake()->randomElement(['09:00', '10:00', '11:00', '14:00', '15:00', '16:00']),
            'modalidade' => fake()->randomElement(['online', 'presencial']),
            'tipo' => fake()->randomElement(['Individual', 'Casal', 'Familiar', 'Avaliação Inicial', 'Grupo']),
            'estado' => 'Agendada',
            'confirmada' => false,
        ];
    }
}
