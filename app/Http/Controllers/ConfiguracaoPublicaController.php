<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ConfiguracaoPublicaController extends Controller
{
    public function coordenadas(): JsonResponse
    {
        $config = DB::table('config_pagamento')
            ->where('activo', true)
            ->first();

        if (!$config) {
            return response()->json([
                'dados_bancarios' => [
                    'banco' => '',
                    'iban' => 'AO06 0000 0000 0000 0000 0',
                    'titular' => 'MindCare Lda',
                    'conta' => '',
                    'referencia' => '',
                ],
                'metodos_pagamento' => [
                    'transferencia_bancaria' => true,
                    'deposito' => false,
                    'multicaixa' => true,
                ],
                'multicaixa' => [
                    'referencia' => '',
                    'telefone' => '',
                ],
                'deposito' => [
                    'instrucoes' => '',
                ],
            ]);
        }

        return response()->json([
            'dados_bancarios' => [
                'banco' => $config->banco,
                'iban' => $config->iban,
                'titular' => $config->titular,
                'conta' => $config->conta,
                'referencia' => $config->referencia,
            ],
            'metodos_pagamento' => [
                'transferencia_bancaria' => (bool) $config->metodo_transferencia,
                'deposito' => (bool) $config->metodo_deposito,
                'multicaixa' => (bool) $config->metodo_multicaixa,
            ],
            'multicaixa' => [
                'referencia' => $config->multicaixa_referencia,
                'telefone' => $config->multicaixa_telefone,
            ],
            'deposito' => [
                'instrucoes' => $config->deposito_instrucoes,
            ],
        ]);
    }
}
