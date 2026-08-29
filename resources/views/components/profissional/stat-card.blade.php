@props(['titulo', 'valor', 'icone', 'cor' => 'blue', 'descricao' => ''])

@php
    $cores = [
        'blue' => 'bg-secondary-container text-on-secondary-container',
        'green' => 'bg-primary-fixed text-on-primary-fixed',
        'amber' => 'bg-amber-50 text-amber-800',
        'rose' => 'bg-error-container/30 text-error',
        'purple' => 'bg-surface-variant text-on-surface-variant',
        'teal' => 'bg-primary-container text-on-primary-container',
    ];
    $corClasse = $cores[$cor] ?? $cores['blue'];
@endphp

<div class="bg-white rounded-xl p-5 shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 flex items-center gap-4">
    <div class="w-12 h-12 rounded-lg {{ $corClasse }} flex items-center justify-center flex-shrink-0">
        <span class="material-symbols-outlined">{{ $icone }}</span>
    </div>
    <div class="min-w-0">
        <p class="text-2xl font-bold text-on-surface">{{ $valor }}</p>
        <p class="text-body-sm text-on-surface-variant truncate">{{ $titulo }}</p>
        @if($descricao)
            <p class="text-xs text-on-surface-variant/70 mt-0.5">{{ $descricao }}</p>
        @endif
    </div>
</div>
