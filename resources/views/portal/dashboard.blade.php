@extends('layouts.portal')

@section('title', 'Dashboard — MindCare')

@section('content')
@php
    $proxConsulta = $paciente->consultas->where('estado', 'Agendada')->first();
    $sub = $paciente->subscricaoActiva;
    $sessoesUsadas = $sub?->sessoes_usadas ?? 0;
    $sessoesTotal = $sub?->plano?->sessoes_total ?? 10;
    $sessaoPct = $sessoesTotal > 0 ? round(($sessoesUsadas / $sessoesTotal) * 100) : 0;
    $unreadMsgs = $paciente->conversas->flatMap(fn ($c) => $c->mensagens)->where('remetente_id', '!=', Auth::id())->where('lida', false)->count();
    $totalDocs = $paciente->documentos->count();
@endphp

<!-- Subscription Alerts -->
@if(!$sub || !$sub->ativa())
    <div class="bg-error-container border border-error/20 rounded-xl p-4 mb-6 flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-error-container flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-on-error-container">error</span>
        </div>
        <div class="flex-grow">
            <p class="text-sm font-semibold text-on-error-container">A sua subscrição não está ativa.</p>
            <p class="text-xs text-on-error-container/80">Renove o seu plano para continuar a aceder aos serviços.</p>
        </div>
        <a href="{{ route('plano') }}" class="text-sm font-bold text-on-error-container hover:underline whitespace-nowrap">
            Renovar <span class="material-symbols-outlined text-xs align-middle">arrow_forward</span>
        </a>
    </div>
@elseif($sub->data_validade && $sub->data_validade->diffInDays(now()->startOfDay()) <= 7)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-amber-600">schedule</span>
        </div>
        <div class="flex-grow">
            <p class="text-sm font-semibold text-amber-900">A sua subscrição expira em {{ $sub->data_validade->diffInDays(now()->startOfDay()) }} dia(s).</p>
            <p class="text-xs text-amber-700">Renove antes do término para manter o acesso.</p>
        </div>
        <a href="{{ route('plano') }}" class="text-sm font-bold text-amber-700 hover:underline whitespace-nowrap">
            Renovar <span class="material-symbols-outlined text-xs align-middle">arrow_forward</span>
        </a>
    </div>
@endif

<!-- Welcome Header -->
<header class="mb-stack-lg">
    <h2 class="font-headline-lg text-headline-lg text-on-surface">Olá, {{ explode(' ', Auth::user()->name)[0] }}. Como está hoje?</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Aqui está um resumo da sua jornada de bem-estar.</p>
</header>

