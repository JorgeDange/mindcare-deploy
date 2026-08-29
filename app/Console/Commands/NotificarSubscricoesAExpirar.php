<?php

namespace App\Console\Commands;

use App\Models\PlanoSubscricao;
use App\Notifications\SubscricaoAExpirar;
use Illuminate\Console\Command;

class NotificarSubscricoesAExpirar extends Command
{
    protected $signature = 'subscricoes:notificar-a-expirar';

    protected $description = 'Notifica pacientes cujas subscrições expiram em 7 dias';

    public function handle(): void
    {
        $alvo = now()->addDays(7)->startOfDay();

        $subscricoes = PlanoSubscricao::where('estado', 'Activo')
            ->whereDate('data_validade', $alvo)
            ->with('paciente.user')
            ->get();

        $count = 0;
        foreach ($subscricoes as $subscricao) {
            $user = $subscricao->paciente?->user;
            if (! $user) {
                continue;
            }

            $user->notify(new SubscricaoAExpirar($subscricao, 7));
            $count++;
        }

        $this->info("Notificações enviadas para {$count} subscrição(ões) a expirar.");
    }
}
