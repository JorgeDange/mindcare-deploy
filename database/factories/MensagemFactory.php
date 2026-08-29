<?php

namespace Database\Factories;

use App\Models\Mensagem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MensagemFactory extends Factory
{
    protected $model = Mensagem::class;

    public function definition(): array
    {
        return [
            'conversa_id' => \App\Models\Conversa::factory(),
            'remetente_id' => \App\Models\User::factory(),
            'texto' => fake()->sentence(),
            'lida' => false,
        ];
    }
}
