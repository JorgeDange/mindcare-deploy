<?php

namespace App\Services;

use App\Services\Contracts\AiServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService implements AiServiceInterface
{
    protected string $baseUrl;

    protected string $model;

    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.ollama.url', env('OLLAMA_URL', 'https://ollama.com')), '/');
        $this->model = config('services.ollama.model', env('OLLAMA_MODEL', 'gpt-oss:120b'));
        $this->apiKey = config('services.ollama.api_key', env('OLLAMA_API_KEY'));
    }

    public function chat(string $mensagem, array $historico = []): string
    {
        $messages = [
            ['role' => 'system', 'content' => SystemPrompt::build()],
        ];

        foreach ($historico as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'assistant' ? 'assistant' : 'user',
                'content' => $msg['text'],
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $mensagem];

        try {
            $headers = ['Content-Type' => 'application/json'];
            if ($this->apiKey) {
                $headers['Authorization'] = 'Bearer '.$this->apiKey;
            }

            $response = Http::withHeaders($headers)
                ->timeout(60)
                ->post("{$this->baseUrl}/api/chat", [
                    'model' => $this->model,
                    'messages' => $messages,
                    'stream' => false,
                ]);

            if ($response->failed()) {
                Log::error('Ollama API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return 'Desculpe, não consegui processar a sua mensagem agora. Por favor, tente novamente mais tarde.';
            }

            $data = $response->json();
            $text = $data['message']['content'] ?? null;

            if (! $text) {
                return 'Desculpe, não consegui entender a sua pergunta. Pode reformular?';
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Ollama API exception', ['error' => $e->getMessage()]);

            return 'Estou com dificuldades técnicas no momento. Por favor, tente novamente mais tarde.';
        }
    }
}
