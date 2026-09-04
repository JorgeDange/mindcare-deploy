@extends('layouts.app')

@section('content')
<!-- HERO SECTION ESTATICO -->
<section class="hero-static">
    <img src="{{ asset('assets/Consultoria2 - Cópia.jpg') }}" class="static-img" alt="Serviços">
    <div class="hero-overlay-layer"></div>
    
    <div class="hero-content-static">
        <div class="badge-tag">
            <span class="badge-dot" style="background: #22d3ee;"></span> Especialidades
        </div>
        <h1>NOSSOS<span> SERVIÇOS</span></h1>
        <p>Transformamos vidas através de uma abordagem integrada e personalizada. A nossa equipa multidisciplinar oferece soluções completas em saúde mental, desenvolvimento profissional e consultoria organizacional.</p>
    </div>
</section>

<div class="servicos-page-wrapper">
    <!-- Main Header -->
    <section class="servicos-header-section animate-on-scroll">
        <div class="badge fade-up-on-scroll">SERVIÇOS</div>
        <h1 class="fade-up-on-scroll delay-100">Escolha os <span>Serviços de Psicologia</span></h1>
        <p class="fade-up-on-scroll delay-200">Atendimento especializado e humanizado para o seu bem-estar integral</p>
    </section>

    <!-- Tabs Navigation -->
    <div class="servicos-tabs animate-on-scroll">
        <button class="servicos-tab-btn active fade-up-on-scroll delay-300" onclick="openTab(event, 'clinica')">
            <i class="fa-solid fa-house-medical"></i> Área Clínica
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-400" onclick="openTab(event, 'formacao')">
            <i class="fa-solid fa-graduation-cap"></i> Formação
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-500" onclick="openTab(event, 'consultoria')">
            <i class="fa-solid fa-briefcase"></i> Consultoria
        </button>
    </div>

    <!-- Tab Content -->
    <div class="servicos-content-container animate-on-scroll">
        <!-- Área Clínica -->
        <div id="clinica" class="servicos-tab-pane active fade-up-on-scroll delay-600">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/Consultoria2 - Cópia.jpg') }}" alt="Atendimento Clínico" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">01</div>
                <div class="servicos-subtitle">ÁREA CLÍNICA</div>
                <h2 class="servicos-title">Atendimento Clínico</h2>
                <p class="servicos-desc">Oferecemos acompanhamento psicológico personalizado para todas as fases da vida, com abordagens baseadas em evidências científicas.</p>
                
                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Avaliação psicológica</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Psicoterapia individual</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia de casal e familiar</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia da fala</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia ocupacional</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia ABA</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Psiquiatria</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia de grupo</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Orientação vocacional</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Intervenção precoce</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ route('login') }}" class="btn-primary-sc">Agendar consulta</a>
                </div>
            </div>
        </div>

        <!-- Formação -->
        <div id="formacao" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/TREINAMENTO IV (1).jpg') }}" alt="Formação" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">02</div>
                <div class="servicos-subtitle">FORMAÇÃO</div>
                <h2 class="servicos-title">Estágios e Supervisão</h2>
                <p class="servicos-desc">Programas de desenvolvimento profissional com supervisão qualificada para psicólogos e estudantes de psicologia.</p>
                
                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Estágios supervisionados</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Supervisão clínica</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Supervisão organizacional</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Formações especializadas</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Desenvolvimento contínuo</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ route('login') }}" class="btn-primary-sc">Saber mais</a>
                </div>
            </div>
        </div>

        <!-- Consultoria -->
        <div id="consultoria" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="{{ asset('assets/MIND_PCA VI.jpg') }}" alt="Consultoria" loading="lazy" decoding="async">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">03</div>
                <div class="servicos-subtitle">CONSULTORIA</div>
                <h2 class="servicos-title">Soluções Empresariais</h2>
                <p class="servicos-desc">Consultoria estratégica para organizações que valorizam o bem-estar e desenvolvimento de suas equipas.</p>
                
                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Clima organizacional</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Saúde mental corporativa</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Consultoria em RH</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Mentoria de líderes</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Programas personalizados</div>
                </div>

                <div class="servicos-actions">
                    <a href="{{ url('/sobre') }}" class="btn-primary-sc">Solicitar proposta</a>
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

    <!-- Visão Geral Section -->
    <section class="visao-geral-section animate-on-scroll">
        <div class="visao-geral-header fade-up-on-scroll">
            <div class="badge">VISÃO GERAL</div>
            <h2>Tudo o que a MindCare <span>oferece</span></h2>
            <p>Uma plataforma completa de saúde mental para todas as necessidades</p>
        </div>

        <div class="visao-geral-grid">
            <div class="vg-card fade-up-on-scroll delay-100">
                <div class="vg-icon"><i class="fa-solid fa-brain"></i></div>
                <h3>Psicoterapia</h3>
                <p>Sessões individuais, de casal e família com psicólogos especializados.</p>
            </div>
            <div class="vg-card fade-up-on-scroll delay-200">
                <div class="vg-icon"><i class="fa-solid fa-child"></i></div>
                <h3>Psicologia Infantil</h3>
                <p>Cuidado especializado para crianças e adolescentes em todas as fases.</p>
            </div>
            <div class="vg-card fade-up-on-scroll delay-300">
                <div class="vg-icon"><i class="fa-solid fa-microscope"></i></div>
                <h3>Neuropsicologia</h3>
                <p>Avaliação e intervenção nas funções cognitivas e comportamentais.</p>
            </div>
            <div class="vg-card fade-up-on-scroll delay-400">
                <div class="vg-icon"><i class="fa-solid fa-building"></i></div>
                <h3>Consultoria Empresas</h3>
                <p>Programas estratégicos de saúde mental para organizações angolanas.</p>
            </div>
            <div class="vg-card fade-up-on-scroll delay-500">
                <div class="vg-icon"><i class="fa-solid fa-bullseye"></i></div>
                <h3>Terapia ABA</h3>
                <p>Análise do comportamento aplicada, especialmente para autismo.</p>
            </div>
            <div class="vg-card fade-up-on-scroll delay-600">
                <div class="vg-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <h3>Formação & Estágios</h3>
                <p>Supervisão e desenvolvimento contínuo para profissionais de psicologia.</p>
            </div>
        </div>
    </section>

    <!-- Bottom CTA -->
    <section class="cta-bottom-section animate-on-scroll">
        <div class="cta-container fade-up-on-scroll">
            <h2>Pronto para começar <span>o seu cuidado?</span></h2>
            <p>Agende uma consulta hoje e dê o primeiro passo para o seu bem-estar emocional.</p>
            <div class="cta-actions">
                <a href="{{ route('login') }}" class="btn-primary-sc">Agendar consulta</a>
                <a href="{{ url('/planos') }}" class="btn-secondary-sc">Ver planos</a>
            </div>
        </div>
    </section>
</div>
@endsection
