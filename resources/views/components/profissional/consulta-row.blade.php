@props(['consulta'])

@php
    $paciente = $consulta->paciente;
    $user = $paciente?->user;
    $estados = [
        'Agendada' => 'bg-secondary-container text-on-secondary-container',
        'Realizada' => 'bg-primary-fixed text-on-primary-fixed',
        'Cancelada' => 'bg-error-container text-on-error-container',
        'Faltou' => 'bg-amber-50 text-amber-800',
    ];
    $badgeClasse = $estados[$consulta->estado] ?? 'bg-surface-variant text-on-surface-variant';
@endphp

<tr class="border-b border-outline-variant/20 hover:bg-surface-container-low transition-colors">
    <td class="py-3 px-4">
        <div class="flex items-center gap-3">
            @if($user?->foto_perfil)
                <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto"
                     class="w-9 h-9 rounded-full object-cover">
            @else
                <div class="w-9 h-9 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-xs font-bold">
                    {{ $user?->iniciais ?? '?' }}
                </div>
            @endif
            <div>
                <p class="text-body-sm font-medium text-on-surface">{{ $user?->name ?? 'Paciente' }}</p>
                <p class="text-xs text-on-surface-variant">{{ $paciente?->motivo_consulta ?? '' }}</p>
            </div>
        </div>
    </td>
    <td class="py-3 px-4 text-body-sm text-on-surface whitespace-nowrap">
        {{ \Carbon\Carbon::parse($consulta->data)->format('d/m/Y') }}
    </td>
    <td class="py-3 px-4 text-body-sm text-on-surface whitespace-nowrap">
        {{ \Carbon\Carbon::parse($consulta->hora)->format('H:i') }}
    </td>
    <td class="py-3 px-4">
        <span class="font-label-md font-semibold px-3 py-1 rounded-full text-[11px] {{ $badgeClasse }}">
            {{ $consulta->estado }}
        </span>
    </td>
    <td class="py-3 px-4">
        <div class="flex items-center gap-2">
            @if($consulta->estado === 'Agendada')
                @if(!$consulta->confirmada)
                    <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="estado" value="confirmada">
                        <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-medium">Confirmar</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="estado" value="realizada">
                        <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-medium">Realizar</button>
                    </form>
                    <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="estado" value="falta">
                        <button type="submit" class="text-xs text-amber-600 hover:text-amber-800 font-medium">Faltou</button>
                    </form>
                @endif
                <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="estado" value="cancelada">
                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Cancelar</button>
                </form>
            @endif
            <a href="{{ route('profissional.pacientes.show', $paciente) }}" class="text-xs text-primary hover:underline font-medium flex items-center gap-0.5">
                <span class="material-symbols-outlined text-[14px]">visibility</span>
            </a>
        </div>
    </td>
</tr>