<!-- Bento Grid Layout -->
<div class="grid grid-cols-12 gap-stack-lg">
    <!-- Wellbeing Stats (Asymmetric Large Block) -->
    <section class="col-span-12 lg:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-stack-md">
        <div class="col-span-2 md:col-span-3 bg-primary-container text-on-primary-container p-stack-lg rounded-xl flex flex-col md:flex-row md:items-center justify-between shadow-sm relative overflow-hidden group">
            <div class="z-10">
                <p class="font-label-md text-label-md uppercase tracking-wider opacity-80">Progresso Semanal</p>
                <h3 class="font-headline-md text-headline-md font-bold mt-1">
                    {{ $sessoesUsadas > 0 ? 'Sua evolução continua positiva' : 'Comece a sua jornada de saúde' }}
                </h3>
                <p class="font-body-sm text-body-sm mt-2 max-w-md">Baseado nas suas consultas e interações com o plano terapêutico.</p>
            </div>
            <div class="z-10 mt-4 md:mt-0 flex gap-2">
                <a href="{{ route('consultas') }}" class="bg-surface-container-lowest text-primary px-4 py-2 rounded-lg font-bold text-label-md hover:scale-105 transition-transform shadow-sm">Ver Detalhes</a>
            </div>
            <!-- Abstract Background Decoration -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
        </div>
        
        <!-- Mini Stat Cards -->
        <div class="bg-white p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border border-outline-variant/30">
            <div class="flex justify-between items-start">
                <span class="w-10 h-10 bg-secondary-container text-on-secondary-container rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">chat</span></span>
                @if($unreadMsgs > 0)
                    <span class="text-primary font-bold text-label-md flex items-center gap-1">{{ $unreadMsgs }} novas</span>
                @endif
            </div>
            <div class="mt-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Mensagens</p>
                <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $unreadMsgs }}</p>
            </div>
        </div>
        
        <div class="bg-white p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border border-outline-variant/30">
            <div class="flex justify-between items-start">
                <span class="w-10 h-10 bg-primary-fixed text-on-primary-fixed rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">description</span></span>
                <span class="text-primary font-bold text-label-md flex items-center gap-1">{{ $totalDocs }} total</span>
            </div>
            <div class="mt-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Documentos</p>
                <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $totalDocs }}</p>
            </div>
        </div>
        
        <div class="bg-white p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border border-outline-variant/30">
            <div class="flex justify-between items-start">
                <span class="w-10 h-10 bg-surface-variant text-on-surface-variant rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">calendar_month</span></span>
                <span class="text-primary font-bold text-label-md">{{ $proxConsulta ? \Carbon\Carbon::parse($proxConsulta->data)->format('d M') : '--' }}</span>
            </div>
            <div class="mt-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Próxima Consulta</p>
                <p class="font-headline-md text-headline-md font-bold text-on-surface">{{ $proxConsulta ? \Carbon\Carbon::parse($proxConsulta->hora)->format('H:i') : '--' }}</p>
            </div>
        </div>
    </section>

    <!-- Upcoming Appointments (Tall Block) -->
    <section class="col-span-12 lg:col-span-4 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 flex flex-col">
        <div class="p-stack-md border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="font-title-lg text-title-lg text-on-surface">Próxima Consulta</h3>
            <a class="text-primary font-bold text-label-md hover:underline" href="{{ route('consultas') }}">Ver tudo</a>
        </div>
        <div class="p-stack-md flex-grow space-y-4">
            @if($proxConsulta)
                <div class="p-4 rounded-xl bg-surface-container-low border-l-4 border-primary">
                    <p class="text-primary font-bold text-label-md">
                        @if(\Carbon\Carbon::parse($proxConsulta->data)->isToday())
                            HOJE, ÀS {{ \Carbon\Carbon::parse($proxConsulta->hora)->format('H:i') }}
                        @elseif(\Carbon\Carbon::parse($proxConsulta->data)->isTomorrow())
                            AMANHÃ, ÀS {{ \Carbon\Carbon::parse($proxConsulta->hora)->format('H:i') }}
                        @else
                            {{ strtoupper(\Carbon\Carbon::parse($proxConsulta->data)->translatedFormat('d \d\e F, Y')) }} · {{ \Carbon\Carbon::parse($proxConsulta->hora)->format('H:i') }}
                        @endif
                    </p>
                    <div class="flex items-center gap-3 mt-3 mb-4">
                        @if(isset($proxConsulta->profissional->user) && $proxConsulta->profissional->user->foto_perfil)
                            <img src="{{ asset('storage/' . $proxConsulta->profissional->user->foto_perfil) }}" alt="Dr" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ $proxConsulta->profissional->user->iniciais ?? strtoupper(substr($proxConsulta->profissional->user->name ?? 'MC', 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <p class="font-body-md text-body-md font-bold">{{ $proxConsulta->profissional->user->name ?? 'Dr(a).' }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $proxConsulta->profissional->especialidade ?? 'Psicologia' }} · {{ ucfirst($proxConsulta->modalidade) }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        @if(!$proxConsulta->confirmada)
                            <form method="POST" action="{{ route('portal.consultas.confirmar', $proxConsulta) }}" class="w-full">
                                @csrf @method('PUT')
                                <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded-lg font-bold text-label-md hover:opacity-90 transition-all">Confirmar Presença</button>
                            </form>
                        @else
                            <span class="w-full text-center bg-primary-fixed text-on-primary-fixed py-2 rounded-lg text-label-md font-bold block">Presença confirmada</span>
                        @endif
                        
                        <div class="flex gap-2">
                            <button type="button" class="flex-1 border border-outline text-on-surface-variant py-2 rounded-lg text-label-md font-bold hover:bg-surface-variant transition-all" onclick="openSideModal('modal-reagendar')">Reagendar</button>
                            <form method="POST" action="{{ route('portal.consultas.cancelar', $proxConsulta) }}" class="flex-1">
                                @csrf @method('PUT')
                                <button type="submit" class="w-full border border-outline text-error py-2 rounded-lg text-label-md font-bold hover:bg-error-container/20 transition-all">Cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-8 text-center text-on-surface-variant text-body-sm">
                    <span class="material-symbols-outlined text-4xl opacity-30 mb-2">calendar_today</span>
                    <p class="font-semibold text-on-surface mb-1">Sem consultas agendadas</p>
                    <p class="mb-4">Marque a sua primeira consulta agora.</p>
                    <a href="{{ route('consultas') }}" class="inline-block bg-primary text-on-primary px-4 py-2 rounded-lg text-label-md font-bold hover:opacity-90 transition-all">Agendar</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Recent Messages -->
    <section class="col-span-12 lg:col-span-8 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
        <div class="p-stack-md border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="font-title-lg text-title-lg text-on-surface">Mensagens Recentes</h3>
            <a href="{{ route('mensagens') }}" class="w-10 h-10 text-primary hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined">chat</span>
            </a>
        </div>
        <div class="divide-y divide-outline-variant/20">
            @php 
                $recentMsgs = $paciente->conversas->sortByDesc(function($c) { 
                    return $c->mensagens->max('created_at'); 
                })->take(2); 
            @endphp
            @forelse($recentMsgs as $conv)
                @php 
                    $lastMsg = $conv->mensagens->last(); 
                    $prof = $conv->profissional; 
                @endphp
                <a href="{{ route('mensagens', ['conversa' => $conv->id]) }}" class="p-stack-md flex items-start gap-4 hover:bg-surface-container-lowest transition-colors cursor-pointer group">
                    <div class="relative flex-shrink-0">
                        @if($prof && $prof->user && $prof->user->foto_perfil)
                            <img src="{{ asset('storage/' . $prof->user->foto_perfil) }}" alt="Dr" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center text-sm font-bold">
                                {{ $prof && $prof->user ? substr($prof->user->name, 0, 2) : 'MC' }}
                            </div>
                        @endif
                        @if($lastMsg && !$lastMsg->lida && $lastMsg->remetente_id != Auth::id())
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        @endif
                    </div>
                    <div class="flex-grow min-w-0">
                        <div class="flex justify-between items-center">
                            <h4 class="font-body-md text-body-md font-bold text-on-surface">{{ $prof->user->name ?? 'Profissional' }}</h4>
                            <span class="font-label-md text-label-md text-on-surface-variant flex-shrink-0 ml-2">{{ $lastMsg ? $lastMsg->created_at->diffForHumans() : '' }}</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 truncate group-hover:text-on-surface">
                            @if($lastMsg && $lastMsg->remetente_id == Auth::id())
                                <span class="text-primary font-semibold">Você:</span>
                            @endif
                            {{ $lastMsg ? $lastMsg->texto : 'Sem mensagens' }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="p-stack-md text-center text-on-surface-variant text-body-sm">
                    <span class="material-symbols-outlined text-3xl opacity-30 mb-2">forum</span>
                    <p>Nenhuma conversa ainda.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Health Journey (Circular Progress/Asymmetric) -->
    <section class="col-span-12 lg:col-span-4 bg-secondary text-white rounded-xl p-stack-lg flex flex-col items-center justify-center text-center shadow-md relative overflow-hidden">
        <div class="relative z-10 w-full">
            <p class="font-label-md text-label-md uppercase tracking-widest opacity-80 mb-4">Jornada de Tratamento</p>
            <!-- Custom Circular Progress with SVG -->
            <div class="relative w-32 h-32 mb-6 mx-auto">
                <svg class="w-full h-full" viewbox="0 0 36 36">
                    <path class="text-white/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="100, 100" stroke-width="3"></path>
                    <path class="text-white" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="{{ $sessaoPct }}, 100" stroke-linecap="round" stroke-width="3"></path>
                    <text class="fill-white font-bold text-[8px]" text-anchor="middle" x="18" y="20.35">{{ $sessaoPct }}%</text>
                </svg>
            </div>
            <h3 class="font-title-lg text-title-lg font-bold mb-2">Quase lá!</h3>
            <p class="font-body-sm text-body-sm opacity-90 mb-6">Completou {{ $sessoesUsadas }} das {{ $sessoesTotal }} sessões do seu plano atual.</p>
            <a href="{{ route('plano') }}" class="block w-full bg-white text-secondary py-3 rounded-xl font-bold hover:bg-secondary-fixed transition-colors active:scale-95 shadow-sm text-center">Ver Meu Plano</a>
        </div>
        <!-- Decorative Background Element -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-60 h-60 bg-white rounded-full"></div>
        </div>
    </section>
</div>

{{-- Consultas Recentes (full width below bento grid) --}}
<div class="mt-5 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
    <div class="px-5 py-4 border-b border-outline-variant/30 flex justify-between items-center">
        <h3 class="text-title-lg text-on-surface">Histórico de Consultas</h3>
        <a href="{{ route('consultas') }}" class="text-primary font-bold text-label-md hover:underline">Ver todas</a>
    </div>
    <div class="divide-y divide-outline-variant/20">
        @forelse($paciente->consultas->where('estado', '!=', 'Agendada')->take(4) as $consulta)
            <div class="flex flex-col md:flex-row md:items-center justify-between px-5 py-4 hover:bg-surface-container-low transition-colors gap-3 md:gap-0">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full {{ $consulta->estado == 'Realizada' ? 'bg-primary-container/20 text-primary' : 'bg-error-container text-error' }} flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[18px]">
                            {{ $consulta->estado == 'Realizada' ? 'check' : 'close' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-body-md font-semibold text-on-surface">{{ $consulta->profissional->user->name ?? 'Profissional' }}</p>
                        <p class="text-body-sm text-on-surface-variant">{{ \Carbon\Carbon::parse($consulta->data)->format('d M Y') }} · {{ $consulta->tipo }} · {{ ucfirst($consulta->modalidade) }}</p>
                    </div>
                </div>
                <span class="w-fit text-label-md font-semibold px-3 py-1 rounded-full {{ $consulta->estado == 'Realizada' ? 'bg-primary-fixed text-on-primary-fixed' : 'bg-error-container text-on-error-container' }}">
                    {{ ucfirst($consulta->estado) }}
                </span>
            </div>
        @empty
            <div class="px-5 py-8 text-center text-on-surface-variant text-body-sm">
                <span class="material-symbols-outlined text-3xl opacity-30 mb-2">event_busy</span>
                <p>Nenhuma consulta realizada ainda.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Side Modal for Reschedule --}}
@if($proxConsulta)
<x-side-modal id="modal-reagendar">
    <x-slot:avatar>
        <div class="sm-avatar-placeholder" style="background: #EAF8F8; color: #224F52; display: flex; align-items: center; justify-center: center;">
            <span class="material-symbols-outlined text-2xl">update</span>
        </div>
    </x-slot>
    <x-slot:title>Reagendar Consulta</x-slot>
    <x-slot:subtitle>Escolha a nova data e hora para a sua consulta.</x-slot>

    <form action="{{ route('portal.consultas.reagendar', $proxConsulta) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="sm-form-group mb-4">
            <label class="sm-label font-bold text-xs text-on-surface-variant block mb-1">Nova Data</label>
            <input type="date" name="data" class="w-full border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" required min="{{ date('Y-m-d') }}" value="{{ \Carbon\Carbon::parse($proxConsulta->data)->format('Y-m-d') }}">
        </div>
        <div class="sm-form-group mb-6">
            <label class="sm-label font-bold text-xs text-on-surface-variant block mb-1">Nova Hora</label>
            <input type="time" name="hora" class="w-full border border-outline-variant rounded-lg p-3 font-body-md text-body-md focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all" required value="{{ \Carbon\Carbon::parse($proxConsulta->hora)->format('H:i') }}">
        </div>
        
        <div class="sm-form-group" style="margin-top: 30px;">
            <button type="submit" class="w-full bg-primary text-on-primary py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">Confirmar Reagendamento</button>
        </div>
    </form>
</x-side-modal>
@endif
@endsection
