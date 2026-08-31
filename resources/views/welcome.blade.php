@extends('layouts.app')

@section('content')
<!-- HERO SECTION COM CARROUSSEL -->
<section class="hero-new" id="default-carousel">
    <div class="carousel-wrapper">
        <!-- SLIDE 1 -->
        <div class="mc-slide">
            <img src="{{ asset('assets/Consultoria2 - Cópia.jpg') }}" class="carousel-img" alt="Slide 1">
            <div class="hero-overlay-layer"></div>
            <div class="hero-content">
                <div class="badge-tag">
                    <span class="badge-dot"></span> Saúde mental acessível em Angola
                </div>
                <h1>Cuidar da mente é<br><span>cuidar da sua vida</span></h1>
                <p>Planos de saúde mental para si, para a sua família e para a sua empresa. Psicólogos
                    especializados, acompanhamento contínuo e atendimento sempre que mais precisar.</p>
                <div class="hero-buttons">
                    <a href="{{ url('/planos') }}" class="btn-solid-hero">Escolher o meu plano</a>
                    <a href="{{ url('/planos') }}" class="btn-ghost-hero">Conhecer os planos</a>
                </div>
                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div class="feature-text"><strong>Atendimento seguro</strong> Confidencialidade total</div>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-circle-check"></i>
                        <div class="feature-text"><strong>Adesão em minutos</strong> Rápido e sem burocracia</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SLIDE 2 -->
        <div class="mc-slide">
            <img src="{{ asset('assets/SECRETARIA 2.jpg') }}" class="carousel-img" alt="Slide 2">
            <div class="hero-overlay-layer"></div>
            <div class="hero-content">
                <div class="badge-tag">
                    <span class="badge-dot" style="background: #fbbf24;"></span> Atendimento Flexível
                </div>
                <h1>Psicologia Online<br><span>e Presencial</span></h1>
                <p>Atendimento humanizado, rigoroso e dedicado, onde e quando quiser, com profissionais altamente
                    qualificados das mais variadas áreas terapêuticas.</p>
                <div class="hero-buttons">
                    <a href="{{ url('/servicos') }}" class="btn-solid-hero">Marcar consulta</a>
                </div>
            </div>
        </div>
        <!-- SLIDE 3 -->
        <div class="mc-slide">
            <img src="{{ asset('assets/MIND_PCA VI.jpg') }}" class="carousel-img" alt="Slide 3">
            <div class="hero-overlay-layer"></div>
            <div class="hero-content">
                <div class="badge-tag">
                    <span class="badge-dot" style="background: #3b82f6;"></span> Serviços Organizacionais
                </div>
                <h1>Cuidado emocional<br><span>para a sua empresa</span></h1>
                <p>Programas avançados de avaliação, acompanhamento e saúde mental para as equipas e líderes da sua
                    organização. Equilíbrio traduz-se em motivação.</p>
                <div class="hero-buttons">
                    <a href="{{ url('/planos') }}" class="btn-solid-hero">Planos corporativos</a>
                    <a href="{{ url('/sobre') }}" class="btn-ghost-hero">Falar connosco</a>
                </div>
            </div>
        </div>
    </div>
    <div class="slider-dots" id="bt-r">
        <button type="button" class="indicator-pill" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
        <button type="button" class="indicator-pill" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
        <button type="button" class="indicator-pill" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
    </div>
</section>

