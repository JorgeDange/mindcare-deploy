@props(['paciente'])

@php
    $user = $paciente->user;
    $plano = $paciente->subscricaoActiva?->plano;
    $sessoesRestantes = $plano ? ($plano->sessoes_total - ($paciente->subscricaoActiva->sessoes_usadas ?? 0)) : 0;
@endphp

<div class="bg-white rounded-xl p-5 shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 flex items-center gap-4">
    @if($user?->foto_perfil)
        <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto"
             class="w-12 h-12 rounded-full object-cover flex-shrink-0">
    @else
        <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-sm font-bold flex-shrink-0">
            {{ $user?->iniciais ?? '?' }}
        </div>
    @endif
    <div class="flex-1 min-w-0">
        <p class="text-body-md font-bold text-on-surface truncate">{{ $user?->name ?? 'Paciente' }}</p>
        <div class="flex items-center gap-2 mt-1">
            @if($plano)
                <span class="font-label-md font-semibold px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px]">
                    {{ $plano->nome }}
                </span>
                <span class="text-xs text-on-surface-variant">{{ $sessoesRestantes }} sessões restantes</span>
            @else
                <span class="font-label-md font-semibold px-2 py-0.5 rounded-full bg-surface-variant text-on-surface-variant text-[11px]">
                    Sem plano
                </span>
            @endif
        </div>
    </div>
    <a href="{{ route('profissional.pacientes.show', $paciente) }}"
       class="text-label-md font-medium text-primary hover:underline whitespace-nowrap flex-shrink-0 flex items-center gap-1">
        Ver perfil <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
    </a>
</div>
