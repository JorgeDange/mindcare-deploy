<?php

namespace Database\Factories;

use App\Models\Pagamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition(): array
    {
        return [
            'paciente_id' => \App\Models\Paciente::factory(),
            'plano_id' => \App\Models\Plano::factory(),
            'plano_subscricao_id' => \App\Models\PlanoSubscricao::factory(),
            'valor' => fake()->randomFloat(2, 10000, 200000),
            'moeda' => 'AOA',
            'metodo' => fake()->randomElement(['Transferência Bancária', 'Cartão', 'Dinheiro']),
            'estado' => 'Pendente',
            'data_pagamento' => now(),
            'referencia' => 'PAG_' . fake()->unique()->numerify('########'),
        ];
    }

    public function pendente(): static
    {
        return $this->state(['estado' => 'Pendente']);
    }

    public function aprovado(): static
    {
        return $this->state(['estado' => 'aprovado']);
    }
}
