<?php

namespace App\Policies;

use App\Models\Paciente;
use App\Models\User;

class PacientePolicy
{
    public function view(User $user, Paciente $paciente): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPaciente()) {
            return $paciente->user_id === $user->id;
        }

        if ($user->isProfissional()) {
            return $paciente->profissional_id === $user->profissional?->id;
        }

        return false;
    }

    public function update(User $user, Paciente $paciente): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPaciente()) {
            return $paciente->user_id === $user->id;
        }

        if ($user->isProfissional()) {
            return $paciente->profissional_id === $user->profissional?->id;
        }

        return false;
    }

    public function viewFicha(User $user, Paciente $paciente): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isProfissional()) {
            return $paciente->profissional_id === $user->profissional?->id;
        }

        return false;
    }

    public function updateFicha(User $user, Paciente $paciente): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isProfissional()) {
            return $paciente->profissional_id === $user->profissional?->id;
        }

        return false;
    }
}
