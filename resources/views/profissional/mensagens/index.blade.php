@extends('layouts.profissional')

@section('title', 'Mensagens — Profissional')

@section('content')
<div class="chat-page-wrapper" style="height: calc(100vh - 7rem);">
    <!-- Sidebar de Conversas -->
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <h2 class="chat-sidebar-title">Conversas</h2>
            <div class="chat-search">
                <span class="material-symbols-outlined" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 18px; color: #6e7979;">search</span>
                <input type="text" placeholder="Pesquisar..." style="width: 100%; padding: 8px 12px 8px 36px; border: 1px solid #e5e7eb; border-radius: 999px; font-size: 0.85rem; outline: none; background: #f9fafb;">
            </div>
        </div>

        <div class="chat-list">
            @forelse($conversas as $conversa)
            @php
                $ultimaMsg = $conversa->mensagens->first();
                $naoLidas = $conversa->nao_lidas;
            @endphp
            <a href="{{ route('profissional.mensagens.index', ['conversa' => $conversa->id]) }}"
               class="chat-list-item {{ $conversaActiva && $conversaActiva->id === $conversa->id ? 'active' : '' }}"
               style="text-decoration: none; color: inherit;">
                <div class="chat-avatar" style="background: {{ $conversaActiva && $conversaActiva->id === $conversa->id ? '' : 'linear-gradient(135deg, #005f5f, #007a7a)' }};">
                    {{ $conversa->iniciais ?? ($conversa->paciente?->user?->iniciais ?? '?') }}
                </div>
                <div class="chat-item-info">
                    <div class="chat-item-header">
                        <span class="chat-item-name">{{ $conversa->contacto ?? $conversa->paciente?->user?->name ?? 'Paciente' }}</span>
                        <span class="chat-item-time">{{ $ultimaMsg ? $ultimaMsg->created_at->diffForHumans() : '' }}</span>
                    </div>
                    <div class="chat-item-preview">
                        {{ $ultimaMsg ? Str::limit($ultimaMsg->texto, 35) : 'Sem mensagens' }}
                        @if($naoLidas > 0)
                            <span class="notif-badge" style="position: static; display: inline-flex; margin-left: 8px;">{{ $naoLidas }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <p style="padding: 20px; text-align: center; color: #6e7979; font-size: 0.9rem;">Nenhuma conversa activa.</p>
            @endforelse
        </div>
    </div>

    <!-- Área de Mensagens -->
    <div class="chat-main">
        @if($conversaActiva)
        @php $pacienteUser = $conversaActiva->paciente?->user; @endphp
        <div class="chat-main-header">
            <div class="chat-main-header-info">
                <div class="chat-avatar" style="width: 48px; height: 48px; font-size: 1.1rem; background: linear-gradient(135deg, #005f5f, #007a7a);">
                    {{ $conversaActiva->iniciais ?? ($pacienteUser?->iniciais ?? '?') }}
                </div>
                <div>
                    <h3 style="margin: 0; font-family: 'DM Sans', sans-serif; font-size: 1.1rem; color: #071e27;">
                        {{ $conversaActiva->contacto ?? $pacienteUser?->name ?? 'Paciente' }}
                    </h3>
                    <span class="chat-header-status" id="chat-status" style="color: #10B981;">● Disponível</span>
                </div>
            </div>
        </div>

        <div class="chat-messages-area">
            @php $currentDate = null; @endphp
            @foreach($conversaActiva->mensagens as $mensagem)
                @php
                    $msgDate = $mensagem->created_at->format('d \d\e F \d\e Y');
                @endphp
                @if($currentDate !== $msgDate)
                    <div class="chat-system-msg">{{ $msgDate }}</div>
                    @php $currentDate = $msgDate; @endphp
                @endif

                <div class="chat-bubble-wrapper {{ $mensagem->remetente_id === Auth::id() ? 'sent' : 'received' }}"
                     id="msg-{{ $mensagem->id }}">
                    <div class="chat-bubble {{ $mensagem->remetente_id === Auth::id() ? 'sent' : 'received' }}">
                        {!! nl2br(e($mensagem->texto)) !!}
                        @if($mensagem->anexo_path)
                            @php $borderColor = $mensagem->remetente_id === Auth::id() ? 'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.1)'; @endphp
                            <div style="margin-top: 8px; border-top: 1px solid {{ $borderColor }}; padding-top: 8px;">
                                <a href="{{ Storage::url($mensagem->anexo_path) }}" download
                                   style="color: inherit; text-decoration: underline; font-size: 0.85rem;">
                                    <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">attach_file</span> Descarregar Anexo
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="chat-bubble-time">{{ $mensagem->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('profissional.mensagens.store') }}" method="POST" enctype="multipart/form-data" class="chat-input-area" style="margin: 0;">
            @csrf
            <input type="hidden" name="conversa_id" value="{{ $conversaActiva->id }}">
            <input type="file" name="anexo" id="input-anexo" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" style="display:none">
            <button type="button" class="chat-attach-btn" title="Anexar Ficheiro" onclick="document.getElementById('input-anexo').click()">
                <span class="material-symbols-outlined">attach_file</span>
            </button>
            <div class="chat-input-box" style="flex: 1; position: relative;">
                <div id="anexo-pill" style="display: none; position: absolute; top: -35px; left: 0; background: #dbf1fe; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem; color: #005f5f; border: 1px solid #bae6fd; align-items: center; gap: 8px;">
                    <span class="material-symbols-outlined" style="font-size: 14px;">attach_file</span> <span id="anexo-nome"></span>
                    <button type="button" onclick="removerAnexo()" style="background: none; border: none; color: #ba1a1a; cursor: pointer; padding: 0;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                    </button>
                </div>
                <input type="text" name="texto" placeholder="Escreva a sua mensagem..." required
                       style="width: 100%; border: none; background: transparent; outline: none; padding: 12px 0;">
            </div>
            <button type="submit" class="chat-send-btn"><span class="material-symbols-outlined">send</span></button>
        </form>
        @else
        <div style="display: flex; align-items: center; justify-content: center; height: 100%; flex-direction: column; color: #6e7979;">
            <span class="material-symbols-outlined" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;">forum</span>
            <p>Seleccione uma conversa para começar a enviar mensagens.</p>
        </div>
        @endif
    </div>
</div>

<style>
.chat-page-wrapper {
    display: grid;
    grid-template-columns: 320px 1fr;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(0, 95, 95, 0.05);
}
.chat-sidebar {
    border-right: 1px solid #f3f4f6;
    display: flex;
    flex-direction: column;
}
.chat-sidebar-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f3f4f6;
}
.chat-sidebar-title {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #005f5f;
    margin: 0 0 12px;
}
.chat-search {
    position: relative;
}
.chat-list {
    flex: 1;
    overflow-y: auto;
}
.chat-list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    cursor: pointer;
    transition: background 0.15s;
    border-bottom: 1px solid #f9fafb;
}
.chat-list-item:hover,
.chat-list-item.active {
    background: #f0f9f6;
}
.chat-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #005f5f, #007a7a);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
    font-family: 'DM Sans', sans-serif;
}
.chat-item-info {
    flex: 1;
    min-width: 0;
}
.chat-item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-item-name {
    font-weight: 600;
    font-size: 0.88rem;
    color: #005f5f;
}
.chat-item-time {
    font-size: 0.72rem;
    color: #9ca3af;
    white-space: nowrap;
}
.chat-item-preview {
    font-size: 0.8rem;
    color: #9ca3af;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 2px;
}
.notif-badge {
    min-width: 20px;
    height: 20px;
    background: #d97706;
    color: #fff;
    border-radius: 50%;
    font-size: 0.68rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}
