<?php

namespace App\Services\Contracts;

interface AiServiceInterface
{
    public function chat(string $mensagem, array $historico = []): string;
}
