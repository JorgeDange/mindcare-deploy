@extends('layouts.profissional')

@section('title', 'Agenda — Profissional')
@section('page_title', 'Agenda')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Navigation -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('profissional.agenda', ['semana' => $inicio->copy()->subWeek()->toDateString()]) }}"
               class="px-4 py-2 text-sm font-medium text-on-surface-variant bg-white border border-outline-variant/30 rounded-lg hover:bg-surface-variant transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span> Semana Anterior
            </a>
            <a href="{{ route('profissional.agenda', ['semana' => $inicio->copy()->addWeek()->toDateString()]) }}"
               class="px-4 py-2 text-sm font-medium text-on-surface-variant bg-white border border-outline-variant/30 rounded-lg hover:bg-surface-variant transition-colors flex items-center gap-1">
                Próxima Semana <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>
        </div>
        <div class="text-body-sm text-on-surface-variant font-medium">
            {{ $inicio->format('d/m/Y') }} — {{ $fim->format('d/m/Y') }}
        </div>
        <button onclick="openAgendaModal()"
                class="px-5 py-2 text-sm font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">add</span> Nova Consulta
        </button>
    </div>

    <!-- Weekly Calendar Grid -->
    <div class="grid grid-cols-7 gap-px bg-outline-variant/30 rounded-xl overflow-hidden shadow-sm border border-outline-variant/30">
        @php
            $diasSemana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
            $hoje = now()->toDateString();
        @endphp
        @foreach($diasSemana as $i => $nome)
            @php
                $data = $inicio->copy()->addDays($i);
                $dataStr = $data->toDateString();
                $consultasDoDia = $consultasPorDia->get($dataStr, collect());
                $isHoje = $dataStr === $hoje;
            @endphp
            <div class="bg-white min-h-[300px] {{ $isHoje ? 'ring-2 ring-primary ring-inset' : '' }}">
                <div class="px-3 py-2 border-b border-outline-variant/20 {{ $isHoje ? 'bg-primary text-on-primary' : 'bg-surface-container-low' }}">
                    <p class="text-xs font-semibold {{ $isHoje ? 'text-on-primary' : 'text-on-surface-variant' }} uppercase">{{ $nome }}</p>
                    <p class="text-lg font-bold {{ $isHoje ? 'text-on-primary' : 'text-on-surface' }}">{{ $data->format('d') }}</p>
                </div>
                <div class="p-2 space-y-2">
                    @forelse($consultasDoDia as $consulta)
                        @php
                            $user = $consulta->paciente?->user;
                            $badgeClasses = [
                                'Agendada' => 'bg-secondary-container text-on-secondary-container',
                                'Realizada' => 'bg-primary-fixed text-on-primary-fixed',
                                'Faltou' => 'bg-amber-50 text-amber-800',
                                'Cancelada' => 'bg-error-container text-on-error-container',
                            ];
                            $badgeClasse = $badgeClasses[$consulta->estado] ?? 'bg-surface-variant text-on-surface-variant';
                            $cardBg = $consulta->estado === 'Cancelada' ? 'bg-error-container/20 opacity-60' : ($consulta->estado === 'Realizada' ? 'bg-surface-container-low' : 'bg-surface-container-lowest');
                        @endphp
                        <div class="p-2 rounded-lg text-xs {{ $cardBg }}">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-on-surface">{{ \Carbon\Carbon::parse($consulta->hora)->format('H:i') }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded-full font-medium {{ $badgeClasse }}">
                                    {{ $consulta->estado }}
                                </span>
                            </div>
                            <p class="font-medium text-on-surface truncate">{{ $user?->name ?? 'Paciente' }}</p>
                            <p class="text-on-surface-variant truncate">{{ $consulta->tipo }}</p>
                            @if(in_array($consulta->estado, ['Agendada']))
                                <div class="mt-1.5 pt-1.5 border-t border-secondary-container/30 flex gap-1">
                                    @if(!$consulta->confirmada)
                                        <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="estado" value="confirmada">
                                            <button class="text-[10px] text-green-600 hover:text-green-800 font-medium">Confirmar</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="estado" value="realizada">
                                            <button class="text-[10px] text-green-600 hover:text-green-800 font-medium">Realizar</button>
                                        </form>
                                        <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="estado" value="falta">
                                            <button class="text-[10px] text-amber-600 hover:text-amber-800 font-medium">Faltou</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('profissional.consultas.estado', $consulta) }}" class="inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="estado" value="cancelada">
                                        <button class="text-[10px] text-red-600 hover:text-red-800 font-medium">Cancelar</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-4 text-on-surface-variant/30">
                            <span class="material-symbols-outlined text-lg">calendar_month</span>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Nova Consulta Modal -->
<div id="nova-consulta-modal" class="hidden fixed inset-0 z-[10000] flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/30 flex items-center justify-between">
            <h2 class="text-lg font-bold text-on-surface">Nova Consulta</h2>
            <button onclick="closeAgendaModal()" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form method="POST" action="{{ route('profissional.consultas.store') }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1">Paciente</label>
                <select name="paciente_id" required class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                    <option value="">Seleccionar paciente...</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}">{{ $p->user?->name ?? 'Paciente #'.$p->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-1">Data</label>
                    <input type="date" name="data" required value="{{ old('data', now()->toDateString()) }}"
                           class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-1">Hora</label>
                    <input type="time" name="hora" required value="{{ old('hora') }}"
                           class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-1">Tipo</label>
                    <select name="tipo" required class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                        <option value="Individual">Individual</option>
                        <option value="Casal">Casal</option>
                        <option value="Familiar">Familiar</option>
                        <option value="Avaliação Inicial">Avaliação Inicial</option>
                        <option value="Grupo">Grupo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-1">Modalidade</label>
                    <select name="modalidade" required class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                        <option value="online">Online</option>
                        <option value="presencial">Presencial</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest" placeholder="Notas opcionais...">{{ old('observacoes') }}</textarea>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeAgendaModal()"
                        class="px-4 py-2 text-sm font-medium text-on-surface-variant bg-surface-variant rounded-lg hover:bg-surface-container-high transition-colors">Cancelar</button>
                <button type="submit" class="px-6 py-2 text-sm font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">event</span> Agendar Consulta
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const agendaModal = document.getElementById('nova-consulta-modal');
    if (agendaModal) {
        agendaModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    }
    function openAgendaModal() {
        const el = document.getElementById('nova-consulta-modal');
        if (el) {
            el.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeAgendaModal() {
        const el = document.getElementById('nova-consulta-modal');
        if (el) {
            el.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAgendaModal();
    });
</script>
@endpush
@endsection
