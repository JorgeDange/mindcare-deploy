<?php

use App\Models\Conversa;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversa.{conversaId}', function (User $user, int $conversaId) {
    $conversa = Conversa::find($conversaId);
    if (! $conversa) {
        return false;
    }

    $isPaciente = $conversa->paciente?->user_id === $user->id;
    $isProfissional = $conversa->profissional?->user_id === $user->id;

    return $isPaciente || $isProfissional;
});
