<?php

namespace App\Policies;

use App\Models\Consulta;
use App\Models\User;

class ConsultaPolicy
{
    public function view(User $user, Consulta $consulta): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPaciente()) {
            return $consulta->paciente_id === $user->paciente?->id;
        }

        if ($user->isProfissional()) {
            return $consulta->profissional_id === $user->profissional?->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isPaciente() || $user->isProfissional();
    }

    public function update(User $user, Consulta $consulta): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isProfissional()) {
            return $consulta->profissional_id === $user->profissional?->id;
        }

        return false;
    }

    public function delete(User $user, Consulta $consulta): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPaciente()) {
            return $consulta->paciente_id === $user->paciente?->id;
        }

        return false;
    }

    public function updateEstado(User $user, Consulta $consulta): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isProfissional()) {
            return $consulta->profissional_id === $user->profissional?->id;
        }

        return false;
    }
}
