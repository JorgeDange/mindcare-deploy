@extends('layouts.profissional')

@section('title', 'Nova Conversa — Profissional')

@section('content')
<div class="max-w-lg mx-auto py-10 px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/20">
            <h1 class="text-xl font-bold text-on-surface">Nova Conversa</h1>
            <p class="text-sm text-on-surface-variant mt-1">Seleccione o paciente para iniciar uma conversa.</p>
        </div>

        <form action="{{ route('profissional.mensagens.nova.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="paciente_id" class="block text-sm font-bold text-on-surface-variant mb-2">Paciente</label>
                <select name="paciente_id" id="paciente_id" required
                        class="w-full border border-outline-variant/40 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-surface">
                    <option value="">Selecione um paciente...</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                            {{ $paciente->user->name ?? 'Paciente #' . $paciente->id }}
                        </option>
                    @endforeach
                </select>
                @error('paciente_id')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <a href="{{ route('profissional.mensagens.index') }}"
                   class="flex-1 border border-outline text-on-surface font-bold py-3 px-4 rounded-xl hover:bg-surface-variant transition-all text-center">
                    Cancelar
                </a>
                <button type="submit"
                        class="flex-1 bg-primary text-on-primary font-bold py-3 px-4 rounded-xl shadow-md hover:opacity-90 active:scale-95 transition-all">
                    Iniciar Conversa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
