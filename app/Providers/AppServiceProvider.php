<?php

namespace App\Providers;

use App\Models\Consulta;
use App\Models\Documento;
use App\Models\Paciente;
use App\Models\Pagamento;
use App\Policies\ConsultaPolicy;
use App\Policies\DocumentoPolicy;
use App\Policies\PacientePolicy;
use App\Policies\PagamentoPolicy;
use App\Services\Contracts\AiServiceInterface;
use App\Services\GeminiService;
use App\Services\OllamaService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AiServiceInterface::class,
            fn () => match (config('services.chatbot.driver', 'ollama')) {
                'gemini' => app(GeminiService::class),
                default => app(OllamaService::class),
            }
        );
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            logger()->error('LazyLoadingViolation', [
                'model' => get_class($model),
                'relation' => $relation,
                'model_id' => $model->getKey(),
                'trace' => (new \Exception)->getTraceAsString(),
            ]);
            throw new \Illuminate\Database\LazyLoadingViolationException($model, $relation);
        });

        Gate::policy(Consulta::class, ConsultaPolicy::class);
        Gate::policy(Documento::class, DocumentoPolicy::class);
        Gate::policy(Paciente::class, PacientePolicy::class);
        Gate::policy(Pagamento::class, PagamentoPolicy::class);

        RateLimiter::for('uploads', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('mensagens', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });

        Paginator::useTailwind();
    }
}
