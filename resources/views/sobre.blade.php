@extends('layouts.app')

@section('content')
    <!-- HERO SECTION ESTATICO -->
    <section class="hero-static">
        <img src="{{ asset('assets/TRIO III.jpg') }}" class="static-img" alt="Sobre">
        <div class="hero-overlay-layer"></div>

        <div class="hero-content-static">
            <div class="badge-tag">
                <span class="badge-dot" style="background: #3b82f6;"></span> Institucional
            </div>
            <h1>QUEM<span> SOMOS</span></h1>
            <p>A Mind Care é uma instituição de referência em saúde mental, formação e consultoria organizacional em
                Angola. Combinamos atendimento especializado, formação de excelência e soluções estratégicas.</p>
        </div>
    </section>


    <section class="about-pillars">
        <div class="pillars-container">
            <!-- Abordagem -->
            <div class="pillar-card">
                <div class="pillar-icon">
                    <i data-lucide="heart-handshake"></i>
                </div>
                <h3>A Nossa Abordagem</h3>
                <p>Trabalhamos com foco na humanização, na ciência psicológica e na inovação. Acreditamos que o
                    equilíbrio emocional transforma vidas, melhora o desempenho e fortalece as relações nos indivíduos e
                    nas organizações.</p>
            </div>

            <!-- Visão -->
            <div class="pillar-card highlight">
                <div class="pillar-icon">
                    <i data-lucide="eye"></i>
                </div>
                <h3>Visão</h3>
                <p>Ser referência nacional em diagnóstico, intervenção, prevenção e promoção da saúde mental em
                    ambientes corporativos e individuais.</p>
            </div>

            <!-- Missão -->
            <div class="pillar-card">
                <div class="pillar-icon">
                    <i data-lucide="target"></i>
                </div>
                <h3>Missão</h3>
                <p>Oferecer cuidados especializados em saúde mental para todas as faixas etárias e contextos, de forma
                    inclusiva, humanizada e eficaz.</p>
            </div>
        </div>
    </section>
    <section class="valores-section">
        <h2 class="valores-title">Valores</h2>

        <div class="valores-grid">
            <div class="valor-card">
                <div class="valor-icon"><i data-lucide="heart"></i></div>
                <p>Humanização</p>
            </div>

            <div class="valor-card">
                <div class="valor-icon">
                    <i data-lucide="scale"></i>
                </div>
                <p>Ética</p>
            </div>

            <div class="valor-card">
                <div class="valor-icon"><i data-lucide="award"></i></div>
                <p>Excelência</p>
            </div>

            <div class="valor-card">
                <div class="valor-icon">
                    <i data-lucide="check-square"></i>
                </div>
                <p>Responsabilidade</p>
            </div>

            <div class="valor-card">
                <div class="valor-icon">
                    <i data-lucide="shield-check"></i>
                </div>
                <p>Confidencialidade</p>
            </div>

            <div class="valor-card">
                <div class="valor-icon"><i data-lucide="sun"></i></div>
                <p>Impacto Positivo</p>
            </div>
        </div>
    </section>

    <section class="servicos-premium-section">
        <h2 class="sp-main-title">Serviços</h2>

        <div class="sp-top-bracket"></div>

        <div class="sp-grid">
            <!-- Column 1: Clínica -->
            <div class="sp-column">
                <h3 class="sp-col-title">Área<br><em>Clínica</em></h3>
                <div class="sp-card">
                    <ul class="sp-list">
                        <li>Avaliação psicológica</li>
                        <li>Psicoterapia individual<br>(infantil, adolescente,<br>adulto e idoso)</li>
                        <li>Terapia de casal e<br>familiar</li>
                        <li>Terapia da fala</li>
                        <li>Terapia ocupacional</li>
                        <li>Terapia ABA</li>
                        <li>Psiquiatria</li>
                        <li>Dinâmicas e terapia<br>de grupo</li>
                        <li>Orientação vocacional<br>e profissional</li>
                        <li>Apoio a pais atípicos e<br>intervenção precoce</li>
                    </ul>
                </div>
                <a href="{{ url('/servicos') }}" class="sp-saiba-mais">Saiba mais <i
                        class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>

            <!-- Column 2: Académica -->
            <div class="sp-column">
                <h3 class="sp-col-title">Área<br><em>Académica</em></h3>
                <div class="sp-card">
                    <ul class="sp-list">
                        <li>Estágios<br>supervisionados<br>(Clínica,<br>Organizacional e<br>Criminal)</li>
                        <li>Supervisão<br>profissional individual<br>e em grupo</li>
                        <li>Cursos e formações<br>diversas em Psicologia</li>
                        <li>Programas de<br>desenvolvimento<br>contínuo para<br>profissionais</li>
                    </ul>
                </div>
                <a href="{{ url('/servicos') }}" class="sp-saiba-mais">Saiba mais <i
                        class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>

            <!-- Column 3: Consultoria -->
            <div class="sp-column">
                <h3 class="sp-col-title">Área de<br>Consultoria<br><em>para Empresas</em></h3>
                <div class="sp-card">
                    <ul class="sp-list">
                        <li>Avaliação de clima<br>organizacional</li>
                        <li>Programas de saúde<br>mental corporativa</li>
                        <li>Consultoria e<br>mentoria em Recursos<br>Humanos</li>
                        <li>Intervenções<br>personalizadas para<br>equipas</li>
                        <li>Diagnóstico<br>organizacional e<br>recomendações<br>estratégicas</li>
                    </ul>
                </div>
                <a href="{{ url('/servicos') }}" class="sp-saiba-mais">Saiba mais <i
                        class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </div>
    </section>

    <section class="quem-atendemos">
        <h2>Quem atendemos</h2>

        <div class="lista">

            <div class="item">
                <div class="icon_c">
                    <img src="{{ asset('assets/social.png') }}" alt="">
                </div>
                <div class="texto">
                    <h3>Indivíduos</h3>
                    <p>
                        Acolhemos crianças, adolescentes, adultos e idosos que procuram apoio psicológico ou
                        psiquiátrico,
                        com atendimento especializado e personalizado.
                    </p>
                </div>
            </div>

            <div class="item">
                <div class="icon_c">
                    <img src="{{ asset('assets/family.png') }}" alt="">
                </div>
                <div class="texto">
                    <h3>Famílias</h3>
                    <p>
                        Acompanhamos famílias que necessitam de orientação, intervenção precoce ou suporte contínuo
                        para o desenvolvimento emocional dos seus membros.
                    </p>
                </div>
            </div>

            <div class="item">
                <div class="icon_c">
                    <img src="{{ asset('assets/comunity.png') }}" alt="">
                </div>
                <div class="texto">
                    <h3>Estudantes e Profissionais</h3>
                    <p>
                        Recebemos estudantes e profissionais de Psicologia interessados em estágios, supervisão,
                        prática real e formações de alto nível.
                    </p>
                </div>
            </div>

            <div class="item">
                <div class="icon_c">
                    <img src="{{ asset('assets/enity.png') }}" alt="">
                </div>
                <div class="texto">
                    <h3>Organizações</h3>
                    <p>
                        Ajudamos empresas, escolas e instituições a melhorar clima, desempenho, saúde mental e
                        produtividade através de consultoria especializada.
                    </p>
                </div>
            </div>

        </div>
    </section>


    <section class="team-grid-section">
        <h2 class="team-main-title">Os nossos <em>especialistas</em></h2>

        <div class="team-grid">
            <!-- 1 -->
            <div class="team-card">
                <div class="team-img-wrapper">
                    <img src="{{ asset('assets/js.png') }}" alt="Joyceline Vatuva">
                </div>
                <div class="team-info">
                    <h3>Joyceline Vatuva</h3>
                    <p>Psicóloga Clínica</p>
                </div>
            </div>
            <!-- 2 -->
            <div class="team-card">
                <div class="team-img-wrapper">
                    <img src="{{ asset('assets/pl.jpg') }}" alt="Priscilla Lima">
                </div>
                <div class="team-info">
                    <h3>Priscilla Lima</h3>
                    <p>Clínica geral</p>
                </div>
            </div>
            <!-- 3 -->
            <div class="team-card">
                <div class="team-img-wrapper">
                    <img src="{{ asset('assets/sb.png') }}" alt="Isabel Fernandes">
                </div>
                <div class="team-info">
                    <h3>Isabel Fernandes</h3>
                    <p>Psicóloga Clínica</p>
                </div>
            </div>
            <!-- 4 -->
            <div class="team-card">
                <div class="team-img-wrapper">
                    <img src="{{ asset('assets/s.png') }}" alt="Ana Panzo">
                </div>
                <div class="team-info">
                    <h3>Ana Panzo</h3>
                    <p>Psicóloga Clínica</p>
                </div>
            </div>
            <!-- 5 -->
            <div class="team-card">
                <div class="team-img-wrapper">
                    <img src="{{ asset('assets/cl (1).png') }}" alt="Francisco Cassule">
                </div>
                <div class="team-info">
                    <h3>Francisco Cassule</h3>
                    <p>Psiquiatra</p>
                </div>
            </div>
            <!-- 6 -->
            <div class="team-card">
                <div class="team-img-wrapper">
                    <img src="{{ asset('assets/cl (2).png') }}" alt="Teresa Paquice">
                </div>
                <div class="team-info">
                    <h3>Teresa Paquice</h3>
                    <p>Psiquiatra</p>
                </div>
            </div>
        </div>

        <div class="team-action">
            <a href="#" class="btn-ghost-arrow">Saiba mais <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
    </section>

    <!-- O Nosso Diferencial -->
    <section class="diferencial-section">
        <div class="diferencial-container">
            <div class="diferencial-header">
                <h4>O NOSSO DIFERENCIAL</h4>
                <h2>O que nos torna <em>verdadeiramente diferentes</em></h2>
            </div>

            <div class="diferencial-list">
                <div class="diferencial-item">
                    <div class="diferencial-number">01</div>
                    <div class="diferencial-content">
                        <h3>Ecossistema completo e integrado</h3>
                        <p>Somos a única instituição em Angola que integra atendimento clínico, formação profissional e
                            consultoria organizacional numa plataforma coesa. O cliente não precisa de ir a lado nenhum:
                            encontra tudo aqui.</p>
                    </div>
                </div>
                <div class="diferencial-item">
                    <div class="diferencial-number">02</div>
                    <div class="diferencial-content">
                        <h3>Equipa multidisciplinar de referência</h3>
                        <p>Psicólogos clínicos, organizacionais, neuropsicólogos, terapeutas da fala e especialistas em
                            ABA todos com formação contínua, supervisão regular e compromisso ético comprovado.</p>
                    </div>
                </div>
                <div class="diferencial-item">
                    <div class="diferencial-number">03</div>
                    <div class="diferencial-content">
                        <h3>Planos acessíveis e contextualizados</h3>
                        <p>Desenvolvemos planos pensados para a realidade angolana: estrutura de preços justa, cobertura
                            abrangente e modalidades online e presenciais que se adaptam à vida dos nossos clientes.</p>
                    </div>
                </div>
                <div class="diferencial-item">
                    <div class="diferencial-number">04</div>
                    <div class="diferencial-content">
                        <h3>Impacto mensurável e transparente</h3>
                        <p>Não nos limitamos a promessas. Medimos resultados, partilhamos dados e ajustamos abordagens.
                            99% dos nossos clientes reportam melhoria significativa na qualidade de vida no primeiro
                            mês.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parceiros e Clientes -->
    <section class="parceiros-section">
        <div class="parceiros-header">
            <h4>PARCEIROS E CLIENTES</h4>
            <h2>Empresas que <em>confiam em nós</em></h2>
        </div>

        <div class="parceiros-grid">
            <div class="ticker-track">
                <!-- Original set -->
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (1).png') }}" alt="Anglobal">
                </div>
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (2).png') }}" alt="Luele">
                </div>
                <div class="parceiro-card logo-dark">
                    <img src="{{ asset('assets/parceiros (3).png') }}" alt="LIS">
                </div>
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (4).png') }}" alt="Aurora">
                </div>
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (1).jpg') }}" alt="Lulo">
                </div>
                <!-- Duplicate set for seamless loop -->
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (1).png') }}" alt="Anglobal">
                </div>
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (2).png') }}" alt="Luele">
                </div>
                <div class="parceiro-card logo-dark">
                    <img src="{{ asset('assets/parceiros (3).png') }}" alt="LIS">
                </div>
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (4).png') }}" alt="Aurora">
                </div>
                <div class="parceiro-card">
                    <img src="{{ asset('assets/parceiros (1).jpg') }}" alt="Lulo">
                </div>
            </div>
        </div>
    </section>
@endsection
