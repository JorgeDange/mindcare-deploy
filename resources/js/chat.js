let historico = [];

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
const btn = document.getElementById('support-btn');
const chat = document.getElementById('chat-container');
const messages = document.getElementById('chat-messages');
const input = document.getElementById('prompt');
const closeChat = document.getElementById('close-chat');

const toggleChat = () => {
    const isVisible = chat.style.display === 'flex';
    chat.style.display = isVisible ? 'none' : 'flex';
    if (!isVisible) {
        input.focus();
    }
};

btn.onclick = toggleChat;
if (closeChat) closeChat.onclick = toggleChat;

input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') window.enviar();
});

function add(text, type) {
    const div = document.createElement('div');
    div.className = `message ${type}`;
    div.innerHTML = text.replace(/\n/g, '<br>');
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}

function typing() {
    const t = document.createElement('div');
    t.className = 'message bot typing';
    t.textContent = 'A escrever...';
    messages.appendChild(t);
    return t;
}

window.enviar = async () => {
    if (!input.value) return;

    const pergunta = input.value;
    add(pergunta, 'user');
    input.value = '';

    const t = typing();

    const body = { mensagem: pergunta };
    const ultimas = historico.slice(-10);
    if (ultimas.length > 0) body.historico = ultimas;

    try {
        const res = await fetch('/chatbot/enviar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(body),
        });

        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const data = await res.json();

        t.remove();
        add(data.resposta, 'bot');

        historico.push({ role: 'user', text: pergunta });
        historico.push({ role: 'assistant', text: data.resposta });
        if (historico.length > 20) historico = historico.slice(-20);

    } catch (e) {
        t.remove();
        add('Desculpe, ocorreu um erro. Por favor, tente novamente.', 'bot');
        console.error(e);
    }
};
