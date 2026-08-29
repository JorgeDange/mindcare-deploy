<?php

namespace App\Http\Controllers;

use App\Services\Contracts\AiServiceInterface;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function send(Request $request, AiServiceInterface $ai)
    {
        $validated = $request->validate([
            'mensagem' => 'required|string|max:1000',
            'historico' => 'nullable|array',
        ]);

        $resposta = $ai->chat($validated['mensagem'], $validated['historico'] ?? []);

        return response()->json([
            'resposta' => $resposta,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
