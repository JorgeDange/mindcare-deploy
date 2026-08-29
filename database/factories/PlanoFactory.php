<?php

namespace Database\Factories;

use App\Models\Plano;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanoFactory extends Factory
{
    protected $model = Plano::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->words(2, true),
            'slug' => fake()->slug(2),
            'publico' => fake()->randomElement(['individual', 'familia', 'empresa']),
            'descricao' => fake()->sentence(),
            'sessoes_total' => fake()->randomElement([4, 8, 12]),
            'preco' => fake()->randomFloat(2, 10000, 200000),
            'moeda' => 'AOA',
            'beneficios' => fake()->randomElements(['Consultas ilimitadas', 'Acompanhamento online', 'Desconto familiar', 'Suporte 24h', 'Relatórios mensais'], rand(2, 4)),
            'activo' => true,
        ];
    }
}
