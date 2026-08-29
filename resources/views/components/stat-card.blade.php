@props(['titulo', 'valor', 'icone', 'cor' => 'blue', 'variacao' => null, 'link' => null])

@php
    $cores = [
        'blue' => ['bg' => 'bg-blue-50', 'icone' => 'text-blue-600', 'valor' => 'text-blue-900'],
        'green' => ['bg' => 'bg-green-50', 'icone' => 'text-green-600', 'valor' => 'text-green-900'],
        'amber' => ['bg' => 'bg-amber-50', 'icone' => 'text-amber-600', 'valor' => 'text-amber-900'],
        'rose' => ['bg' => 'bg-rose-50', 'icone' => 'text-rose-600', 'valor' => 'text-rose-900'],
        'purple' => ['bg' => 'bg-purple-50', 'icone' => 'text-purple-600', 'valor' => 'text-purple-900'],
        'teal' => ['bg' => 'bg-teal-50', 'icone' => 'text-teal-600', 'valor' => 'text-teal-900'],
    ];
    $esquema = $cores[$cor] ?? $cores['blue'];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 {{ $link ? 'cursor-pointer hover:shadow-md transition-shadow' : '' }}"
     @if($link) onclick="window.location='{{ $link }}'" @endif>
    <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $titulo }}</span>
        <div class="w-9 h-9 rounded-lg {{ $esquema['bg'] }} flex items-center justify-center">
            <i class="fa-solid {{ $icone }} {{ $esquema['icone'] }}"></i>
        </div>
    </div>
    <p class="text-2xl font-bold {{ $esquema['valor'] }}">{{ $valor }}</p>
    @if($variacao)
        <p class="text-xs text-gray-500 mt-1">{{ $variacao }}</p>
    @endif
</div>