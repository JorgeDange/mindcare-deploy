@extends('layouts.portal')

@section('title', 'Planos de Saúde — MindCare')

@section('content')
@php
    $temSubscricao = $subscricaoActiva && $subscricaoActiva->ativa();
    $temPendente = $subscricaoActiva && $subscricaoActiva->estado === 'Pendente';
    $temPagamentoPendente = false;
    if ($subscricaoActiva) {
        $temPagamentoPendente = \App\Models\Pagamento::where('paciente_id', $subscricaoActiva->paciente_id)
            ->where('estado', 'Pendente')->exists();
    }
    
    $beneficiosAtivo = [];
    if ($temSubscricao) {
        $beneficiosAtivo = is_array($subscricaoActiva->plano->beneficios)
            ? $subscricaoActiva->plano->beneficios
            : json_decode($subscricaoActiva->plano->beneficios, true) ?? [];
    }
@endphp

<div class="max-w-container-max mx-auto space-y-stack-lg">

    <!-- Page Header -->
    <div class="flex flex-col gap-1">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Gestão de Planos</h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Escolha o suporte ideal para sua jornada de bem-estar mental.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-green-700 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-error-container border border-error/20 rounded-xl p-4 text-on-error-container flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">error</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if($temSubscricao && ($temPagamentoPendente ?? false))
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-yellow-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">hourglass_empty</span>
            <span>O seu plano ainda aguarda confirmação do administrador. Não poderá marcar consultas até ser aprovado.</span>
        </div>
    @endif

    <!-- Current Plan Bento Highlight -->
    @if($temSubscricao)
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-[#F2F8F8] p-8 rounded-xl border border-[#D1E6E6] relative overflow-hidden flex flex-col justify-between">
            <!-- Subtle background decoration -->
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-white opacity-40 rounded-full -mr-32 -mt-32 pointer-events-none"></div>
            
            <div>
                <div class="inline-flex items-center px-4 py-1.5 bg-[#065F5C] text-white rounded-full text-xs font-semibold mb-4 z-10 relative">
                    Plano Atual
                </div>
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-6 z-10 relative">
                    <div>
                        <h3 class="text-2xl font-bold text-[#065F5C] mb-1">{{ $subscricaoActiva->plano->nome }}</h3>
                        <p class="text-sm text-gray-600">Assinado em: {{ $subscricaoActiva->data_inicio?->format('d \d\e F, Y') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-left md:text-right">
                        @if($subscricaoActiva->plano->preco > 0)
                            <div class="flex items-baseline md:justify-end gap-1">
                                <span class="text-4xl font-extrabold text-[#111827]">Kz {{ number_format($subscricaoActiva->plano->preco, 0, ',', '.') }}</span>
                                <span class="text-sm font-medium text-gray-600">/mês</span>
                            </div>
                        @else
                            <span class="text-3xl font-extrabold text-[#111827]">Sob consulta</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 z-10 relative mt-auto">
                @foreach(array_slice($beneficiosAtivo, 0, 4) as $ben)
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#065F5C]" style="font-variation-settings: 'FILL' 0;">check_circle</span>
                    <span class="text-sm font-medium text-gray-800">{{ $ben }}</span>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-[#6AA4F8] p-8 rounded-xl flex flex-col justify-between shadow-sm">
            <div>
                <h4 class="text-xl font-bold text-[#14325E] mb-3">Próxima Renovação</h4>
                <p class="text-sm font-medium text-[#1E437C] leading-relaxed mb-6">Sua assinatura será renovada automaticamente em:</p>
                <p class="text-3xl font-extrabold text-[#14325E]">{{ $subscricaoActiva->data_validade?->format('d \d\e M, Y') }}</p>
            </div>
            <button onclick="document.getElementById('troca-panel').classList.toggle('hidden'); window.scrollTo({top: document.getElementById('troca-panel').offsetTop, behavior: 'smooth'})"
                    class="w-full bg-white text-[#14325E] font-bold py-3 rounded-lg hover:bg-gray-50 transition-colors mt-6 shadow-sm">
                Gerir Pagamento
            </button>
        </div>
    </section>
    @elseif($temPendente)
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8 text-blue-700 flex items-center gap-3">
        <span class="material-symbols-outlined">schedule</span>
        <span class="font-medium">O seu pedido de plano está pendente de aprovação.</span>
    </div>
    @endif

    <div id="troca-panel" class="{{ $temSubscricao ? 'hidden' : '' }}">
        @php
            $planosVisiveis = $planos->where('activo', true);
            $categorias = [
                'individual' => ['label' => 'Particular', 'icon' => 'person'],
                'familia' => ['label' => 'Familiar & Kandengue', 'icon' => 'group'],
                'empresa' => ['label' => 'Corporativo', 'icon' => 'corporate_fare'],
            ];
        @endphp

        @foreach($categorias as $chave => $cat)
            @php $planosCat = $planosVisiveis->where('publico', $chave)->values(); @endphp
            @if($planosCat->isNotEmpty())
            <section class="space-y-6 mb-12">
                <div class="flex items-center gap-2">
                    <h3 class="text-2xl font-bold text-[#111827]">Outras Opções de Planos</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                    @foreach($planosCat as $index => $plano)
                        @php
                            $isPlanoAtivo = $temSubscricao && $subscricaoActiva->plano_id === $plano->id;
                            $beneficios = is_array($plano->beneficios)
                                ? $plano->beneficios
                                : json_decode($plano->beneficios, true) ?? [];
                            $isDestacado = str_contains(strtolower($plano->nome), 'premium') || str_contains(strtolower($plano->nome), 'avançado');
                            $isElite = str_contains(strtolower($plano->nome), 'elite') || str_contains(strtolower($plano->nome), 'completo');
                        @endphp

                        @if($isPlanoAtivo || $isDestacado)
                        {{-- Premium / Current plan card style --}}
                        <div class="bg-white p-8 rounded-xl border-[2.5px] border-[#065F5C] flex flex-col h-full relative">
                            @if($isPlanoAtivo)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#065F5C] text-white px-5 py-1 rounded-full text-[11px] font-bold tracking-wider">
                                ATUAL
                            </div>
                            @elseif($isDestacado)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#065F5C] text-white px-5 py-1 rounded-full text-[11px] font-bold tracking-wider">
                                RECOMENDADO
                            </div>
                            @endif
                            
                            <h4 class="text-xl font-bold text-[#065F5C] mb-3">{{ $plano->nome }}</h4>
                            <p class="text-sm text-gray-600 mb-6 flex-grow">{{ $plano->descricao }}</p>
                            
                            <div class="mb-8">
                                @if($plano->preco > 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-4xl font-extrabold text-[#111827]">Kz {{ number_format($plano->preco, 0, ',', '.') }}</span>
                                        <span class="text-sm font-medium text-gray-600">/mês</span>
                                    </div>
                                @else
                                    <span class="text-3xl font-extrabold text-[#111827]">Sob consulta</span>
                                @endif
                            </div>
                            
                            <ul class="space-y-4 mb-8">
                                @foreach(array_slice($beneficios, 0, 4) as $indexBen => $beneficio)
                                <li class="flex items-start gap-3 text-sm text-gray-800 {{ $indexBen === 0 ? 'font-bold' : 'font-medium' }}">
                                    <span class="material-symbols-outlined text-gray-800 text-[20px]" style="font-variation-settings: 'wght' 600;">check</span>
                                    <span class="leading-tight">{{ $beneficio }}</span>
                                </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-auto">
                                @if($isPlanoAtivo)
                                <button class="w-full bg-[#D4EAF6] text-[#0A415C] font-bold py-3.5 rounded-lg border border-transparent shadow-sm">
                                    Plano Activo
                                </button>
                                @else
                                <button onclick="abrirAdesaoOuTroca({{ $plano->id }}, @js($plano->nome), @js($plano->preco))"
                                        class="w-full bg-[#065F5C] text-white font-bold py-3.5 rounded-lg hover:bg-[#054E4A] transition-colors shadow-sm">
                                    {{ $temSubscricao ? 'Migrar para ' : 'Aderir ao ' }}{{ explode(' ', $plano->nome)[0] }}
                                </button>
                                @endif
                            </div>
                        </div>

                        @elseif($isElite)
                        {{-- Elite Plan style --}}
                        <div class="bg-[#213535] p-8 rounded-xl flex flex-col h-full border border-transparent">
                            <h4 class="text-xl font-bold text-white mb-3">{{ $plano->nome }}</h4>
                            <p class="text-sm text-gray-300 mb-6 flex-grow">{{ $plano->descricao }}</p>
                            
                            <div class="mb-8">
                                @if($plano->preco > 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-4xl font-extrabold text-white">Kz {{ number_format($plano->preco, 0, ',', '.') }}</span>
                                        <span class="text-sm font-medium text-gray-300">/mês</span>
                                    </div>
                                @else
                                    <span class="text-3xl font-extrabold text-white">Sob consulta</span>
                                @endif
                            </div>
                            
                            <ul class="space-y-4 mb-8">
                                @foreach(array_slice($beneficios, 0, 4) as $beneficio)
                                <li class="flex items-start gap-3 text-sm text-white font-medium">
                                    <span class="material-symbols-outlined text-[#89EDE7] text-[20px]">star</span>
                                    <span class="leading-tight">{{ $beneficio }}</span>
                                </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-auto">
                                <button onclick="abrirAdesaoOuTroca({{ $plano->id }}, @js($plano->nome), @js($plano->preco))"
                                        class="w-full bg-[#89EDE7] text-[#123131] font-bold py-3.5 rounded-lg hover:bg-[#7AD8D2] transition-colors shadow-sm">
                                    {{ $temSubscricao ? 'Upgrade para ' : 'Aderir ao ' }}{{ explode(' ', $plano->nome)[0] }}
                                </button>
                            </div>
                        </div>

                        @else
                        {{-- Basic Plan style --}}
                        <div class="bg-white p-8 rounded-xl border border-gray-200 flex flex-col h-full">
                            <h4 class="text-xl font-bold text-[#111827] mb-3">{{ $plano->nome }}</h4>
                            <p class="text-sm text-gray-600 mb-6 flex-grow">{{ $plano->descricao }}</p>
                            
                            <div class="mb-8">
                                @if($plano->preco > 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-4xl font-extrabold text-[#111827]">Kz {{ number_format($plano->preco, 0, ',', '.') }}</span>
                                        <span class="text-sm font-medium text-gray-600">/mês</span>
                                    </div>
                                @else
                                    <span class="text-3xl font-extrabold text-[#111827]">Sob consulta</span>
                                @endif
                            </div>
                            
                            <ul class="space-y-4 mb-8">
                                @foreach(array_slice($beneficios, 0, 4) as $beneficio)
                                <li class="flex items-start gap-3 text-sm text-gray-800 font-medium">
                                    <span class="material-symbols-outlined text-gray-800 text-[20px]" style="font-variation-settings: 'wght' 600;">check</span>
                                    <span class="leading-tight">{{ $beneficio }}</span>
                                </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-auto">
                                <button onclick="abrirAdesaoOuTroca({{ $plano->id }}, @js($plano->nome), @js($plano->preco))"
                                        class="w-full bg-white border-2 border-[#065F5C] text-[#065F5C] font-bold py-3 rounded-lg hover:bg-[#F2F8F8] transition-colors shadow-sm">
                                    {{ $temSubscricao ? 'Migrar para ' : 'Aderir ao ' }}{{ explode(' ', $plano->nome)[0] }}
                                </button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </section>
            @endif
        @endforeach
    </div>

    <!-- FAQ or Support CTA -->
    <section class="bg-[#DEF4F4] p-8 rounded-xl flex flex-col sm:flex-row items-center justify-between border border-[#CBEAEA] gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-[#065F5C] rounded-full flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-white text-[28px]">quiz</span>
            </div>
            <div>
                <h4 class="text-xl font-bold text-[#111827]">Dúvidas sobre os planos?</h4>
                <p class="text-sm font-medium text-gray-700 mt-1">Nossa equipe está pronta para ajudar você a escolher a melhor opção.</p>
            </div>
        </div>
        <a href="{{ route('mensagens') }}" class="w-full sm:w-auto border-2 border-[#065F5C] text-[#065F5C] bg-white px-8 py-3.5 rounded-lg font-bold hover:bg-[#F2F8F8] transition-colors text-center whitespace-nowrap">
            Falar com Consultor
        </a>
    </section>

</div>

<!-- NOVO MODAL OVERLAY -->
<div id="modal-adesao-troca" class="fixed inset-0 z-50 flex items-center justify-center bg-on-background/40 backdrop-blur-sm hidden p-4">
    <!-- MODAL CONTAINER -->
    <div class="bg-surface-container-lowest w-full max-w-[1000px] h-[90vh] max-h-[800px] rounded-[24px] shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-300">
        <!-- Form wrapper to allow layout -->
        <form action="{{ $temSubscricao ? route('portal.plano.trocar') : route('portal.plano.aderir') }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-full w-full">
            @csrf
            <input type="hidden" name="plano_id" id="input-plano-id">
            
            <!-- Header (Fixed) -->
            <div class="px-6 py-4 flex items-center justify-between border-b border-outline-variant/20 bg-surface-container-lowest z-20 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">sync_alt</span>
                    </div>
                    <h3 class="font-headline-md text-title-lg md:text-headline-md text-on-surface">Processar Plano</h3>
                </div>
                <button type="button" onclick="document.getElementById('modal-adesao-troca').classList.add('hidden')" class="w-10 h-10 rounded-full hover:bg-surface-variant flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant">close</span>
                </button>
            </div>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto flex flex-col md:flex-row">
                <!-- Left: Steps -->
                <div class="flex-1 p-6 md:p-8 space-y-8">
                    <!-- Step 1: Plano -->
                    <section class="space-y-4">
                        <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 1: Plano Selecionado</label>
                        <div class="flex gap-4">
                            <input type="text" id="input-plano-nome" class="w-2/3 h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-low text-primary font-bold focus:outline-none cursor-not-allowed" readonly>
                            <input type="text" id="input-plano-preco" class="w-1/3 h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-low text-primary-container font-bold text-right focus:outline-none cursor-not-allowed" readonly>
                        </div>
                    </section>

                    <!-- Step 2: Pagamento -->
                    <section class="space-y-4">
                        <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 2: Método de Pagamento</label>
                        <div class="relative">
                            <select name="metodo" class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-secondary focus:border-secondary outline-none appearance-none font-body-md cursor-pointer transition-all" required>
                                <option value="transferencia_bancaria" selected>Transferência Bancária</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <span class="material-symbols-outlined text-on-surface-variant">expand_more</span>
                            </div>
                        </div>
                    </section>
                    
                    <!-- Step 3: Comprovativo -->
                    <section class="space-y-4 pt-4">
                        <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 3: Comprovativo</label>
                        <div class="w-full relative border-2 border-dashed border-outline-variant rounded-xl p-8 hover:bg-surface-variant transition-colors group cursor-pointer bg-surface-container-lowest">
                            <input type="file" name="comprovativo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required accept="image/*,.pdf" onchange="document.getElementById('file-name-display').innerText = this.files[0] ? this.files[0].name : 'Nenhum ficheiro seleccionado'">
                            <div class="flex flex-col items-center justify-center text-center space-y-3 pointer-events-none">
                                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl text-primary opacity-90">upload_file</span>
                                </div>
                                <div>
                                    <p class="font-body-md font-bold text-on-surface">Toque ou arraste para fazer upload</p>
                                    <p class="text-body-sm text-on-surface-variant mt-1" id="file-name-display">Aceita PDF, PNG, JPG</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right: Summary Sidebar -->
                <div class="w-full md:w-[320px] bg-surface-container-low p-6 md:p-8 md:border-l border-t md:border-t-0 border-outline-variant/20 flex flex-col gap-6 shrink-0">
                    <h4 class="font-title-lg text-title-lg text-on-surface">Resumo da Adesão</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 bg-white p-3 rounded-xl border border-outline-variant/30">
                            <span class="material-symbols-outlined text-primary mt-1">medical_services</span>
                            <div>
                                <p class="text-body-sm font-label-md text-on-surface-variant">Plano</p>
                                <p class="font-body-md font-bold text-on-surface" id="resumo-plano-nome">Seleccione um plano</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 bg-white p-3 rounded-xl border border-outline-variant/30">
                            <span class="material-symbols-outlined text-primary mt-1">payments</span>
                            <div>
                                <p class="text-body-sm font-label-md text-on-surface-variant">Valor Mensal</p>
                                <p class="font-body-md font-bold text-on-surface" id="resumo-plano-preco">0 AOA</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-primary/5 p-4 rounded-xl border border-primary/10 mt-auto md:mt-4">
                        <p class="text-body-sm text-on-surface-variant leading-relaxed">
                            <span class="material-symbols-outlined text-[16px] align-middle mr-1 text-primary">info</span>
                            Após a submissão, a nossa equipa irá validar o comprovativo e ativar o plano na sua conta.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed with Action Button) -->
            <div class="p-4 md:p-6 bg-surface-container-lowest border-t border-outline-variant/20 shrink-0 z-20">
                <button type="submit" class="w-full h-14 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-primary-container hover:scale-[1.01] active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-title-lg">
                    Confirmar Subscrição
                    <span class="material-symbols-outlined">check_circle</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const temSubscricao = @json($temSubscricao);

    function abrirAdesaoOuTroca(id, nome, preco) {
        document.getElementById('input-plano-id').value = id;
        document.getElementById('input-plano-nome').value = nome;
        
        let precoFormatado = preco > 0 ? new Intl.NumberFormat('pt-PT').format(preco) + ' AOA' : 'Sob consulta';
        document.getElementById('input-plano-preco').value = precoFormatado;
        
        document.getElementById('resumo-plano-nome').innerText = nome;
        document.getElementById('resumo-plano-preco').innerText = precoFormatado;
        
        document.getElementById('modal-adesao-troca').classList.remove('hidden');
    }

    document.querySelectorAll('.plan-card').forEach(card => {
        card.addEventListener('mouseenter', () => {});
    });
</script>

<style>
    .plan-card {
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .plan-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.08);
    }
</style>
@endsection