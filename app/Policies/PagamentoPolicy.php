<?php

namespace App\Policies;

use App\Models\Pagamento;
use App\Models\User;

class PagamentoPolicy
{
    public function view(User $user, Pagamento $pagamento): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPaciente()) {
            return $pagamento->paciente_id === $user->paciente?->id;
        }

        return false;
    }

    public function aprovar(User $user): bool
    {
        return $user->isAdmin();
    }

    public function recusar(User $user): bool
    {
        return $user->isAdmin();
    }
}