<!-- PLANOS -->
<section class="plans-new-section">
    <div class="plans-header-new">
        <span class="plans-badge">PLANOS</span>
        <h2>O plano certo para <i>cada momento</i></h2>
        <p>Para si, para a sua família ou para a sua empresa temos opções que se encaixam nas suas necessidades e no seu orçamento.</p>
    </div>

    <div class="plans-groups-container">
        <div class="plans-group">
            <div class="group-line-deco"></div>
            <div class="group-label-text">Para si e para a sua família</div>
            <div class="plans-cards-row">
                <div class="plan-card-premium">
                    <h3><span>Plano</span> Particular</h3>
                    <a href="{{ route('planos.particular') }}" class="btn-join-new">Aderir agora</a>
                    <a href="{{ route('planos') }}" class="learn-more-link">saiba mais</a>
                </div>
                <div class="plan-card-premium">
                    <h3><span>Plano</span> Familia</h3>
                    <a href="{{ route('planos.familiar') }}" class="btn-join-new">Aderir agora</a>
                    <a href="{{ route('planos') }}" class="learn-more-link">saiba mais</a>
                </div>
            </div>
        </div>

        <div class="plans-group">
            <div class="group-line-deco"></div>
            <div class="group-label-text">Para a sua empresa</div>
            <div class="plans-cards-row">
                <div class="plan-card-premium">
                    <h3><span>Plano</span> Corporativo</h3>
                    <a href="{{ route('planos.corporativo') }}" class="btn-join-new">Aderir agora</a>
                    <a href="{{ route('planos') }}" class="learn-more-link">saiba mais</a>
                </div>
                <div class="plan-card-premium">
                    <h3><span>Plano</span> PME</h3>
                    <a href="{{ route('planos.corporativo') }}" class="btn-join-new">Aderir agora</a>
                    <a href="{{ route('planos') }}" class="learn-more-link">saiba mais</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVIÇOS -->
<section class="area-rate">
    <nav class="area-r">
        <nav class="desc-rate">
            <span class="plans-badge">SERVIÇOS</span>
        </nav>
        <nav class="box-rate">
            <div class="plans-container box-r">
                <div class="plan-card box-a" style="padding: 30px 20px; background: #EAF8F8; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="box-el" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
                        <div style="display: flex; justify-content: center; align-items: center; background: #224F52; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-user-doctor" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <p style="font-size: 1.1rem; line-height: 1.4; color: #224F52; font-weight: 700;">+10 profissionais<br>disponíveis</p>
                    </div>
                </div>
                <div class="plan-card box-a" style="padding: 30px 20px; background: #EAF8F8; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="box-el" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
                        <div style="display: flex; justify-content: center; align-items: center; background: #224F52; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-laptop-medical" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <p style="font-size: 1.1rem; line-height: 1.4; color: #224F52; font-weight: 700;">Atendimento online<br>e presencial</p>
                    </div>
                </div>
                <div class="plan-card box-a" style="padding: 30px 20px; background: #EAF8F8; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="box-el" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
                        <div style="display: flex; justify-content: center; align-items: center; background: #224F52; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-shield-halved" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <p style="font-size: 1.1rem; line-height: 1.4; color: #224F52; font-weight: 700;">Privacidade<br>garantida</p>
                    </div>
                </div>
                <div class="plan-card box-a" style="padding: 30px 20px; background: #fff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="box-el" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
                        <div style="display: flex; justify-content: center; align-items: center; background: #224F52; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-clock" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <p style="font-size: 1.1rem; line-height: 1.4; color: #224F52; font-weight: 700;">Adesão em menos<br>de 5 minutos</p>
                    </div>
                </div>
                <div class="plan-card box-a" style="padding: 30px 20px; background: #fff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="box-el" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
                        <div style="display: flex; justify-content: center; align-items: center; background: #224F52; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-briefcase" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <p style="font-size: 1.1rem; line-height: 1.4; color: #224F52; font-weight: 700;">Programas para<br>empresas</p>
                    </div>
                </div>
                <div class="plan-card box-a" style="padding: 30px 20px; background: #fff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div class="box-el" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 20px;">
                        <div style="display: flex; justify-content: center; align-items: center; background: #224F52; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-calendar-check" style="font-size: 24px; color: #fff;"></i>
                        </div>
                        <p style="font-size: 1.1rem; line-height: 1.4; color: #224F52; font-weight: 700;">Acompanhamento<br>contínuo</p>
                    </div>
                </div>
            </div>
        </nav>
    </nav>
</section>

