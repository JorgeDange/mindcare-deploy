@extends('layouts.app')

@section('content')
<!-- HERO SECTION ESTATICO -->
<section class="hero-static">
    <img src="{{ asset('assets/Consultoria2 - Cópia.jpg') }}" class="static-img" alt="Sobre">
    <div class="hero-overlay-layer"></div>

    <div class="hero-content-static">
        <div class="badge-tag">
            <span class="badge-dot" style="background: #eab308;"></span> Soluções Empresariais
        </div>
        <h1>PLANO<span> CORPORATIVO</span></h1>
        <p>Soluções estratégicas de saúde mental para empresas que valorizam o capital humano e o bem-estar das suas
            equipas.</p>
    </div>
</section>

<div class="servicos-page-wrapper">
    <!-- Main Header -->
    <section class="servicos-header-section animate-on-scroll">
        <div class="badge fade-up-on-scroll">PLANOS CORPORATIVOS</div>
        <h1 class="fade-up-on-scroll delay-100">Saúde mental como <span>estratégia empresarial</span></h1>
        <p class="fade-up-on-scroll delay-200">Invista no bem-estar dos seus colaboradores e veja os resultados na
            produtividade e retenção de talentos.</p>
    </section>

    <!-- Tabs Navigation -->
    <div class="servicos-tabs animate-on-scroll">
        <button class="servicos-tab-btn active fade-up-on-scroll delay-300" onclick="openTab(event, 'essencial')">
            <i class="fa-solid fa-building"></i> Essencial
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-400" onclick="openTab(event, 'profissional')">
            <i class="fa-solid fa-city"></i> Profissional
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-500" onclick="openTab(event, 'enterprise')">
            <i class="fa-solid fa-crown"></i> Enterprise
        </button>
    </div>

    <!-- Tab Content -->
    <div class="servicos-content-container animate-on-scroll">
        <!-- Essencial -->
        <div id="essencial" class="servicos-tab-pane active fade-up-on-scroll delay-700">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano4.png') }}" alt="Plano Corporativo Essencial">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">01</div>
                <div class="servicos-subtitle">PLANO ESSENCIAL</div>
                <h2 class="servicos-title">Até 20 colaboradores</h2>
                <p class="servicos-desc">Ideal para pequenas empresas que querem iniciar um programa de saúde
                    mental.<br><small style="color:#61D0AD;">Proposta personalizada mediante consulta</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Diagnóstico de clima
                        organizacional</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 2 workshops por trimestre
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Linha de apoio para
                        colaboradores</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir Agora</a>
                </div>
            </div>
        </div>

        <!-- Profissional -->
        <div id="profissional" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano4-1.png') }}" alt="Plano Corporativo Profissional">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">02</div>
                <div class="servicos-subtitle">PLANO PROFISSIONAL</div>
                <h2 class="servicos-title">Até 100 colaboradores</h2>
                <p class="servicos-desc">Para empresas médias com necessidades de acompanhamento
                    estruturado.<br><small style="color:#61D0AD;">Proposta personalizada mediante consulta</small>
                </p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Tudo do plano Essencial</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Mentoria de liderança mensal
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Dashboards de RH</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Soft skills training
                        trimestral</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir Agora</a>
                </div>
            </div>
        </div>

        <!-- Enterprise -->
        <div id="enterprise" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/card/plano4-2.png') }}" alt="Plano Corporativo Enterprise">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">03</div>
                <div class="servicos-subtitle">PLANO ENTERPRISE</div>
                <h2 class="servicos-title">Ilimitado</h2>
                <p class="servicos-desc">Solução completa para grandes empresas e multinacionais.<br><small
                        style="color:#61D0AD;">Proposta personalizada mediante consulta</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Tudo do plano Profissional
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Psicólogo residente na empresa
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Programa de gestão de estresse
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> SOS corporativo 24h</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ auth()->check() ? route('plano') : route('login') }}" class="btn-primary-sc">Aderir Agora</a>
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
            <h2>Porquê escolher o plano <b>Corporativo</b>?</h2>
            <p>Benefícios estratégicos que impactam directamente a performance e o bem-estar da sua equipa.</p>
        </div>

        <div class="visao-geral-grid">
            <div class="vg-card fade-up-on-scroll delay-100">
                <div class="vg-icon"><i class="fa-solid fa-chart-line"></i></div>
                <h3>Aumento de Produtividade</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-200">
                <div class="vg-icon"><i class="fa-solid fa-users-gear"></i></div>
                <h3>Retenção de Talentos</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-300">
                <div class="vg-icon"><i class="fa-solid fa-shield-heart"></i></div>
                <h3>Prevenção de Burnout</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-400">
                <div class="vg-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                <h3>Formação de Líderes</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-500">
                <div class="vg-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                <h3>Relatórios Detalhados</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-600">
                <div class="vg-icon"><i class="fa-solid fa-handshake"></i></div>
                <h3>Parceiro Estratégico</h3>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-bottom-section animate-on-scroll fade-up-on-scroll delay-200">
        <div class="cta-container">
            <h2>Pronto para transformar a sua empresa?</h2>
            <p>Solicite uma proposta personalizada e descubra como a MindCare pode impactar positivamente a sua
                organização.</p>
            <div class="cta-actions">
                <a href="{{ url('/sobre') }}" class="btn-primary-sc">Solicitar Proposta</a>
                <a href="{{ url('/sobre') }}" class="btn-secondary-sc">Falar com a Equipa</a>
            </div>
        </div>
    </section>
</div>
@endsection
