<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'profissional_id',
        'motivo_consulta',
        'condicoes',
        'diagnostico',
        'medicacao',
        'medicacao_atual',
        'observacoes',
        'observacoes_profissional',
        'historico_familiar',
        'plano_terapeutico',
        'data_inicio',
        'preferencias',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'preferencias' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profissional(): BelongsTo
    {
        return $this->belongsTo(Profissional::class);
    }

    public function subscricoes(): HasMany
    {
        return $this->hasMany(PlanoSubscricao::class);
    }

    public function subscricaoActiva(): HasOne
    {
        return $this->hasOne(PlanoSubscricao::class)->where('estado', 'Activo');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class);
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }

    public function conversas(): HasMany
    {
        return $this->hasMany(Conversa::class);
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class);
    }
}
