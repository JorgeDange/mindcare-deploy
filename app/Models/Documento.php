<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'paciente_id',
        'partilhado_por',
        'nome',
        'tipo',
        'categoria',
        'descricao',
        'caminho',
        'tamanho',
        'novo',
    ];

    protected $casts = [
        'novo' => 'boolean',
        'tamanho' => 'integer',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function partilhadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partilhado_por');
    }
}
