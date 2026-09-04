@extends('layouts.portal')

@section('title', 'Mensagens — MindCare')

@section('content')
<section class="flex h-full p-stack-md gap-stack-md overflow-hidden bg-surface-container-low">
    
    <!-- Contact List Column -->
    <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-sm flex-col border border-outline-variant/30 overflow-hidden {{ $conversaActiva ? 'hidden md:flex' : 'flex' }}">
        <div class="p-4 border-b border-outline-variant/20">
            <h2 class="font-title-lg text-title-lg text-on-surface">Conversas</h2>
        </div>
        
        <div class="flex-1 overflow-y-auto chat-scroll divide-y divide-outline-variant/10">
            @forelse($owner->conversas as $conversa)
                @php
                    $mensagensNaoLidas = $conversa->mensagens
                        ->where('remetente_id', '!=', Auth::id())
                        ->where('lida', false)
                        ->count();
                    $prof = $conversa->profissional;
                @endphp
                <a href="{{ route('mensagens', ['conversa' => $conversa->id]) }}" 
                   class="flex items-center gap-4 p-4 transition-colors cursor-pointer {{ $conversaActiva && $conversaActiva->id === $conversa->id ? 'bg-surface-container-high border-l-4 border-primary' : 'hover:bg-surface-container-low' }}">
                    <div class="relative flex-shrink-0">
                        @if($prof && $prof->user && $prof->user->foto_perfil)
                            <img src="{{ asset('storage/' . $prof->user->foto_perfil) }}" alt="Dr" class="h-12 w-12 rounded-full object-cover" loading="lazy" decoding="async">
                        @else
                            <div class="h-12 w-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-sm">
                                {{ $conversa->iniciais }}
                            </div>
                        @endif
                        @if($mensagensNaoLidas > 0)
                            <span class="absolute -top-1 -right-1 bg-error text-on-error font-bold text-[9px] min-w-[16px] h-[16px] rounded-full flex items-center justify-center px-1">
                                {{ $mensagensNaoLidas }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex-1 overflow-hidden">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-on-surface truncate">{{ $prof && $prof->user ? $prof->user->name : $conversa->contacto }}</span>
                            <span class="text-[10px] text-on-surface-variant flex-shrink-0 ml-1">{{ $conversa->mensagens->last() ? $conversa->mensagens->last()->created_at->diffForHumans() : '' }}</span>
                        </div>
                        <p class="text-body-sm text-on-surface-variant truncate mt-0.5">
                            {{ $conversa->mensagens->last() ? Str::limit($conversa->mensagens->last()->texto, 35) : 'Sem mensagens' }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="px-4 py-8 text-center text-on-surface-variant text-xs">
                    <span class="material-symbols-outlined text-3xl opacity-35 mb-2">forum</span>
                    <p>Não tem conversas activas.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Conversation Column (Right) -->
    <div class="w-full md:flex-grow bg-white rounded-2xl shadow-sm flex-col overflow-hidden border border-outline-variant/30 relative {{ $conversaActiva ? 'flex' : 'hidden md:flex' }}">
        @if($conversaActiva)
            @php $profActivo = $conversaActiva->profissional; @endphp
            <!-- Chat Header -->
            <div class="p-4 border-b border-outline-variant/20 flex items-center justify-between bg-white/70 backdrop-blur-md sticky top-0 z-10">
                <div class="flex items-center gap-2 md:gap-4">
                    <a href="{{ route('mensagens') }}" class="md:hidden w-10 h-10 -ml-2 hover:bg-surface-container rounded-full text-on-surface-variant flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    </a>
                    @if($profActivo && $profActivo->user && $profActivo->user->foto_perfil)
                        <img src="{{ asset('storage/' . $profActivo->user->foto_perfil) }}" alt="Dr" class="h-10 w-10 rounded-full object-cover" loading="lazy" decoding="async">
                    @else
                        <div class="h-10 w-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-sm">
                            {{ $conversaActiva->iniciais }}
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-on-surface text-sm leading-tight">{{ $profActivo && $profActivo->user ? $profActivo->user->name : $conversaActiva->contacto }}</h3>
                        <span class="text-[10px] text-green-600 flex items-center gap-1 mt-0.5" id="chat-status">
                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span> Online agora
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mensagens', ['conversa' => $conversaActiva->id]) }}" class="w-10 h-10 hover:bg-surface-container rounded-full flex items-center justify-center text-on-surface-variant" title="Actualizar"><span class="material-symbols-outlined text-[20px]">refresh</span></a>
                    <button class="w-10 h-10 hover:bg-surface-container rounded-full flex items-center justify-center text-primary"><span class="material-symbols-outlined text-[20px]">call</span></button>
                    <button class="w-10 h-10 hover:bg-surface-container rounded-full flex items-center justify-center text-primary"><span class="material-symbols-outlined text-[20px]">videocam</span></button>
                    <button class="w-10 h-10 hover:bg-surface-container rounded-full flex items-center justify-center text-on-surface-variant"><span class="material-symbols-outlined text-[20px]">more_vert</span></button>
                </div>
            </div>

            <!-- Chat Messages Area -->
            <div class="flex-grow overflow-y-auto chat-scroll p-6 space-y-6 bg-[radial-gradient(#bdc9c8_1px,transparent_1px)] [background-size:24px_24px] bg-fixed chat-messages-area">
                @php $currentDate = null; @endphp
                @foreach($conversaActiva->mensagens as $mensagem)
                    @php
                        $msgDate = $mensagem->created_at->format('d \d\e F \d\e Y');
                    @endphp
                    @if($currentDate !== $msgDate)
                        <div class="flex justify-center my-4">
                            <span class="bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full text-[10px] font-medium">{{ $msgDate }}</span>
                        </div>
                        @php $currentDate = $msgDate; @endphp
                    @endif

                    @if($mensagem->remetente_id !== Auth::id())
                        <!-- Message Received -->
                        <div class="flex items-end gap-3 max-w-[80%]" id="msg-{{ $mensagem->id }}">
                            @if($profActivo && $profActivo->user && $profActivo->user->foto_perfil)
                                <img src="{{ asset('storage/' . $profActivo->user->foto_perfil) }}" alt="Dr" class="h-8 w-8 rounded-full object-cover shrink-0 mb-1" loading="lazy" decoding="async">
                            @else
                                <div class="h-8 w-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs shrink-0 mb-1">
                                    {{ $conversaActiva->iniciais }}
                                </div>
                            @endif
                            <div class="bg-white border border-outline-variant/30 p-4 rounded-2xl rounded-bl-none shadow-sm text-xs">
                                <p class="text-on-surface leading-normal">{!! nl2br(e($mensagem->texto)) !!}</p>
                                @if($mensagem->anexo_path)
                                    <div class="mt-3 bg-surface-container rounded-lg p-2.5 flex items-center gap-2.5 border border-outline-variant/20 hover:bg-surface-container-high transition-colors cursor-pointer">
<span class="w-8 h-8 bg-primary-fixed text-primary rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px]">description</span></span>
                                        <div class="flex-grow min-w-0">
                                            <a href="{{ Storage::url($mensagem->anexo_path) }}" download class="font-bold text-on-surface truncate block text-[10px] hover:underline">
                                                {{ basename($mensagem->anexo_path) }}
                                            </a>
                                            <p class="text-[8px] text-on-surface-variant">Descarregar anexo</p>
                                        </div>
                                        <a href="{{ Storage::url($mensagem->anexo_path) }}" download class="material-symbols-outlined text-on-surface-variant text-[18px]">download</a>
                                    </div>
                                @endif
                                <span class="text-[9px] text-on-surface-variant block mt-2 text-right">{{ $mensagem->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @else
                        <!-- Message Sent -->
                        <div class="flex items-end gap-3 max-w-[80%] ml-auto flex-row-reverse" id="msg-{{ $mensagem->id }}">
                            <div class="bg-primary text-on-primary p-4 rounded-2xl rounded-br-none shadow-md text-xs">
                                <p class="leading-normal">{!! nl2br(e($mensagem->texto)) !!}</p>
                                @if($mensagem->anexo_path)
                                    <div class="mt-3 bg-white/10 rounded-lg p-2.5 flex items-center gap-2.5 border border-white/20 hover:bg-white/20 transition-colors cursor-pointer">
<span class="w-8 h-8 bg-white/10 text-white rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px]">description</span></span>
                                        <div class="flex-grow min-w-0">
                                            <a href="{{ Storage::url($mensagem->anexo_path) }}" download class="font-bold text-white truncate block text-[10px] hover:underline">
                                                {{ basename($mensagem->anexo_path) }}
                                            </a>
                                            <p class="text-[8px] text-white/70">Descarregar anexo</p>
                                        </div>
                                        <a href="{{ Storage::url($mensagem->anexo_path) }}" download class="material-symbols-outlined text-white text-[18px]">download</a>
                                    </div>
                                @endif
                                <span class="text-[9px] text-primary-fixed/70 block mt-2 text-right">{{ $mensagem->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Message Input -->
            <form action="{{ route('portal.mensagens.store') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-surface border-t border-outline-variant/20" style="margin: 0;">
                @csrf
                <input type="hidden" name="conversa_id" value="{{ $conversaActiva->id }}">
                <input type="file" name="anexo" id="input-anexo" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" style="display:none">
                
                <div class="flex items-end gap-3">
                    <button type="button" class="w-12 h-12 hover:bg-surface-variant rounded-full flex items-center justify-center text-on-surface-variant" title="Anexar Ficheiro" onclick="document.getElementById('input-anexo').click()"><span class="material-symbols-outlined text-[20px]">attach_file</span></button>
                    
                    <div class="flex-1 bg-surface-container rounded-2xl px-4 py-2.5 flex flex-col gap-2 min-h-[48px] justify-center relative">
                        <div id="anexo-pill" class="hidden bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-semibold self-start flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">attachment</span>
                            <span id="anexo-nome" class="max-w-[120px] truncate"></span>
                            <button type="button" onclick="removerAnexo()" class="text-error font-bold text-xs hover:opacity-85 hover:scale-115 transition-all outline-none">
                                <span class="material-symbols-outlined text-[14px] align-middle">close</span>
                            </button>
                        </div>
                        <input type="text" name="texto" placeholder="Escreva sua mensagem..." required class="w-full bg-transparent border-none focus:ring-0 text-body-sm outline-none resize-none p-1">
                    </div>
                    
                    <button type="submit" class="h-12 w-12 bg-primary text-on-primary rounded-full flex items-center justify-center shadow-lg active:scale-95 hover:opacity-90 transition-all">
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </div>
            </form>
        @else
            <!-- Estado Vazio -->
            <div class="flex flex-col items-center justify-center h-full text-on-surface-variant p-6">
                <span class="material-symbols-outlined text-5xl opacity-25 mb-3">chat_bubble</span>
                <p class="font-semibold text-on-surface text-sm">Nenhuma conversa seleccionada</p>
                <p class="text-xs mt-1 text-center">Seleccione um dos terapeutas na coluna esquerda para iniciar ou prosseguir a sua conversa.</p>
            </div>
        @endif
    </div>
</section>

<script>
let pollInterval;
let failCount = 0;
let lastPollTime = Math.floor(Date.now() / 1000);
const conversaId = {{ $conversaActiva ? $conversaActiva->id : 'null' }};
const currentUserId = {{ Auth::id() }};
const doctorAvatarUrl = @json($conversaActiva && $profActivo && $profActivo->user && $profActivo->user->foto_perfil ? asset('storage/' . $profActivo->user->foto_perfil) : null);
const doctorInitials = @json($conversaActiva ? $conversaActiva->iniciais : 'MC');

document.addEventListener('DOMContentLoaded', () => {
    const area = document.querySelector('.chat-messages-area');
    if (area) area.scrollTop = area.scrollHeight;

    const inputAnexo = document.getElementById('input-anexo');
    if (inputAnexo) {
        inputAnexo.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                document.getElementById('anexo-nome').textContent = this.files[0].name;
                document.getElementById('anexo-pill').classList.remove('hidden');
            }
        });
    }

    if (conversaId) {
        startPolling();
    }
});

function removerAnexo() {
    document.getElementById('input-anexo').value = '';
    document.getElementById('anexo-pill').classList.add('hidden');
}

function startPolling() {
    pollInterval = setInterval(fetchNovasMensagens, 3000);
}

function fetchNovasMensagens() {
    if (!conversaId) return;

    fetch(`/portal/mensagens/${conversaId}/novas?desde=${lastPollTime}`)
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            failCount = 0;
            const statusEl = document.getElementById('chat-status');
            if (statusEl) {
                statusEl.innerHTML = '<span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span> Online agora';
                statusEl.style.color = '';
            }
            
            if (data.mensagens && data.mensagens.length > 0) {
                appendMessages(data.mensagens);
            }
            lastPollTime = Math.floor(Date.now() / 1000);
        })
        .catch(error => {
            failCount++;
            if (failCount >= 3) {
                const statusEl = document.getElementById('chat-status');
                if (statusEl) {
                    statusEl.innerHTML = '<span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Indisponível';
                    statusEl.style.color = '#9CA3AF';
                }
            }
        });
}

function appendMessages(mensagens) {
    const area = document.querySelector('.chat-messages-area');
    if (!area) return;
    let shouldScroll = false;
    
    mensagens.forEach(msg => {
        if (document.getElementById('msg-' + msg.id)) return;
        
        shouldScroll = true;
        const isSent = msg.remetente_id === currentUserId;
        
        const wrapper = document.createElement('div');
        wrapper.id = 'msg-' + msg.id;
        
        let anexoHtml = '';
        if (msg.anexo_url) {
            if (isSent) {
                anexoHtml = `
                    <div class="mt-3 bg-white/10 rounded-lg p-2.5 flex items-center gap-2.5 border border-white/20 hover:bg-white/20 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-white bg-white/10 p-1.5 rounded-lg text-[18px]">description</span>
                        <div class="flex-grow min-w-0">
                            <a href="${msg.anexo_url}" download class="font-bold text-white truncate block text-[10px] hover:underline">${msg.anexo_url.split('/').pop()}</a>
                            <p class="text-[8px] text-white/70">Descarregar anexo</p>
                        </div>
                        <a href="${msg.anexo_url}" download class="material-symbols-outlined text-white text-[18px]">download</a>
                    </div>
                `;
            } else {
                anexoHtml = `
                    <div class="mt-3 bg-surface-container rounded-lg p-2.5 flex items-center gap-2.5 border border-outline-variant/20 hover:bg-surface-container-high transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-primary bg-primary-fixed p-1.5 rounded-lg text-[18px]">description</span>
                        <div class="flex-grow min-w-0">
                            <a href="${msg.anexo_url}" download class="font-bold text-on-surface truncate block text-[10px] hover:underline">${msg.anexo_url.split('/').pop()}</a>
                            <p class="text-[8px] text-on-surface-variant">Descarregar anexo</p>
                        </div>
                        <a href="${msg.anexo_url}" download class="material-symbols-outlined text-on-surface-variant text-[18px]">download</a>
                    </div>
                `;
            }
        }
        
        if (isSent) {
            wrapper.className = 'flex items-end gap-3 max-w-[80%] ml-auto flex-row-reverse';
            wrapper.innerHTML = `
                <div class="bg-primary text-on-primary p-4 rounded-2xl rounded-br-none shadow-md text-xs">
                    <p class="leading-normal">${msg.texto}</p>
                    ${anexoHtml}
                    <span class="text-[9px] text-primary-fixed/70 block mt-2 text-right">${msg.hora}</span>
                </div>
            `;
        } else {
            wrapper.className = 'flex items-end gap-3 max-w-[80%]';
            let avatarHtml = doctorAvatarUrl 
                ? `<img src="${doctorAvatarUrl}" alt="Dr" class="h-8 w-8 rounded-full object-cover shrink-0 mb-1">`
                : `<div class="h-8 w-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs shrink-0 mb-1">${doctorInitials}</div>`;
                
            wrapper.innerHTML = `
                ${avatarHtml}
                <div class="bg-white border border-outline-variant/30 p-4 rounded-2xl rounded-bl-none shadow-sm text-xs">
                    <p class="text-on-surface leading-normal">${msg.texto}</p>
                    ${anexoHtml}
                    <span class="text-[9px] text-on-surface-variant block mt-2 text-right">${msg.hora}</span>
                </div>
            `;
        }
        
        area.appendChild(wrapper);
    });
    
    if (shouldScroll) {
        area.scrollTop = area.scrollHeight;
    }
}

window.addEventListener('beforeunload', () => {
    if (pollInterval) clearInterval(pollInterval);
});
</script>
@endsection
