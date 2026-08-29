<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'plano_id',
        'plano_subscricao_id',
        'valor',
        'moeda',
        'metodo',
        'estado',
        'data_pagamento',
        'referencia',
        'comprovativo_path',
        'aprovado_por',
        'aprovado_em',
        'notas_admin',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_pagamento' => 'date',
        'aprovado_em' => 'datetime',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }

    public function subscricao(): BelongsTo
    {
        return $this->belongsTo(PlanoSubscricao::class, 'plano_subscricao_id');
    }

    public function aprovadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }
}
