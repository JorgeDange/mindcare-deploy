<section>
    <!-- BOTÃO -->
    <div id="support-btn">
        <i class="fa-regular fa-comment-dots"></i>
    </div>

    <!-- CHAT -->
    <div id="chat-container">
        <div id="chat-header">
            <div class="header-info">
                <img src="{{ asset('assets/logoti.png') }}" alt="MindCare">
                <div>
                    <strong>MindCare</strong>
                    <span>Online | Assistente Virtual</span>
                </div>
            </div>
            <button class="close-chat" id="close-chat">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div id="chat-disclaimer" class="disclaimer-banner">
            Este é um assistente virtual. Para apoio clínico urgente, contacte um profissional.
        </div>
        <div id="chat-messages"></div>

        <div id="chat-input" onsubmit="event.preventDefault(); enviar()">
            <div class="input-wrapper">
                <input id="prompt" placeholder="Como posso ajudar?" style="border:none;outline: none;" aria-label="Campo de entrada para mensagens" />
            </div>
            <button onclick="enviar()" aria-label="Enviar mensagem">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script>
        (function () {
            function init() {
                var btn = document.getElementById('support-btn');
                var chat = document.getElementById('chat-container');
                var alvo = document.getElementById('contacto');

                if (!btn || !chat || !alvo) return;

                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            btn.classList.add('chat-left');
                            chat.classList.add('chat-left');
                        } else {
                            btn.classList.remove('chat-left');
                            chat.classList.remove('chat-left');
                        }
                    });
                }, { threshold: 0.1 });

                observer.observe(alvo);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>
</section>