.chat-main {
    display: flex;
    flex-direction: column;
}
.chat-main-header {
    padding: 16px 24px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 12px;
}
.chat-main-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}
.chat-messages-area {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.chat-bubble-wrapper {
    max-width: 70%;
}
.chat-bubble-wrapper.sent {
    align-self: flex-end;
}
.chat-bubble-wrapper.received {
    align-self: flex-start;
}
.chat-bubble {
    padding: 12px 18px;
    border-radius: 16px;
    font-size: 0.88rem;
    line-height: 1.5;
}
.chat-bubble.sent {
    background: #005f5f;
    color: #fff;
    border-bottom-right-radius: 4px;
}
.chat-bubble.received {
    background: #f3f4f6;
    color: #1f2937;
    border-bottom-left-radius: 4px;
}
.chat-bubble-time {
    font-size: 0.7rem;
    opacity: 0.6;
    margin-top: 4px;
}
.chat-system-msg {
    text-align: center;
    font-size: 0.78rem;
    color: #9ca3af;
    padding: 8px 0;
    margin-bottom: 4px;
}
.chat-input-area {
    padding: 16px 24px;
    border-top: 1px solid #f3f4f6;
    display: flex;
    gap: 12px;
    align-items: center;
}
.chat-attach-btn, .chat-send-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: background 0.2s;
}
.chat-attach-btn {
    background: transparent;
    color: #6e7979;
}
.chat-attach-btn:hover {
    background: #f3f4f6;
}
.chat-send-btn {
    background: #005f5f;
    color: #fff;
}
.chat-send-btn:hover {
    background: #004f4f;
}
.chat-header-status {
    font-size: 0.8rem;
}
</style>

