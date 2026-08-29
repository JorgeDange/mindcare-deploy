<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'publico',
        'descricao',
        'sessoes_total',
        'preco',
        'moeda',
        'beneficios',
        'activo',
    ];

    protected $casts = [
        'beneficios' => 'array',
        'activo' => 'boolean',
        'preco' => 'decimal:2',
    ];

    public function subscricoes(): HasMany
    {
        return $this->hasMany(PlanoSubscricao::class);
    }
}
