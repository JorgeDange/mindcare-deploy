@extends('layouts.profissional')

@section('title', 'Ficha Clínica — ' . ($paciente->user?->name ?? 'Paciente'))

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Read-only Personal Data -->
    <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 p-6 mb-6">
        <div class="flex items-center gap-4 mb-4">
            @if($paciente->user?->foto_perfil)
                <img src="{{ asset('storage/' . $paciente->user->foto_perfil) }}" alt="Foto"
                     class="w-14 h-14 rounded-full object-cover" loading="lazy" decoding="async">
            @else
                <div class="w-14 h-14 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-lg font-bold">
                    {{ $paciente->user?->iniciais ?? '?' }}
                </div>
            @endif
            <div>
                <h2 class="font-title-lg text-title-lg text-on-surface">{{ $paciente->user?->name }}</h2>
                <p class="text-body-sm text-on-surface-variant">{{ $paciente->user?->email }} · 
                    {{ $paciente->user?->telefone ?? 'Sem telefone' }}</p>
            </div>
        </div>
        <div class="text-xs text-on-surface-variant flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">lock</span>
            <span>Dados pessoais — apenas leitura</span>
        </div>
    </div>

    <!-- Ficha Clínica Form -->
    <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/30">
            <h3 class="font-title-lg text-title-lg text-on-surface">Ficha Clínica</h3>
        </div>
        <form method="POST" action="{{ route('profissional.pacientes.ficha.update', $paciente) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Diagnóstico</label>
                <textarea name="diagnostico" rows="3"
                    class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">{{ old('diagnostico', $paciente->diagnostico) }}</textarea>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Medicação Actual</label>
                <textarea name="medicacao_atual" rows="3"
                    class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">{{ old('medicacao_atual', $paciente->medicacao_atual) }}</textarea>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Histórico Familiar</label>
                <textarea name="historico_familiar" rows="3"
                    class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">{{ old('historico_familiar', $paciente->historico_familiar) }}</textarea>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Observações do Profissional</label>
                <textarea name="observacoes_profissional" rows="4"
                    class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">{{ old('observacoes_profissional', $paciente->observacoes_profissional) }}</textarea>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Plano Terapêutico</label>
                <textarea name="plano_terapeutico" rows="4"
                    class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">{{ old('plano_terapeutico', $paciente->plano_terapeutico) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('profissional.pacientes.show', $paciente) }}"
                   class="px-4 py-2 text-body-sm font-medium text-on-surface-variant bg-surface-variant rounded-lg hover:bg-surface-container-high transition-colors">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-body-sm font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">save</span> Guardar Ficha
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
