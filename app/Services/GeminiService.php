<?php

namespace App\Services;

use App\Services\Contracts\AiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService implements AiServiceInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY', ''));
    }

    public function chat(string $mensagem, array $historico = []): string
    {
        $systemPrompt = SystemPrompt::build();

        $contents = [
            ['role' => 'user', 'parts' => [['text' => $systemPrompt]]],
            ['role' => 'model', 'parts' => [['text' => 'Compreendo. Como assistente virtual da MindCare Angola, vou seguir as regras de formatação e conteúdo fornecidas.']]],
        ];

        foreach ($historico as $msg) {
            $role = $msg['role'] === 'assistant' ? 'model' : 'user';
            $contents[] = ['role' => $role, 'parts' => [['text' => $msg['text']]]];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $mensagem]]];

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key={$this->apiKey}", [
                    'contents' => $contents,
                ]);

            if ($response->failed()) {
                Log::error('Gemini API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return 'Desculpe, não consegui processar a sua mensagem agora. Por favor, tente novamente mais tarde.';
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (! $text) {
                return 'Desculpe, não consegui entender a sua pergunta. Pode reformular?';
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Gemini API exception', ['error' => $e->getMessage()]);

            return 'Estou com dificuldades técnicas no momento. Por favor, tente novamente mais tarde.';
        }
    }
}
