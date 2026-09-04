@extends('layouts.profissional')

@section('title', 'Pacientes — Profissional')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <header class="mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Meus Pacientes</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">{{ $pacientes->count() }} paciente(s) atribuído(s) a si.</p>
    </header>

    <!-- Search -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="material-symbols-outlined absolute left-4 inset-y-0 my-auto flex items-center text-on-surface-variant">search</span>
            <input type="text" id="search-pacientes" placeholder="Pesquisar por nome..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-outline-variant/30 bg-white text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none shadow-sm">
        </div>
    </div>

    <!-- Pacientes Grid -->
    <div id="pacientes-grid" class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
        @forelse($pacientes as $paciente)
            @php
                $user = $paciente->user;
                $plano = $paciente->subscricaoActiva?->plano;
                $sessoesRestantes = $paciente->sessoes_restantes;
                $sessoesClasse = $sessoesRestantes > 2
                    ? 'bg-primary-fixed text-on-primary-fixed'
                    : ($sessoesRestantes > 0 ? 'bg-amber-50 text-amber-800' : 'bg-error-container text-on-error-container');
            @endphp
            <div class="bg-white rounded-xl p-5 shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow"
                 data-nome="{{ strtolower($user?->name ?? '') }}">
                @if($user?->foto_perfil)
                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto"
                         class="w-12 h-12 rounded-full object-cover flex-shrink-0" loading="lazy" decoding="async">
                @else
                    <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-sm font-bold flex-shrink-0">
                        {{ $user?->iniciais ?? '?' }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-body-md font-bold text-on-surface truncate">{{ $user?->name ?? 'Paciente' }}</p>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                        @if($plano)
                            <span class="font-label-md font-semibold px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px]">
                                {{ $plano->nome }}
                            </span>
                            <span class="font-label-md font-semibold px-2.5 py-0.5 rounded-full {{ $sessoesClasse }} text-[11px]">
                                {{ $sessoesRestantes }} {{ $sessoesRestantes === 1 ? 'sessão' : 'sessões' }}
                            </span>
                        @else
                            <span class="font-label-md font-semibold px-2.5 py-0.5 rounded-full bg-surface-variant text-on-surface-variant text-[11px]">
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
        @empty
            <div class="col-span-full text-center py-16 text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl opacity-30 mb-4 block">groups</span>
                <p class="text-body-sm">Nenhum paciente atribuído.</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('search-pacientes')?.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        document.querySelectorAll('#pacientes-grid > div').forEach(el => {
            const nome = el.dataset.nome || '';
            el.style.display = nome.includes(term) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection
