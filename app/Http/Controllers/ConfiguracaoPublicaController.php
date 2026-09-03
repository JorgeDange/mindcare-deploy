<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ConfiguracaoPublicaController extends Controller
{
    public function coordenadas(): JsonResponse
    {
        $path = 'configuracoes.json';

        if (!Storage::exists($path)) {
            return response()->json([
                'dados_bancarios' => [
                    'banco' => '',
                    'iban' => 'AO06 0000 0000 0000 0000 0',
                    'titular' => 'MindCare Lda',
                    'referencia' => '',
                ],
                'metodos_pagamento' => [
                    'transferencia_bancaria' => true,
                    'deposito' => false,
                    'multicaixa' => true,
                ],
            ]);
        }

        $config = json_decode(Storage::get($path), true);

        return response()->json([
            'dados_bancarios' => $config['dados_bancarios'] ?? [],
            'metodos_pagamento' => $config['metodos_pagamento'] ?? [],
        ]);
    }
}
