# UI-CHAT.md — Documentação do Design do Chat

## Visão Geral

Este documento descreve o design do chat implementado no painel do paciente e profissional do MindCare. O design segue o padrão **Material Design 3** com classes Tailwind CSS.

## Estrutura do Layout

```
┌─────────────────────────────────────────────────────────┐
│  Section (flex h-full p-stack-md gap-stack-md)          │
│  ┌──────────────────┬──────────────────────────────────┐│
│  │ Sidebar (1/3)    │ Chat Area (2/3)                  ││
│  │ - Header         │ - Header (avatar, nome, status)  ││
│  │ - Lista de       │ - Mensagens (bg radial)          ││
│  │   conversas      │ - Input (anexo + texto + enviar) ││
│  └──────────────────┴──────────────────────────────────┘│
└─────────────────────────────────────────────────────────┘
```

## Classes Tailwind Utilizadas

### Container Principal
```html
<section class="flex h-full p-stack-md gap-stack-md overflow-hidden bg-surface-container-low">
```

### Sidebar (Lista de Conversas)
```html
<div class="w-full md:w-1/3 bg-white rounded-2xl shadow-sm flex-col border border-outline-variant/30 overflow-hidden">
```

### Chat Area
```html
<div class="w-full md:flex-grow bg-white rounded-2xl shadow-sm flex-col overflow-hidden border border-outline-variant/30 relative">
```

### Item da Lista de Conversas
```html
<a href="..." class="flex items-center gap-4 p-4 transition-colors cursor-pointer {{ active ? 'bg-surface-container-high border-l-4 border-primary' : 'hover:bg-surface-container-low' }}">
```

### Avatar
```html
<!-- Com foto -->
<img src="..." alt="..." class="h-12 w-12 rounded-full object-cover">

<!-- Sem foto -->
<div class="h-12 w-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-sm">
    {{ iniciais }}
</div>
```

### Badge de Não Lidas
```html
<span class="absolute -top-1 -right-1 bg-error text-on-error font-bold text-[9px] min-w-[16px] h-[16px] rounded-full flex items-center justify-center px-1">
    {{ count }}
</span>
```

### Header do Chat
```html
<div class="p-4 border-b border-outline-variant/20 flex items-center justify-between bg-white/70 backdrop-blur-md sticky top-0 z-10">
```

### Status Online
```html
<span class="text-[10px] text-green-600 flex items-center gap-1 mt-0.5" id="chat-status">
    <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span> Online agora
</span>
```

### Área de Mensagens (Background)
```html
<div class="flex-grow overflow-y-auto chat-scroll p-6 space-y-6 bg-[radial-gradient(#bdc9c8_1px,transparent_1px)] [background-size:24px_24px] bg-fixed chat-messages-area">
```

### Separador de Data
```html
<div class="flex justify-center my-4">
    <span class="bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full text-[10px] font-medium">{{ date }}</span>
</div>
```

### Mensagem Recebida
```html
<div class="flex items-end gap-3 max-w-[80%]" id="msg-{{ id }}">
    <!-- Avatar (8x8) -->
    <img src="..." class="h-8 w-8 rounded-full object-cover shrink-0 mb-1">
    
    <!-- Bolha -->
    <div class="bg-white border border-outline-variant/30 p-4 rounded-2xl rounded-bl-none shadow-sm text-xs">
        <p class="text-on-surface leading-normal">{!! nl2br(e($texto)) !!}</p>
        
        <!-- Anexo (se existir) -->
        <div class="mt-3 bg-surface-container rounded-lg p-2.5 flex items-center gap-2.5 border border-outline-variant/20 hover:bg-surface-container-high transition-colors cursor-pointer">
            <span class="w-8 h-8 bg-primary-fixed text-primary rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[18px]">description</span>
            </span>
            <div class="flex-grow min-w-0">
                <a href="..." download class="font-bold text-on-surface truncate block text-[10px] hover:underline">{{ filename }}</a>
                <p class="text-[8px] text-on-surface-variant">Descarregar anexo</p>
            </div>
            <a href="..." download class="material-symbols-outlined text-on-surface-variant text-[18px]">download</a>
        </div>
        
        <span class="text-[9px] text-on-surface-variant block mt-2 text-right">{{ time }}</span>
    </div>
</div>
```

### Mensagem Enviada
```html
<div class="flex items-end gap-3 max-w-[80%] ml-auto flex-row-reverse" id="msg-{{ id }}">
    <!-- Bolha -->
    <div class="bg-primary text-on-primary p-4 rounded-2xl rounded-br-none shadow-md text-xs">
        <p class="leading-normal">{!! nl2br(e($texto)) !!}</p>
        
        <!-- Anexo (se existir) -->
        <div class="mt-3 bg-white/10 rounded-lg p-2.5 flex items-center gap-2.5 border border-white/20 hover:bg-white/20 transition-colors cursor-pointer">
            <span class="w-8 h-8 bg-white/10 text-white rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-[18px]">description</span>
            </span>
            <div class="flex-grow min-w-0">
                <a href="..." download class="font-bold text-white truncate block text-[10px] hover:underline">{{ filename }}</a>
                <p class="text-[8px] text-white/70">Descarregar anexo</p>
            </div>
            <a href="..." download class="material-symbols-outlined text-white text-[18px]">download</a>
        </div>
        
        <span class="text-[9px] text-primary-fixed/70 block mt-2 text-right">{{ time }}</span>
    </div>
</div>
```

