@extends('layouts.profissional')

@section('title', 'Documentos — Profissional')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <header class="mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Documentos</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Gerir documentos clínicos dos seus pacientes.</p>
    </header>

    <!-- Filters -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <select id="filter-paciente" class="rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-white">
                <option value="">Todos os Pacientes</option>
                @foreach($pacientes as $p)
                    <option value="{{ $p->id }}">{{ $p->user?->name }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-2 text-body-sm">
                <label class="flex items-center gap-1 cursor-pointer text-on-surface-variant">
                    <input type="checkbox" value="relatorio" class="filter-categoria rounded border-outline-variant text-primary focus:ring-primary"> Relatório
                </label>
                <label class="flex items-center gap-1 cursor-pointer text-on-surface-variant">
                    <input type="checkbox" value="receita" class="filter-categoria rounded border-outline-variant text-primary focus:ring-primary"> Receita
                </label>
                <label class="flex items-center gap-1 cursor-pointer text-on-surface-variant">
                    <input type="checkbox" value="atestado" class="filter-categoria rounded border-outline-variant text-primary focus:ring-primary"> Atestado
                </label>
                <label class="flex items-center gap-1 cursor-pointer text-on-surface-variant">
                    <input type="checkbox" value="outro" class="filter-categoria rounded border-outline-variant text-primary focus:ring-primary"> Outro
                </label>
            </div>
        </div>
        <button onclick="document.getElementById('novo-documento-modal').classList.remove('hidden')"
                class="px-5 py-2 text-sm font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">add</span> Novo Documento
        </button>
    </div>

    <!-- Documentos Table -->
    <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 overflow-hidden">
        @if($documentos->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-body-sm">
                <thead>
                    <tr class="bg-surface-container-low text-left font-label-md text-on-surface-variant uppercase tracking-wider">
                        <th class="py-3 px-4">Documento</th>
                        <th class="py-3 px-4">Paciente</th>
                        <th class="py-3 px-4">Categoria</th>
                        <th class="py-3 px-4">Data</th>
                        <th class="py-3 px-4">Tamanho</th>
                        <th class="py-3 px-4">Acções</th>
                    </tr>
                </thead>
                <tbody id="documentos-tbody">
                    @foreach($documentos as $doc)
                        @php
                            $tamanhos = ['B', 'KB', 'MB', 'GB'];
                            $tamanho = $doc->tamanho;
                            $ordem = 0;
                            while ($tamanho >= 1024 && $ordem < count($tamanhos) - 1) {
                                $tamanho /= 1024;
                                $ordem++;
                            }
                            $tamanhoFormatado = round($tamanho, 1) . ' ' . $tamanhos[$ordem];
                            $categoriaLabels = [
                                'relatorio' => ['Relatório', 'bg-secondary-container text-on-secondary-container'],
                                'receita' => ['Receita', 'bg-primary-fixed text-on-primary-fixed'],
                                'atestado' => ['Atestado', 'bg-amber-50 text-amber-800'],
                                'outro' => ['Outro', 'bg-surface-variant text-on-surface-variant'],
                            ];
                            $catInfo = $categoriaLabels[$doc->categoria] ?? ['Outro', 'bg-surface-variant text-on-surface-variant'];
                        @endphp
                        <tr class="border-b border-outline-variant/20 hover:bg-surface-container-low transition-colors documento-row"
                            data-paciente="{{ $doc->paciente_id }}"
                            data-categoria="{{ $doc->categoria ?? '' }}">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-error-container/30 flex items-center justify-center flex-shrink-0">
                                        <span class="material-symbols-outlined text-error text-[18px]">description</span>
                                    </div>
                                    <div>
                                        <p class="text-body-sm font-medium text-on-surface">{{ $doc->nome }}</p>
                                        @if($doc->descricao)
                                            <p class="text-xs text-on-surface-variant truncate max-w-[200px]">{{ $doc->descricao }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-body-sm text-on-surface-variant">{{ $doc->paciente?->user?->name ?? '—' }}</td>
                            <td class="py-3 px-4">
                                <span class="font-label-md font-semibold px-2.5 py-1 rounded-full text-[11px] {{ $catInfo[1] }}">
                                    {{ $catInfo[0] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-body-sm text-on-surface-variant whitespace-nowrap">{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 text-body-sm text-on-surface-variant">{{ $tamanhoFormatado }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('profissional.documentos.download', $doc) }}"
                                   class="font-label-md font-medium text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">download</span> Download
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-outline-variant/20">
            {{ $documentos->links() }}
        </div>
        @else
        <div class="p-12 text-center text-on-surface-variant">
            <span class="material-symbols-outlined text-4xl opacity-30 mb-4 block">folder_open</span>
            <p class="text-body-sm">Nenhum documento encontrado.</p>
        </div>
        @endif
    </div>
</div>

<!-- Novo Documento Modal -->
<div id="novo-documento-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/30 flex items-center justify-between">
            <h2 class="text-lg font-bold text-on-surface">Novo Documento</h2>
            <button onclick="document.getElementById('novo-documento-modal').classList.add('hidden')" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form method="POST" action="{{ route('profissional.documentos.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Paciente</label>
                <select name="paciente_id" required class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                    <option value="">Seleccionar paciente...</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}">{{ $p->user?->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Título</label>
                <input type="text" name="titulo" required maxlength="255"
                       class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Categoria</label>
                <select name="categoria" required class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest">
                    <option value="">Seleccionar categoria...</option>
                    <option value="relatorio">Relatório</option>
                    <option value="receita">Receita</option>
                    <option value="atestado">Atestado</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Descrição <span class="text-on-surface-variant">(opcional)</span></label>
                <textarea name="descricao" rows="2" maxlength="500"
                    class="w-full rounded-lg border border-outline-variant/50 px-3 py-2 text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none bg-surface-container-lowest"></textarea>
            </div>

            <div>
                <label class="block text-body-sm font-medium text-on-surface mb-1">Ficheiro (PDF, máx 10MB)</label>
                <input type="file" name="ficheiro" accept=".pdf,application/pdf" required
                       class="w-full text-body-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-on-primary hover:file:opacity-90 cursor-pointer">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('novo-documento-modal').classList.add('hidden')"
                        class="px-4 py-2 text-body-sm font-medium text-on-surface-variant bg-surface-variant rounded-lg hover:bg-surface-container-high transition-colors">Cancelar</button>
                <button type="submit" class="px-6 py-2 text-body-sm font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">upload</span> Enviar Documento
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function filterDocumentos() {
        const pacienteId = document.getElementById('filter-paciente')?.value;
        const categoriasAtivas = [...document.querySelectorAll('.filter-categoria:checked')].map(cb => cb.value);

        document.querySelectorAll('.documento-row').forEach(row => {
            const rowPaciente = row.dataset.paciente;
            const rowCategoria = row.dataset.categoria;
            let show = true;

            if (pacienteId && rowPaciente !== pacienteId) show = false;
            if (categoriasAtivas.length > 0 && !categoriasAtivas.includes(rowCategoria)) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    document.getElementById('filter-paciente')?.addEventListener('change', filterDocumentos);
    document.querySelectorAll('.filter-categoria').forEach(cb => cb.addEventListener('change', filterDocumentos));

    document.getElementById('novo-documento-modal')?.addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
</script>
@endpush
@endsection