<!-- COMO ADERIR -->
<section class="view-stap">
    <div class="desc-rate">
        <span class="plans-badge">COMO ADERIR</span>
        <h2>De zero ao cuidado <i>em 5 passos simples</i></h2>
        <p>Rápido, seguro e sem complicações. Em menos de 10 minutos já tem acesso ao seu plano.</p>
    </div>
    <div class="stepper">
        <div class="progress-container">
            <div class="step"><div class="circle active">1</div><div class="step-content"><div class="step-title">Identificação</div><div class="step-description">Crie a sua conta com os dados básicos</div></div></div>
            <div class="step"><div class="circle">2</div><div class="step-content"><div class="step-title">Escolha o plano</div><div class="step-description">Explore as opções ideais para si</div></div></div>
            <div class="step"><div class="circle">3</div><div class="step-content"><div class="step-title">Perfil de saúde</div><div class="step-description">Complete as informações e anexe documentos</div></div></div>
            <div class="step"><div class="circle">4</div><div class="step-content"><div class="step-title">Confirmação</div><div class="step-description">Verifique tudo antes de concluir a proposta</div></div></div>
            <div class="step"><div class="circle">5</div><div class="step-content"><div class="step-title">Finalização</div><div class="step-description">Pronto! Agora é só aguardar a análise</div></div></div>
        </div>
    </div>
</section>

<!-- RESULTADOS / TESTEMUNHOS -->
<section class="use-depoint dep">
    <nav class="use-d">
        <div class="container">
            <div class="stats-box">
                <span class="stats-badge">RESULTADOS REAIS</span>
                <div class="percentage">99%</div>
                <p class="stats-tagline">dos nossos clientes dizem que o MindCare melhorou a qualidade de vida no primeiro mês de uso.</p>
                <div class="stats-quote-block">
                    <p class="stats-description">Com alto grau de satisfação nos nossos planos, a nossa dedicação em oferecer atendimento de qualidade e soluções personalizadas faz toda a diferença. Junte-se a milhares de angolanos que já cuidam da mente.</p>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="card-header">
                    <button class="nav-button" id="prevBtn">‹</button>
                    <button class="nav-button" id="nextBtn">›</button>
                </div>
                <div class="card-content">
                    <div class="quote-icon">"</div>
                    <div class="testimonial-text" id="testimonialText">"Depois de participar no Tratamento de Liderança da MindCare, a minha abordagem ao trabalho com a equipa mudou radicalmente. Aprendi a usar acordos diferentes ideias... Passei dar a ajudar a redirecionar nas tarefas domésticas."</div>
                    <div class="author-name" id="authorName">Armando Pina</div>
                </div>
                <div class="card-footer" id="dotsContainer">
                    <div class="dot" data-index="0"></div>
                    <div class="dot" data-index="1"></div>
                    <div class="dot" data-index="2"></div>
                    <div class="dot active" data-index="3"></div>
                    <div class="dot" data-index="4"></div>
                </div>
            </div>
        </div>
    </nav>
</section>

