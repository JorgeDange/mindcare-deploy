<?php

namespace App\Policies;

use App\Models\Documento;
use App\Models\User;

class DocumentoPolicy
{
    public function view(User $user, Documento $documento): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPaciente()) {
            return $documento->paciente_id === $user->paciente?->id;
        }

        if ($user->isProfissional()) {
            return $documento->paciente?->profissional_id === $user->profissional?->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isProfissional() || $user->isAdmin();
    }

    public function delete(User $user, Documento $documento): bool
    {
        return $user->isAdmin();
    }
}
