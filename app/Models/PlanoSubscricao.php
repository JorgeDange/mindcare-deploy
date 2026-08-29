<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanoSubscricao extends Model
{
    use HasFactory;

    protected $table = 'plano_subscricoes';

    protected $fillable = [
        'paciente_id',
        'plano_id',
        'sessoes_usadas',
        'data_inicio',
        'data_validade',
        'estado',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_validade' => 'date',
        'sessoes_usadas' => 'integer',
    ];

    public function sessoesDisponivel(): int
    {
        if (! $this->relationLoaded('plano')) {
            return max(0, ($this->plano()->value('sessoes_total') ?? 0) - $this->sessoes_usadas);
        }

        return max(0, ($this->plano->sessoes_total ?? 0) - $this->sessoes_usadas);
    }

    public function esgotada(): bool
    {
        return $this->sessoesDisponivel() <= 0;
    }

    public function ativa(): bool
    {
        return $this->estado === 'Activo' && $this->data_validade >= now()->startOfDay();
    }

    public function scopeActiva(Builder $query): void
    {
        $query->where('estado', 'Activo')->where('data_validade', '>=', now()->startOfDay());
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }
}
