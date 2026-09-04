@extends('layouts.profissional')

@section('title', 'Perfil — Profissional')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Informações do Utilizador -->
    <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-outline-variant/30 flex items-center gap-4">
            @if($user->foto_perfil)
                <img src="{{ Storage::url($user->foto_perfil) }}" class="w-14 h-14 rounded-full object-cover" loading="lazy" decoding="async">
            @else
                <div class="w-14 h-14 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="font-title-lg text-title-lg text-on-surface">{{ $user->name }}</h2>
                <p class="text-body-sm text-on-surface-variant">{{ $user->email }} · {{ $user->profissional?->especialidade ?? 'Profissional' }}</p>
            </div>
        </div>
        <div class="p-6 space-y-3 text-body-sm">
            <div><span class="font-medium text-on-surface">Telefone:</span> <span class="text-on-surface-variant">{{ $user->telefone ?? '—' }}</span></div>
            <div><span class="font-medium text-on-surface">Membro desde:</span> <span class="text-on-surface-variant">{{ $user->created_at->format('d/m/Y') }}</span></div>
        </div>
    </div>

    <!-- Autenticação de Dois Factores -->
    <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-outline-variant/30">
            <h2 class="font-title-lg text-title-lg text-on-surface">Autenticação de Dois Factores (2FA)</h2>
            <p class="text-body-sm text-on-surface-variant mt-1">Proteja a sua conta com uma camada extra de segurança.</p>
        </div>
        <div class="p-6">
            @if($user->two_factor_confirmed_at)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-primary-fixed">verified</span>
                        </div>
                        <div>
                            <p class="text-body-sm font-semibold text-on-surface">2FA Activo</p>
                            <p class="text-xs text-on-surface-variant">Configurado em {{ $user->two_factor_confirmed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('2fa.desativar') }}" onsubmit="return confirm('Tem a certeza que deseja desactivar o 2FA?')">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-center gap-2">
                            <input type="password" name="password" placeholder="Password actual" class="text-xs border border-outline-variant/50 rounded-lg px-3 py-1.5 outline-none focus:ring-2 focus:ring-primary/30" required>
                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-error bg-error-container/30 rounded-lg hover:bg-error-container/50 transition-colors">
                                Desactivar
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-surface-variant">shield</span>
                        </div>
                        <div>
                            <p class="text-body-sm font-semibold text-on-surface">2FA Não Configurado</p>
                            <p class="text-xs text-on-surface-variant">Recomendado para maior segurança.</p>
                        </div>
                    </div>
                    <a href="{{ route('2fa.ativar') }}" class="px-4 py-2 text-xs font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all">
                        Configurar
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
