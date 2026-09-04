@extends('layouts.app')

@section('content')
<!-- HERO SECTION ESTATICO -->
<section class="hero-static">
    <img src="{{ asset('assets/Consultoria2 - Cópia.jpg') }}" class="static-img" alt="Planos">
    <div class="hero-overlay-layer"></div>

    <div class="hero-content-static">
        <div class="badge-tag">
            <span class="badge-dot" style="background: #eab308;"></span> Cobertura Completa
        </div>
        <h1>NOSSOS<span> PLANOS</span></h1>
        <p>Oferecemos soluções completas para famílias, empresas, crianças e indivíduos, garantindo cuidado
            emocional, bem-estar e suporte especializado para todas as idades e contextos.</p>
    </div>
</section>

<div class="servicos-page-wrapper">
    <!-- Main Header -->
    <section class="servicos-header-section animate-on-scroll">
        <div class="badge fade-up-on-scroll">PLANOS</div>
        <h1 class="fade-up-on-scroll delay-100">Escolha o <span>plano de saúde mental ideal</span></h1>
        <p class="fade-up-on-scroll delay-200">Seja para si, para a sua família ou empresa, nós temos o plano que se
            adapta perfeitamente à sua necessidade.</p>
    </section>

    <!-- Tabs Navigation -->
    <div class="servicos-tabs animate-on-scroll">
        <button class="servicos-tab-btn active fade-up-on-scroll delay-300" onclick="openTab(event, 'particular')">
            <i class="fa-solid fa-user"></i> Particular
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-500" onclick="openTab(event, 'familiar')">
            <i class="fa-solid fa-house-user"></i> Familiar
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-600" onclick="openTab(event, 'corporativo')">
            <i class="fa-solid fa-briefcase"></i> Corporativo
        </button>
    </div>

    <!-- Tab Content -->
    <div class="servicos-content-container animate-on-scroll">
        <!-- Particular -->
        <div id="particular" class="servicos-tab-pane active fade-up-on-scroll delay-700">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano2.png') }}" alt="Plano Particular" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">01</div>
                <div class="servicos-subtitle">PLANO INDIVIDUAL</div>
                <h2 class="servicos-title">Particular</h2>
                <p class="servicos-desc">Ideal para indivíduos que buscam um acompanhamento contínuo, personalizado
                    e focado no desenvolvimento do bem-estar emocional.</p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Consultas individuais</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Avaliação inicial</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Suporte via chat</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Relatórios trimestrais</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Descontos em exames</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Acesso a workshops</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Lembretes automáticos</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Sessões de SOS</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ route('planos.particular') }}" class="btn-primary-sc">Ver planos</a>
                </div>
            </div>
        </div>

        <!-- Familiar -->
        <div id="familiar" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano3.png') }}" alt="Plano Família" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">02</div>
                <div class="servicos-subtitle">FAMILIAR</div>
                <h2 class="servicos-title">Familiar</h2>
                <p class="servicos-desc">Cobertura integral para todos os membros da casa, garantindo harmonia nas
                    relações e suporte psicológico para toda a família.</p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia familiar</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Até 5 dependentes</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Check-up emocional</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Canais exclusivos</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Palestras p/ pais</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Apoio a cuidadores</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Prioridade de agenda</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Reembolso estendido</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ route('planos.familiar') }}" class="btn-primary-sc">Ver planos</a>
                </div>
            </div>
        </div>

        <!-- Corporativo -->
        <div id="corporativo" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano4.png') }}" alt="Plano Corporativo" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">03</div>
                <div class="servicos-subtitle">EMPRESAS</div>
                <h2 class="servicos-title">Corporativo</h2>
                <p class="servicos-desc">Soluções estratégicas de saúde mental para empresas que valorizam o capital
                    humano e o bem-estar das suas equipas.</p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Gestão de estresse</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Diagnóstico de clima</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Mentoria liderança</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Workshops mensais</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Dashboards RH</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> SOS corporativo</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Soft skills training</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Palestras de saúde</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ route('planos.corporativo') }}" class="btn-primary-sc">Ver planos</a>
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
                <a href="{{ route('login') }}" class="btn-primary-sc">Aderir a um Plano</a>
                <a href="{{ url('/sobre') }}" class="btn-secondary-sc">Falar com a Equipa</a>
            </div>
        </div>
    </section>
</div>
@endsection