### Input de Mensagem
```html
<form action="..." method="POST" enctype="multipart/form-data" class="p-4 bg-surface border-t border-outline-variant/20" style="margin: 0;">
    @csrf
    <input type="hidden" name="conversa_id" value="{{ id }}">
    <input type="file" name="anexo" id="input-anexo" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" style="display:none">
    
    <div class="flex items-end gap-3">
        <!-- Botão Anexo -->
        <button type="button" class="w-12 h-12 hover:bg-surface-variant rounded-full flex items-center justify-center text-on-surface-variant" title="Anexar Ficheiro" onclick="document.getElementById('input-anexo').click()">
            <span class="material-symbols-outlined text-[20px]">attach_file</span>
        </button>
        
        <!-- Caixa de Texto -->
        <div class="flex-1 bg-surface-container rounded-2xl px-4 py-2.5 flex flex-col gap-2 min-h-[48px] justify-center relative">
            <!-- Pill do Anexo (hidden por padrão) -->
            <div id="anexo-pill" class="hidden bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-semibold self-start flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px]">attachment</span>
                <span id="anexo-nome" class="max-w-[120px] truncate"></span>
                <button type="button" onclick="removerAnexo()" class="text-error font-bold text-xs hover:opacity-85 hover:scale-115 transition-all outline-none">
                    <span class="material-symbols-outlined text-[14px] align-middle">close</span>
                </button>
            </div>
            <input type="text" name="texto" placeholder="Escreva a sua mensagem..." required class="w-full bg-transparent border-none focus:ring-0 text-body-sm outline-none resize-none p-1">
        </div>
        
        <!-- Botão Enviar -->
        <button type="submit" class="h-12 w-12 bg-primary text-on-primary rounded-full flex items-center justify-center shadow-lg active:scale-95 hover:opacity-90 transition-all">
            <span class="material-symbols-outlined">send</span>
        </button>
    </div>
</form>
```

### Estado Vazio (Sem Conversa Selecionada)
```html
<div class="flex flex-col items-center justify-center h-full text-on-surface-variant p-6">
    <span class="material-symbols-outlined text-5xl opacity-25 mb-3">chat_bubble</span>
    <p class="font-semibold text-on-surface text-sm">Nenhuma conversa seleccionada</p>
    <p class="text-xs mt-1 text-center">Seleccione um paciente na coluna esquerda para iniciar ou prosseguir a conversa.</p>
</div>
```

## JavaScript (Polling)

### Variáveis Globais
```javascript
let pollInterval;
let failCount = 0;
let lastPollTime = Math.floor(Date.now() / 1000);
const conversaId = {{ $conversaActiva ? $conversaActiva->id : 'null' }};
const currentUserId = {{ Auth::id() }};
const pacienteAvatarUrl = @json(...);
const pacienteInitials = @json(...);
```

### Polling de Mensagens (3 segundos)
```javascript
function startPolling() {
    pollInterval = setInterval(fetchNovasMensagens, 3000);
}

function fetchNovasMensagens() {
    fetch(`/admin/mensagens/${conversaId}/novas?desde=${lastPollTime}`)
        .then(response => response.json())
        .then(data => {
            failCount = 0;
            // Atualizar status para "Online agora"
            if (data.mensagens && data.mensagens.length > 0) {
                appendMessages(data.mensagens);
            }
            lastPollTime = Math.floor(Date.now() / 1000);
        })
        .catch(error => {
            failCount++;
            if (failCount >= 3) {
                // Atualizar status para "Indisponível"
            }
        });
}
```

### Append de Mensagens (Dinâmico)
```javascript
function appendMessages(mensagens) {
    const area = document.querySelector('.chat-messages-area');
    let shouldScroll = false;
    
    mensagens.forEach(msg => {
        if (document.getElementById('msg-' + msg.id)) return;
        
        shouldScroll = true;
        const isSent = msg.remetente_id === currentUserId;
        
        // Criar wrapper com classes baseado em isSent
        // Adicionar anexo HTML se existir
        // Append ao area
    });
    
    if (shouldScroll) {
        area.scrollTop = area.scrollHeight;
    }
}
```

## CSS Adicional

### Scroll Customizado
```css
.chat-scroll::-webkit-scrollbar {
    width: 4px;
}
.chat-scroll::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}
.chat-scroll::-webkit-scrollbar-track {
    background: transparent;
}
```

## Endpoints Necessários

Para o painel administrativo, são necessários os seguintes endpoints:

1. `GET /admin/mensagens` — Lista de conversas
2. `GET /admin/mensagens/{conversa}` — Abrir conversa
3. `POST /admin/mensagens/store` — Enviar mensagem
4. `GET /admin/mensagens/{conversa}/novas?desde={timestamp}` — Polling de novas mensagens

## Observações

- O design utiliza **Material Symbols** para ícones
- As cores seguem o padrão **Material Design 3** (primary, secondary, error, etc.)
- O background das mensagens utiliza um padrão radial sutil
- As mensagens enviadas ficam à direita (azul), recebidas à esquerda (branco)
- O polling é feito a cada 3 segundos via HTTP (sem WebSockets)
- O status "Online agora" muda para "Indisponível" após 3 erros consecutivos
