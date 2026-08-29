<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telefone',
        'telefone_alt',
        'data_nascimento',
        'genero',
        'bi_numero',
        'morada',
        'provincia',
        'foto_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'data_nascimento' => 'date',
        ];
    }

    // Relações
    public function paciente(): HasOne
    {
        return $this->hasOne(Paciente::class);
    }

    public function profissional(): HasOne
    {
        return $this->hasOne(Profissional::class);
    }

    // Helpers de Role
    public function isPaciente(): bool
    {
        return $this->role === 'paciente';
    }

    public function isProfissional(): bool
    {
        return $this->role === 'profissional';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Iniciais do Nome
    public function getIniciaisAttribute(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->take(2)->implode('');
    }

    // URL da Foto de Perfil
    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_perfil
            ? Storage::disk('public')->url($this->foto_perfil)
            : null;
    }
}
