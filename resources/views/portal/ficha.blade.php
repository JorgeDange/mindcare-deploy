@extends('layouts.portal')

@section('title', 'Ficha Clínica — MindCare')

@section('content')
<form action="{{ route('portal.ficha.update') }}" method="POST" id="ficha-form" class="space-y-stack-lg">
    @csrf
    @method('PUT')

    <!-- Sub-navigation: Horizontal Tabs -->
    <div class="-mx-gutter bg-white border-b border-outline-variant/30 px-gutter sticky top-[64px] z-30 mb-6">
        <div class="flex gap-8 overflow-x-auto custom-scrollbar whitespace-nowrap pb-2">
            <button type="button" id="btn-tab-info" class="py-4 font-bold text-primary border-b-2 border-primary flex items-center gap-2 tab-btn active" onclick="openFichaTab(event, 'tab-info')">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">person</span>
                <span>Pessoal</span>
            </button>
            <button type="button" id="btn-tab-clinica" class="py-4 text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2 tab-btn" onclick="openFichaTab(event, 'tab-clinica')">
                <span class="material-symbols-outlined text-[20px]">medical_information</span>
                <span>Clínicos</span>
            </button>
            <button type="button" id="btn-tab-hist" class="py-4 text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2 tab-btn" onclick="openFichaTab(event, 'tab-hist')">
                <span class="material-symbols-outlined text-[20px]">history</span>
                <span>Histórico</span>
            </button>
            <button type="button" id="btn-tab-docs" class="py-4 text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2 tab-btn" onclick="openFichaTab(event, 'tab-docs')">
                <span class="material-symbols-outlined text-[20px]">folder_open</span>
                <span>Ficheiros</span>
            </button>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-stack-lg">
        <div>
            <nav class="flex text-label-md text-on-surface-variant mb-2 gap-2">
                <span>Portal</span>
                <span>/</span>
                <span class="text-primary font-bold">Ficha Clínica</span>
            </nav>
            <h2 class="font-headline-lg text-headline-lg text-on-background">{{ Auth::user()->name }}</h2>
        </div>
        <div class="flex flex-col sm:flex-row w-full md:w-auto gap-stack-sm">
            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-6 h-[48px] border-2 border-outline text-on-surface rounded-lg font-bold flex items-center justify-center hover:bg-surface-variant transition-colors">Cancelar</a>
            <button type="submit" class="w-full sm:w-auto px-6 h-[48px] bg-primary text-on-primary rounded-lg font-bold hover:opacity-90 transition-opacity shadow-sm">Guardar Alterações</button>
        </div>
    </div>

    <!-- Bento Grid Layout for Patient Data -->
    <div class="grid grid-cols-12 gap-stack-md">
        
        <!-- Left Profile Column (Bento Item 1) -->
        <div class="col-span-12 lg:col-span-3 flex flex-col gap-stack-md">
            <div class="bg-surface-container-lowest rounded-xl p-stack-md flex flex-col items-center shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <div class="relative mb-4">
                    @if(Auth::user()->foto_perfil)
                        <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto" class="w-32 h-32 rounded-full object-cover border-4 border-surface-container shadow-md">
                    @else
                        <div class="w-32 h-32 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-3xl border-4 border-surface-container shadow-md">
                            {{ Auth::user()->iniciais ?? strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <a href="{{ route('perfil') }}" class="absolute bottom-0 right-0 bg-primary text-on-primary w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                        <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                    </a>
                </div>
                <span class="bg-surface-container-low text-on-secondary-fixed-variant px-3 py-1 rounded-full font-label-md text-label-md mb-2 font-bold">Paciente Activo</span>
                <p class="text-on-surface-variant text-body-sm">ID: #MC-{{ Auth::id() }}</p>
            </div>
            
            <div class="bg-surface-container-lowest rounded-xl p-stack-md shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <h4 class="font-title-lg text-title-lg text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    <span>Acesso Rápido</span>
                </h4>
                <div class="space-y-3">
                    @php
                        $ultConsulta = $paciente->consultas->where('estado', 'Realizada')->sortByDesc('data')->first();
                        $proxConsulta = $paciente->consultas->where('estado', 'Agendada')->sortBy('data')->first();
                    @endphp
                    <div class="flex justify-between items-center p-3 rounded-lg bg-background hover:bg-surface-variant transition-colors cursor-pointer group">
                        <span class="text-body-sm font-medium text-on-surface-variant">Última Consulta</span>
                        <span class="text-body-sm text-on-surface font-bold group-hover:text-primary">{{ $ultConsulta ? \Carbon\Carbon::parse($ultConsulta->data)->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 rounded-lg bg-background hover:bg-surface-variant transition-colors cursor-pointer group">
                        <span class="text-body-sm font-medium text-on-surface-variant">Próxima Consulta</span>
                        <span class="text-body-sm text-primary font-bold">{{ $proxConsulta ? \Carbon\Carbon::parse($proxConsulta->data)->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forms & Tab Contents Column (Bento Item 2) -->
        <div class="col-span-12 lg:col-span-9 bg-surface-container-lowest rounded-xl p-stack-lg shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
            
            <!-- TAB: Informações Pessoais -->
            <div id="tab-info" class="tab-content active">
                <h3 class="font-headline-md text-headline-md mb-stack-lg border-b border-outline-variant/30 pb-stack-sm text-primary">Dados Pessoais</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Full Name -->
                    <div class="md:col-span-2">
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Nome Completo</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md" type="text" name="name" value="{{ old('name', $paciente->user->name) }}" required />
                    </div>
                    
                    <!-- Email & BI -->
                    <div>
                        <label class="block font-body-sm font-bold text-on-surface mb-2">E-mail</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface-variant cursor-not-allowed outline-none text-body-md" type="email" value="{{ $paciente->user->email }}" disabled />
                    </div>
                    <div>
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Número de BI / NIF</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md" type="text" name="bi_numero" value="{{ old('bi_numero', $paciente->user->bi_numero) }}" />
                    </div>
                    
                    <!-- Phone & Date of Birth -->
                    <div>
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Telefone</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md" type="tel" name="telefone" value="{{ old('telefone', $paciente->user->telefone) }}" placeholder="+244 900 000 000" />
                    </div>
                    <div>
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Data de Nascimento</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md" type="date" name="data_nascimento" value="{{ old('data_nascimento', optional($paciente->user->data_nascimento)->format('Y-m-d')) }}" />
                    </div>
                    
                    <!-- Gender & Province -->
                    <div>
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Género</label>
                        <select name="genero" class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md">
                            <option value="">Seleccionar</option>
                            <option value="Masculino" @selected(old('genero', $paciente->user->genero) === 'Masculino')>Masculino</option>
                            <option value="Feminino" @selected(old('genero', $paciente->user->genero) === 'Feminino')>Feminino</option>
                            <option value="Outro" @selected(old('genero', $paciente->user->genero) === 'Outro')>Outro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Província / Cidade</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md" type="text" name="provincia" value="{{ old('provincia', $paciente->user->provincia) }}" />
                    </div>
                    
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block font-body-sm font-bold text-on-surface mb-2">Endereço Residencial</label>
                        <input class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-bright focus:border-secondary outline-none transition-shadow text-body-md" type="text" name="morada" value="{{ old('morada', $paciente->user->morada) }}" />
                    </div>
                </div>
            </div>

            <!-- TAB: Dados Clínicos -->
            <div id="tab-clinica" class="tab-content hidden space-y-stack-lg">
                <header class="flex justify-between items-end border-b border-outline-variant/30 pb-stack-sm mb-stack-lg">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Dados Clínicos do Paciente</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Paciente: {{ $paciente->user->name }}</p>
                    </div>
                </header>

                <div class="grid grid-cols-12 gap-gutter">
                    <!-- Vital Signs / Health Indicators (Placeholder for future data) -->
                    <section class="col-span-12 md:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-stack-md">
                        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border-t-4 border-primary">
                            <div class="flex justify-between items-start">
                                <p class="font-label-md text-label-md text-on-surface-variant">Freq. Cardíaca</p>
                                <span class="material-symbols-outlined text-primary">favorite</span>
                            </div>
                            <div class="mt-stack-sm">
                                <h3 class="font-headline-md text-headline-md">-- <span class="text-body-sm font-normal text-on-surface-variant">bpm</span></h3>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border-t-4 border-secondary">
                            <div class="flex justify-between items-start">
                                <p class="font-label-md text-label-md text-on-surface-variant">Pressão Arterial</p>
                                <span class="material-symbols-outlined text-secondary">speed</span>
                            </div>
                            <div class="mt-stack-sm">
                                <h3 class="font-headline-md text-headline-md">--/-- <span class="text-body-sm font-normal text-on-surface-variant">mmHg</span></h3>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border-t-4 border-tertiary">
                            <div class="flex justify-between items-start">
                                <p class="font-label-md text-label-md text-on-surface-variant">Peso Atual</p>
                                <span class="material-symbols-outlined text-tertiary">monitor_weight</span>
                            </div>
                            <div class="mt-stack-sm">
                                <h3 class="font-headline-md text-headline-md">-- <span class="text-body-sm font-normal text-on-surface-variant">kg</span></h3>
                            </div>
                        </div>
                    </section>

                    <!-- Allergies Panel -->
                    <section class="col-span-12 md:col-span-4 bg-error-container text-on-error-container p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center gap-2 mb-stack-md">
                            <span class="material-symbols-outlined">warning</span>
                            <h3 class="font-title-lg text-title-lg font-bold">Alergias e Alertas</h3>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center justify-between p-2 bg-white/40 rounded-lg">
                                <span class="font-body-sm text-body-sm font-bold">Nenhum registo</span>
                            </li>
                        </ul>
                    </section>

                    <!-- Observações and Motivo -->
                    <section class="col-span-12 md:col-span-7 bg-surface-container-lowest p-stack-lg rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center gap-2 mb-stack-lg">
                            <span class="material-symbols-outlined text-primary">history_edu</span>
                            <h3 class="font-title-lg text-title-lg">Histórico Pessoal & Motivo da Consulta</h3>
                        </div>
                        <div class="space-y-stack-md">
                            <div>
                                <label class="font-bold text-on-surface block mb-2">Queixa Principal</label>
                                <textarea name="motivo_consulta" class="w-full bg-surface-bright border border-outline-variant rounded-lg p-4 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" rows="2" placeholder="Descreva brevemente o motivo ou sintomas...">{{ old('motivo_consulta', $paciente->motivo_consulta) }}</textarea>
                            </div>
                            <div>
                                <label class="font-bold text-on-surface block mb-2">Histórico Médico Prévio</label>
                                <textarea name="condicoes" class="w-full bg-surface-bright border border-outline-variant rounded-lg p-4 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" rows="2" placeholder="Condições pré-existentes, alergias ou patologias...">{{ old('condicoes', $paciente->condicoes) }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section class="col-span-12 md:col-span-5 bg-surface-container-lowest p-stack-lg rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center gap-2 mb-stack-lg">
                            <span class="material-symbols-outlined text-primary">pill</span>
                            <h3 class="font-title-lg text-title-lg">Medicação e Observações</h3>
                        </div>
                        <div class="space-y-stack-md">
                            <div>
                                <label class="font-bold text-on-surface block mb-2">Medicação Atual</label>
                                <textarea name="medicacao" class="w-full bg-surface-bright border border-outline-variant rounded-lg p-4 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" rows="2" placeholder="Nome dos medicamentos, dosagens e frequências...">{{ old('medicacao', $paciente->medicacao) }}</textarea>
                            </div>
                            <div>
                                <label class="font-bold text-on-surface block mb-2">Observações Adicionais</label>
                                <textarea name="observacoes" class="w-full bg-surface-bright border border-outline-variant rounded-lg p-4 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" rows="2" placeholder="Outras notas ou informações...">{{ old('observacoes', $paciente->observacoes) }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- TAB: Histórico de Consultas -->
            <div id="tab-hist" class="tab-content hidden">
                <header class="flex justify-between items-end mb-10 border-b border-outline-variant/30 pb-stack-sm">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Histórico Clínico</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Acompanhe a sua jornada de consultas.</p>
                    </div>
                </header>

                <div class="relative pl-8 md:pl-12 space-y-12">
                    @if($paciente->consultas->count() > 0)
                        <div class="absolute left-4 md:left-[24px] top-0 bottom-0 w-[2px]" style="background: repeating-linear-gradient(to bottom, #bdc9c8 0px, #bdc9c8 8px, transparent 8px, transparent 16px);"></div>
                    @endif
                    
                    <section>
                        <div class="grid grid-cols-1 gap-6">
                            @forelse($paciente->consultas->sortByDesc('data') as $consulta)
                                <div class="group relative bg-surface-container-lowest p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-transparent hover:border-primary/20 transition-all duration-300">
                                    <div class="absolute -left-[31px] md:-left-[39px] top-1/2 -translate-y-1/2 w-4 h-4 rounded-full {{ $consulta->estado === 'Realizada' ? 'bg-primary' : 'bg-surface-variant' }} border-4 border-surface group-hover:scale-125 transition-transform z-10"></div>
                                    <div class="flex gap-6 items-start">
                                        <div class="bg-surface-container-high p-4 rounded-xl flex flex-col items-center justify-center min-w-[80px]">
                                            <span class="font-label-md text-label-md text-primary font-bold uppercase">{{ \Carbon\Carbon::parse($consulta->data)->locale('pt')->isoFormat('ddd') }}</span>
                                            <span class="font-headline-md text-headline-md text-on-surface">{{ \Carbon\Carbon::parse($consulta->data)->format('d') }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest mb-1 {{ $consulta->estado === 'Realizada' ? 'bg-green-100 text-green-800' : 'bg-surface-variant text-on-surface-variant' }}">{{ $consulta->estado }}</span>
                                                    <h3 class="font-title-lg text-title-lg text-on-surface">{{ $consulta->tipo }}</h3>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 mb-3">
                                                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">person</span>
                                                <p class="font-body-sm text-body-sm font-semibold">{{ $consulta->profissional->user->name ?? 'Clínica' }}</p>
                                                <span class="text-on-surface-variant text-body-sm">• {{ $consulta->profissional->especialidade ?? 'Especialista' }}</span>
                                            </div>
                                            <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">Modalidade: {{ ucfirst($consulta->modalidade) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 text-on-surface-variant pl-0 relative z-10">
                                    <span class="material-symbols-outlined text-4xl opacity-25 mb-2">history</span>
                                    <p class="font-bold text-on-surface">Sem histórico registado</p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>

            <!-- TAB: Ficheiros / Documentos -->
            <div id="tab-docs" class="tab-content hidden">
                <div class="flex justify-between items-end mb-stack-lg border-b border-outline-variant/30 pb-stack-sm">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Ficheiros & Documentos</h2>
                        <p class="text-body-md text-on-surface-variant">Faça a gestão de exames, prescrições e laudos.</p>
                    </div>
                </div>
                
                <div class="bg-surface-container-lowest rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] overflow-hidden">
                    <div class="grid grid-cols-12 gap-4 px-stack-md py-4 bg-surface-container-low text-label-md text-on-surface-variant font-bold uppercase tracking-wider hidden md:grid">
                        <div class="col-span-9">Nome do Arquivo</div>
                        <div class="col-span-3">Data</div>
                    </div>
                    
                    <div class="divide-y divide-surface-variant">
                        @forelse($paciente->documentos as $documento)
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-stack-md py-4 items-center hover:bg-surface-container/30 transition-colors group cursor-pointer">
                                <div class="md:col-span-9 flex items-center gap-4">
                                    <div class="w-10 h-10 bg-primary-container text-on-primary-container rounded-lg flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">description</span>
                                    </div>
                                    <div>
                                        <h4 class="font-body-md text-body-md font-semibold text-on-surface group-hover:text-primary transition-colors">{{ $documento->nome }}</h4>
                                        <span class="text-body-sm text-on-surface-variant">Documento</span>
                                    </div>
                                </div>
                                <div class="md:col-span-3 text-body-sm text-on-surface-variant">
                                    {{ $documento->created_at->format('d de F, Y') }}
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center opacity-60">
                                <span class="material-symbols-outlined text-6xl text-primary-fixed-dim mb-4">upload_file</span>
                                <p class="font-body-lg text-body-lg text-on-surface-variant">Ainda não existem ficheiros ou documentos.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function openFichaTab(evt, tabId) {
    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => {
        content.classList.remove('active');
        content.classList.add('hidden');
    });

    // Remove active styles from all tab buttons
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => {
        btn.classList.remove('font-bold', 'text-primary', 'border-b-2', 'border-primary', 'active');
        btn.classList.add('text-on-surface-variant');
    });

    // Show selected tab content
    const selectedTab = document.getElementById(tabId);
    if(selectedTab) {
        selectedTab.classList.remove('hidden');
        selectedTab.classList.add('active');
    }

    // Add active styles to clicked button
    const activeBtn = evt.currentTarget;
    activeBtn.classList.remove('text-on-surface-variant');
    activeBtn.classList.add('font-bold', 'text-primary', 'border-b-2', 'border-primary', 'active');
}
</script>
@endsection