@push('scripts')
<script>
let pollInterval;
let failCount = 0;
let lastPollTime = Math.floor(Date.now() / 1000);
const conversaId = {{ $conversaActiva ? $conversaActiva->id : 'null' }};
const currentUserId = {{ Auth::id() }};

document.addEventListener('DOMContentLoaded', () => {
    const area = document.querySelector('.chat-messages-area');
    if (area) area.scrollTop = area.scrollHeight;

    const inputAnexo = document.getElementById('input-anexo');
    if (inputAnexo) {
        inputAnexo.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                document.getElementById('anexo-nome').textContent = this.files[0].name;
                document.getElementById('anexo-pill').style.display = 'flex';
            }
        });
    }

    if (conversaId) {
        startPolling();
    }
});

function removerAnexo() {
    document.getElementById('input-anexo').value = '';
    document.getElementById('anexo-pill').style.display = 'none';
}

function startPolling() {
    pollInterval = setInterval(fetchNovasMensagens, 5000);
}

function fetchNovasMensagens() {
    if (!conversaId) return;

    fetch(`/profissional/mensagens/${conversaId}/novas?desde=${lastPollTime}`)
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            failCount = 0;
            const statusEl = document.getElementById('chat-status');
            if (statusEl) {
                statusEl.textContent = '● Disponível';
                statusEl.style.color = '#10B981';
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
                    statusEl.textContent = '○ Indisponível';
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
        wrapper.className = isSent ? 'chat-bubble-wrapper sent' : 'chat-bubble-wrapper received';
        wrapper.id = 'msg-' + msg.id;

        let anexoHtml = '';
        if (msg.anexo_url) {
            const borderTopColor = isSent ? 'rgba(255,255,255,0.2)' : 'rgba(0,0,0,0.1)';
            anexoHtml = `
                <div style="margin-top: 8px; border-top: 1px solid ${borderTopColor}; padding-top: 8px;">
                    <a href="${msg.anexo_url}" download style="color: inherit; text-decoration: underline; font-size: 0.85rem;">
                        <span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle;">attach_file</span> Descarregar Anexo
                    </a>
                </div>
            `;
        }

        const bubbleClass = isSent ? 'sent' : 'received';
        wrapper.innerHTML = `
            <div class="chat-bubble ${bubbleClass}">
                ${msg.texto}
                ${anexoHtml}
            </div>
            <div class="chat-bubble-time">${msg.hora}</div>
        `;

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
@endpush
@endsection