<!-- CTA -->
<section class="cta-final">
    <div class="cta-content">
        <span class="cta-badge">COMECE HOJE</span>
        <h2 class="cta-title">Dê o primeiro passo. <br><i>A sua mente agradece.</i></h2>
        <p class="cta-subtitle">Junte-se a milhares de pessoas que já escolheram cuidar de si. <br>Sem compromisso, cancele quando quiser.</p>
        <div class="cta-buttons">
            <a href="{{ route('login') }}" class="btn-cta-primary">Aderir agora</a>
            <a href="https://wa.me/942698715" class="btn-cta-secondary" target="_blank">Falar com especialista</a>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="faq-p">
    <div class="faq-container">
        <h2 class="faq-title">FAQ</h2>
        <div class="faq-list">
            <div class="faq-item"><div class="faq-question"><span>1. O que é o MindCare?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>O MindCare é uma plataforma dedicada à saúde mental e bem-estar, oferecendo planos personalizados para particulares e empresas, com acesso a especialistas qualificados.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>2. Como funciona o processo de adesão?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>É simples: escolha o seu plano, preencha o formulário online e, em poucos minutos, já terá acesso aos nossos serviços e à nossa rede de profissionais.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>3. Posso cancelar o meu plano quando quiser?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Sim, não temos períodos de fidelização obrigatórios. Pode cancelar a sua subscrição a qualquer momento através da sua área de cliente, sem custos adicionais.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>4. As sessões são confidenciais?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Absolutamente. A privacidade e a ética são os pilares do nosso atendimento. Todas as sessões são protegidas por sigilo profissional rigoroso.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>5. Qual é a diferença entre os planos Company e PME?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>O plano Company é focado em grandes organizações com benefícios alargados, enquanto o PME é ideal para equipas mais pequenas que procuram flexibilidade e agilidade.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>6. O atendimento é presencial ou só online?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Oferecemos ambas as modalidades. Pode optar por consultas por vídeo no conforto da sua casa ou consultas presenciais nas nossas unidades parceiras.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>7. Como funciona a primeira consulta?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>A primeira consulta é um momento de acolhimento onde você poderá conhecer o profissional e expor suas necessidades. Realizamos uma avaliação inicial para compreender sua história e definir juntos o melhor plano terapêutico personalizado para você.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>8. Qual a duração de cada sessão?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Cada sessão tem duração de 50 minutos para atendimentos individuais. Para terapia de casal ou familiar, as sessões podem ter duração de 60 a 90 minutos, dependendo da abordagem e necessidade específica.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>9. Aceitam seguros de saúde?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Trabalhamos com diversos seguros e subsistemas de saúde. Entre em contato conosco para verificar se o seu plano está conveniado. Também fornecemos recibos para reembolso.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>10. Como agendar uma consulta?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>O agendamento pode ser feito por telefone, WhatsApp, ou através do nosso site. Nossa equipa está disponível para ajudá-lo a escolher o profissional mais adequado.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>11. Como funciona a supervisão para profissionais?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Nossa supervisão é conduzida por profissionais experientes que oferecem orientação técnica e ética. O objetivo é discutir casos complexos e promover seu desenvolvimento profissional.</p></div></div>
            <div class="faq-item"><div class="faq-question"><span>12. Oferecem programas de estágio?</span><i class="fa-solid fa-plus"></i></div><div class="faq-answer"><p>Sim, oferecemos estágios supervisionados nas áreas clínica, organizacional e criminal. Estagiários recebem orientação direta e participam de reuniões de equipa.</p></div></div>
        </div>
    </div>
</section>

<!-- CONTACTO -->
<section class="contact" id="contacto">
    <div class="contact-container">
        <div class="contact-info-side">
            <h2 class="contact-title">Fale <i>Connosco</i></h2>
            <p class="contact-desc">Pelo canal de atendimento ao cliente estamos disponíveis para atendê-lo(a) da melhor forma</p>
            <div class="contact-details">
                <h3 class="details-subtitle">Nossos Contactos:</h3>
                <div class="detail-item"><i class="fa-solid fa-phone"></i><span>+244 932 380 303</span></div>
                <div class="detail-item"><i class="fa-solid fa-envelope"></i><span>geral@mindcareangola.ao | mindcareangola@gmail.com</span></div>
            </div>
        </div>
        <div class="contact-form-side">
            <div class="glass-form">
                @if(session('success'))
                    <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">
                        @foreach($errors->all() as $error)
                            <p style="margin:2px 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('contacto.store') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="form-grid">
                        <input type="text" name="nome" placeholder="Nome" value="{{ old('nome') }}" required>
                        <input type="tel" name="telefone" placeholder="Digite o seu telefone" value="{{ old('telefone') }}" required>
                    </div>
                    <div class="form-grid">
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                        <input type="text" name="assunto" placeholder="Assunto (Opcional)" value="{{ old('assunto') }}">
                    </div>
                    <textarea name="mensagem" placeholder="Como podemos ajudar?" rows="4" required>{{ old('mensagem') }}</textarea>
                    <button type="submit" class="btn-submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
