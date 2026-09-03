<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ConfiguracaoPublicaController extends Controller
{
    public function coordenadas(): JsonResponse
    {
        $path = storage_path('app/configuracoes.json');

        $defaults = [
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
        ];

        if (!file_exists($path)) {
            return response()->json($defaults);
        }

        $raw = file_get_contents($path);
        $config = json_decode($raw, true);

        if (!is_array($config)) {
            return response()->json($defaults);
        }

        return response()->json([
            'dados_bancarios' => $config['dados_bancarios'] ?? $defaults['dados_bancarios'],
            'metodos_pagamento' => $config['metodos_pagamento'] ?? $defaults['metodos_pagamento'],
        ]);
    }
}
