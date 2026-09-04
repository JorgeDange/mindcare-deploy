@extends('layouts.app')

@section('content')
<!-- HERO SECTION ESTATICO -->
<section class="hero-static">
    <img src="{{ asset('assets/Consultoria2 - Cópia.jpg') }}" class="static-img" alt="Sobre">
    <div class="hero-overlay-layer"></div>

    <div class="hero-content-static">
        <div class="badge-tag">
            <span class="badge-dot" style="background: #eab308;"></span> Plano Individual
        </div>
        <h1>PLANO<span> PARTICULAR</span></h1>
        <p>Acompanhamento psicológico personalizado e contínuo, pensado para quem valoriza o autocuidado e deseja
            investir no seu bem-estar emocional com profissionais de excelência.</p>
    </div>
</section>

<div class="servicos-page-wrapper">
    <!-- Main Header -->
    <section class="servicos-header-section animate-on-scroll">
        <div class="badge fade-up-on-scroll">PLANOS PARTICULARES</div>
        <h1 class="fade-up-on-scroll delay-100">Cuidado mental contínuo e acessível <span>para si</span></h1>
        <p class="fade-up-on-scroll delay-200">Escolha o plano que melhor se adapta às suas necessidades e tenha
            acompanhamento profissional de forma consistente.</p>
    </section>

    <!-- Tabs Navigation -->
    <div class="servicos-tabs animate-on-scroll">
        <button class="servicos-tab-btn active fade-up-on-scroll delay-300" onclick="openTab(event, 'basico')">
            <i class="fa-solid fa-leaf"></i> Básico
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-400" onclick="openTab(event, 'avancado')">
            <i class="fa-solid fa-shield-heart"></i> Avançado
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-500" onclick="openTab(event, 'premium')">
            <i class="fa-solid fa-crown"></i> Premium
        </button>
    </div>

    <!-- Tab Content -->
    <div class="servicos-content-container animate-on-scroll">
        <!-- Básico -->
        <div id="basico" class="servicos-tab-pane active fade-up-on-scroll delay-700">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano2.png') }}" alt="Plano Básico" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">01</div>
                <div class="servicos-subtitle">PLANO BÁSICO</div>
                <h2 class="servicos-title">50.000 Kz <span style="font-size: 1.2rem; color: #6c757d;">/ mês</span>
                </h2>
                <p class="servicos-desc">Para quem quer começar e ter suporte contínuo.<br><small
                        style="color:#61D0AD;">Nota: Pagamento mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 2 consultas por mês</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Linha de apoio 24h
                        (intervenção em crise)</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 20% de desconto em workshops e
                        palestras</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir agora</a>
                </div>
            </div>
        </div>

        <!-- Avançado -->
        <div id="avancado" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano2-1.png') }}" alt="Plano Avançado" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">02</div>
                <div class="servicos-subtitle">PLANO AVANÇADO</div>
                <h2 class="servicos-title">70.000 Kz <span style="font-size: 1.2rem; color: #6c757d;">/ mês</span>
                </h2>
                <p class="servicos-desc">Para quem precisa de acompanhamento mais completo.<br><small
                        style="color:#61D0AD;">Nota: Pagamento mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 4 consultas por mês</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 1 consulta psiquiátrica por
                        trimestre</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Teleconsulta de emergência
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Avaliação anual completa</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir agora</a>
                </div>
            </div>
        </div>

        <!-- Premium -->
        <div id="premium" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano2-2.png') }}" alt="Plano Premium" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">03</div>
                <div class="servicos-subtitle">PLANO PREMIUM</div>
                <h2 class="servicos-title">139.000 Kz <span style="font-size: 1.2rem; color: #6c757d;">/ mês</span>
                </h2>
                <p class="servicos-desc">Para acompanhamento intensivo e familiar.<br><small
                        style="color:#61D0AD;">Nota: Pagamento mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 6 consultas por mês</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 1 consulta psiquiátrica por
                        mês</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 2 terapias familiares por ano
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Workshops gratuitos</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir agora</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("servicos-tab-pane");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                tabcontent[i].className = tabcontent[i].className.replace(" active", "");
            }
            tablinks = document.getElementsByClassName("servicos-tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "flex";
            document.getElementById(tabName).className += " active";
            evt.currentTarget.className += " active";
        }
    </script>

    <!-- Vantagens Section -->
    <section class="visao-geral-section animate-on-scroll">
        <div class="visao-geral-header fade-up-on-scroll">
            <div class="servicos-subtitle">VANTAGENS</div>
            <h2>Porquê escolher a <b>MindCare</b>?</h2>
            <p>Descubra os benefícios exclusivos de ter um plano de saúde mental connosco e garanta acompanhamento
                de excelência.</p>
        </div>

        <div class="visao-geral-grid">
            <div class="vg-card fade-up-on-scroll delay-100">
                <div class="vg-icon"><i class="fa-solid fa-headset"></i></div>
                <h3>Suporte 24/7</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-200">
                <div class="vg-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <h3>Sem Período de Carência</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-300">
                <div class="vg-icon"><i class="fa-solid fa-user-doctor"></i></div>
                <h3>Especialistas de Topo</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-400">
                <div class="vg-icon"><i class="fa-solid fa-house-medical"></i></div>
                <h3>Cobertura Alargada</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-500">
                <div class="vg-icon"><i class="fa-solid fa-credit-card"></i></div>
                <h3>Flexibilidade de Pagamento</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-600">
                <div class="vg-icon"><i class="fa-solid fa-star"></i></div>
                <h3>Atendimento Prioritário</h3>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-bottom-section animate-on-scroll fade-up-on-scroll delay-200">
        <div class="cta-container">
            <h2>Pronto para investir na sua saúde mental?</h2>
            <p>Fale connosco hoje mesmo e encontre o plano perfeito para si, para a sua família ou para a sua
                empresa.</p>
            <div class="cta-actions">
                <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir a um Plano</a>
                <a href="{{ url('/sobre') }}" class="btn-secondary-sc">Falar com a Equipa</a>
            </div>
        </div>
    </section>
</div>
@endsection
