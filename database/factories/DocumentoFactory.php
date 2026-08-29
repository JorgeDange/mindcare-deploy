<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    public function definition(): array
    {
        return [
            'paciente_id' => \App\Models\Paciente::factory(),
            'partilhado_por' => User::factory(),
            'nome' => fake()->words(3, true) . '.pdf',
            'tipo' => 'PDF',
            'categoria' => fake()->randomElement(['relatorio', 'receita', 'atestado', 'outro']),
            'caminho' => 'documentos/' . fake()->uuid() . '.pdf',
            'tamanho' => fake()->numberBetween(1000, 50000),
            'novo' => true,
        ];
    }
}
