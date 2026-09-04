@extends('layouts.portal')

@section('title', 'Perfil — MindCare')

@section('content')

@if(session('success'))
<div class="fixed bottom-8 right-8 z-50 bg-[#224F52] text-white px-6 py-4 rounded-xl shadow-xl flex items-center gap-3" id="toast-success">
    <span class="material-symbols-outlined text-[20px] text-primary-fixed">check_circle</span>
    <span class="font-body-md text-xs font-semibold">{{ session('success') }}</span>
</div>
<script>setTimeout(() => { const t = document.getElementById('toast-success'); if(t) { t.remove(); } }, 4000);</script>
@endif

@if($errors->any())
<div class="fixed bottom-8 right-8 z-50 bg-error text-on-error p-4 rounded-xl shadow-xl max-w-sm text-xs space-y-1">
    <p class="font-bold mb-2 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">warning</span> Erros de Validação</p>
    @foreach($errors->all() as $error)
        <p>• {{ $error }}</p>
    @endforeach
</div>
@endif

<form action="{{ route('portal.perfil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-stack-lg">
    @csrf
    @method('PUT')

    <!-- Profile Header Card -->
    <section class="bg-white rounded-xl p-stack-lg shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32"></div>
        <div class="relative flex flex-col md:flex-row items-center gap-8">
            <div class="relative group cursor-pointer" onclick="document.getElementById('foto-input').click()">
                @if(Auth::user()->foto_perfil)
                    <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Foto de Perfil" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md" loading="lazy" decoding="async">
                @else
                    <div class="w-32 h-32 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-3xl border-4 border-white shadow-md">
                        {{ Auth::user()->iniciais ?? strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif
                <div class="absolute bottom-0 right-0 bg-primary text-on-primary w-10 h-10 rounded-full flex items-center justify-center shadow-lg border-2 border-white group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                </div>
                <input type="file" name="foto" id="foto-input" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewImage(this)">
            </div>
            
            <div class="flex-grow text-center md:text-left">
                <h2 class="font-headline-lg text-headline-lg text-on-background">{{ Auth::user()->name }}</h2>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-2">
                    <span class="bg-surface-container-high text-primary px-3 py-1 rounded-full font-label-md text-label-md flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">verified</span> Conta Activa
                    </span>
                    <span class="bg-secondary-container/20 text-on-secondary-container px-3 py-1 rounded-full font-label-md text-label-md">
                        Paciente desde {{ $paciente->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}" class="border border-outline text-on-surface px-6 py-3 rounded-lg font-bold hover:bg-surface-variant transition-colors flex items-center justify-center">Cancelar</a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-bold shadow-sm hover:opacity-90 transition-opacity">Guardar Alterações</button>
            </div>
        </div>
    </section>

    <!-- Two Column Layout for Forms -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-stack-lg text-xs">
        
        <!-- Left Column: Personal Data & Emergency -->
        <div class="lg:col-span-2 space-y-stack-lg">
            
            <!-- Dados Pessoais -->
            <section class="bg-white rounded-xl p-stack-lg border border-outline-variant/10 shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-2 mb-6 border-b border-outline-variant/20 pb-4">
                    <span class="material-symbols-outlined text-primary">person_edit</span>
                    <h3 class="font-title-lg text-title-lg text-on-surface">Dados Pessoais</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="font-bold text-on-surface">Nome Completo</label>
                        <input class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">E-mail</label>
                        <input class="bg-surface-container-low border border-outline-variant/30 rounded-lg p-3 font-body-md text-body-md text-on-surface-variant cursor-not-allowed outline-none" type="email" value="{{ Auth::user()->email }}" disabled />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Telefone</label>
                        <input class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" type="text" name="telefone" value="{{ old('telefone', Auth::user()->telefone) }}" placeholder="+244 9XX XXX XXX" />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Data de Nascimento</label>
                        <input class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" type="date" name="data_nascimento" value="{{ old('data_nascimento', Auth::user()->data_nascimento?->format('Y-m-d')) }}" />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Género</label>
                        <select name="genero" class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all appearance-none bg-white">
                            <option value="">Seleccionar</option>
                            <option value="Masculino" @selected(old('genero', Auth::user()->genero) === 'Masculino')>Masculino</option>
                            <option value="Feminino" @selected(old('genero', Auth::user()->genero) === 'Feminino')>Feminino</option>
                            <option value="Outro" @selected(old('genero', Auth::user()->genero) === 'Outro')>Outro</option>
                        </select>
                    </div>
                    
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="font-bold text-on-surface">Endereço Residencial</label>
                        <input class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" type="text" name="morada" value="{{ old('morada', Auth::user()->morada) }}" placeholder="Bairro, Rua, Casa" />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Número de BI</label>
                        <input class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" type="text" name="bi_numero" value="{{ old('bi_numero', Auth::user()->bi_numero) }}" />
                    </div>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Província</label>
                        <select class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all appearance-none bg-white" name="provincia">
                            <option value="">Seleccionar</option>
                            @foreach(['Bengo','Benguela','Bié','Cabinda','Cuando Cubango','Cuanza Norte','Cuanza Sul','Cunene','Huambo','Huíla','Luanda','Lunda Norte','Lunda Sul','Malanje','Moxico','Namibe','Uíge','Zaire'] as $prov)
                                <option value="{{ $prov }}" @selected(old('provincia', Auth::user()->provincia) == $prov)>{{ $prov }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
            
            <!-- Dados Emergência & Clínicos Gerais -->
            <section class="bg-white rounded-xl p-stack-lg border border-outline-variant/10 shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-2 mb-6 border-b border-outline-variant/20 pb-4">
                    <span class="material-symbols-outlined text-primary">medical_information</span>
                    <h3 class="font-title-lg text-title-lg text-on-surface">Dados de Emergência & Clínicos</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="font-bold text-on-surface">Contato de Emergência (Telefone)</label>
                        <input class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia', Auth::user()->telefone_alt) }}" placeholder="+244 9XX XXX XXX" />
                    </div>
                    
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="font-bold text-on-surface">Motivo Principal da Consulta</label>
                        <textarea class="border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" name="motivo_consulta" rows="2" placeholder="Motivo do acompanhamento clínico...">{{ old('motivo_consulta', $paciente->motivo_consulta) }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Histórico Médico Prévio</label>
                        <textarea class="border border-outline-variant rounded-lg p-3 font-body-sm text-body-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" name="condicoes" rows="3" placeholder="Alergias, doenças pré-existentes...">{{ old('condicoes', $paciente->condicoes) }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="font-bold text-on-surface">Medicação Atual</label>
                        <textarea class="border border-outline-variant rounded-lg p-3 font-body-sm text-body-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" name="medicacao" rows="3" placeholder="Frequências, nomes, dosagens...">{{ old('medicacao', $paciente->medicacao) }}</textarea>
                    </div>
                    
                    <div class="flex flex-col gap-1.5 md:col-span-2">
                        <label class="font-bold text-on-surface">Observações</label>
                        <textarea class="border border-outline-variant rounded-lg p-3 font-body-sm text-body-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" name="observacoes" rows="2" placeholder="Notas clínicas gerais...">{{ old('observacoes', $paciente->observacoes) }}</textarea>
                    </div>
                </div>
            </section>
            
            <!-- Segurança da Conta -->
            <section class="bg-white rounded-xl p-stack-lg border border-outline-variant/10 shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-2 mb-6 border-b border-outline-variant/20 pb-4">
                    <span class="material-symbols-outlined text-primary">lock</span>
                    <h3 class="font-title-lg text-title-lg text-on-surface">Segurança da Conta</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 rounded-lg bg-surface-container-low">
                        <div>
                            <p class="font-body-md text-body-md font-bold text-on-surface">Alterar Palavra-passe</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Proteja o acesso ao seu portal clínico</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="text-primary font-bold hover:underline">Atualizar</a>
                    </div>
                    
                    <div class="flex justify-between items-center p-4 rounded-lg bg-surface-container-low">
                        <div>
                            <p class="font-body-md text-body-md font-bold text-on-surface">Autenticação de Dois Fatores</p>
                            @if(Auth::user()->two_factor_confirmed_at)
                                <p class="font-body-sm text-body-sm text-primary font-medium">Activado • via App autenticador</p>
                            @else
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Desactivado • Opcional para pacientes</p>
                            @endif
                        </div>
                        <div>
                            @if(Auth::user()->two_factor_confirmed_at)
                                <a href="{{ route('2fa.verificar') }}" class="bg-primary text-on-primary px-3 py-1.5 rounded-lg font-bold">Verificar</a>
                            @else
                                <a href="{{ route('2fa.ativar') }}" class="text-primary font-bold hover:underline">Configurar</a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Right Column: Settings and Plan -->
        <div class="space-y-stack-lg">
            
            <!-- Plano Atual -->
            <section class="bg-white rounded-xl p-stack-lg border border-outline-variant/10 shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-2 mb-6 border-b border-outline-variant/20 pb-4">
                    <span class="material-symbols-outlined text-primary">card_membership</span>
                    <h3 class="font-title-lg text-title-lg text-on-surface">Plano Atual</h3>
                </div>
                
                @if($paciente->subscricaoActiva && $paciente->subscricaoActiva->plano)
                    @php 
                        $subscricao = $paciente->subscricaoActiva; 
                        $plano = $subscricao->plano;
                    @endphp
                    <div class="bg-gradient-to-br from-primary to-primary-container p-6 rounded-xl text-on-primary mb-4 shadow-sm">
                        <p class="font-label-md text-[10px] opacity-90 tracking-widest uppercase">PLANO ACTIVO</p>
                        <h4 class="font-headline-md text-headline-md font-bold">{{ $plano->nome }}</h4>
                        <p class="font-body-sm text-body-sm mt-2 opacity-80">Válido até {{ $subscricao->data_validade?->format('d/m/Y') }}</p>
                        <div class="mt-4 pt-4 border-t border-white/20">
                            <p class="font-body-sm text-body-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span> 
                                <span>{{ $subscricao->sessoes_usadas }} / {{ $plano->sessoes_total }} sessões utilizadas</span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-surface-container-low p-6 rounded-xl text-on-surface-variant mb-4 border border-outline-variant/20 text-center">
                        <p class="text-sm font-semibold">Sem plano ativo no momento</p>
                        <p class="text-xs mt-1">Seleccione um plano de saúde para marcar consultas.</p>
                    </div>
                @endif
                <a href="{{ route('plano') }}" class="block w-full border border-primary text-primary text-center font-bold py-3 rounded-lg hover:bg-primary/5 transition-colors">Gerir Planos</a>
            </section>

            <!-- Preferências -->
            <section class="bg-white rounded-xl p-stack-lg border border-outline-variant/10 shadow-[0px_4px_12px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-2 mb-6 border-b border-outline-variant/20 pb-4">
                    <span class="material-symbols-outlined text-primary">settings_accessibility</span>
                    <h3 class="font-title-lg text-title-lg text-on-surface">Preferências</h3>
                </div>
                
                @php
                    $preferencias = $paciente->preferencias ?? [];
                @endphp
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <input class="w-5 h-5 text-primary border-outline-variant rounded focus:ring-primary/20" type="checkbox" name="preferencias[notif_email]" value="1" @checked(data_get($preferencias, 'notif_email') == '1' || is_null(data_get($preferencias, 'notif_email')))>
                        <label class="font-body-sm text-body-sm text-on-surface-variant font-medium">Notificações por E-mail</label>
                    </div>
                    <div class="flex items-center gap-3">
                        <input class="w-5 h-5 text-primary border-outline-variant rounded focus:ring-primary/20" type="checkbox" name="preferencias[notif_sms]" value="1" @checked(data_get($preferencias, 'notif_sms') == '1')>
                        <label class="font-body-sm text-body-sm text-on-surface-variant font-medium">Lembretes de Consultas via SMS</label>
                    </div>
                    <div class="flex items-center gap-3">
                        <input class="w-5 h-5 text-primary border-outline-variant rounded focus:ring-primary/20" type="checkbox" name="preferencias[alto_contraste]" value="1" @checked(data_get($preferencias, 'alto_contraste') == '1')>
                        <label class="font-body-sm text-body-sm text-on-surface-variant font-medium">Visualização em Alto Contraste</label>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Find image tags in card and update
                const img = input.parentElement.querySelector('img');
                if (img) {
                    img.src = e.target.result;
                } else {
                    // Replace avatar initials div with img
                    const initialsDiv = input.parentElement.querySelector('div');
                    if (initialsDiv) {
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.alt = "Foto de Perfil";
                        newImg.className = "w-32 h-32 rounded-full object-cover border-4 border-white shadow-md";
                        initialsDiv.parentNode.replaceChild(newImg, initialsDiv);
                    }
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
