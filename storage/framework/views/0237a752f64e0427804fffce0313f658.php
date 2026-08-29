<?php $__env->startSection('content'); ?>
<!-- HERO SECTION ESTATICO -->
<section class="hero-static">
    <img src="<?php echo e(asset('assets/Consultoria2 - Cópia.jpg')); ?>" class="static-img" alt="Sobre">
    <div class="hero-overlay-layer"></div>

    <div class="hero-content-static">
        <div class="badge-tag">
            <span class="badge-dot" style="background: #eab308;"></span> Família & Crianças
        </div>
        <h1>PLANO<span> FAMILIAR & KANDENGUE</span></h1>
        <p>Cobertura integral para toda a família e acompanhamento especializado para crianças e adolescentes,
            promovendo harmonia e desenvolvimento saudável.</p>
    </div>
</section>

<div class="servicos-page-wrapper">
    <!-- Main Header -->
    <section class="servicos-header-section animate-on-scroll">
        <div class="badge fade-up-on-scroll">PLANOS FAMILIARES & KANDENGUE</div>
        <h1 class="fade-up-on-scroll delay-100">Saúde mental para <span>toda a família</span></h1>
        <p class="fade-up-on-scroll delay-200">Escolha o plano que melhor se adapta à sua família — incluindo opções
            especializadas para crianças e adolescentes.</p>
    </section>

    <!-- Tabs Navigation -->
    <div class="servicos-tabs animate-on-scroll">
        <button class="servicos-tab-btn active fade-up-on-scroll delay-300" onclick="openTab(event, 'basico')">
            <i class="fa-solid fa-house"></i> Básico
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-400" onclick="openTab(event, 'avancado')">
            <i class="fa-solid fa-house-chimney"></i> Avançado
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-500" onclick="openTab(event, 'premium')">
            <i class="fa-solid fa-crown"></i> Premium
        </button>
        <button class="servicos-tab-btn fade-up-on-scroll delay-600" onclick="openTab(event, 'kandengue')">
            <i class="fa-solid fa-children"></i> Kandengue
        </button>
    </div>

    <!-- Tab Content -->
    <div class="servicos-content-container animate-on-scroll">
        <!-- Básico -->
        <div id="basico" class="servicos-tab-pane active fade-up-on-scroll delay-700">
            <div class="servicos-content-img">
                <img src="<?php echo e(asset('assets/card/plano3.png')); ?>" alt="Plano Familiar Básico">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">01</div>
                <div class="servicos-subtitle">PLANO BÁSICO</div>
                <h2 class="servicos-title">85.000 Kz <span style="font-size: 1.2rem; color: #6c757d;">/ mês</span>
                </h2>
                <p class="servicos-desc">Cobertura essencial para famílias até 3 membros.<br><small
                        style="color:#61D0AD;">Nota: Pagamento mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 4 consultas por mês
                        (partilhadas)</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia familiar mensal</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Linha de apoio 24h</div>
                </div>

                <div class="servicos-actions">
                    <a href="<?php echo e(auth()->check() ? route('plano') : route('login')); ?>" class="btn-primary-sc">Aderir ao plano</a>
                </div>
            </div>
        </div>

        <!-- Avançado -->
        <div id="avancado" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="<?php echo e(asset('assets/card/plano3-1.png')); ?>" alt="Plano Familiar Avançado">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">02</div>
                <div class="servicos-subtitle">PLANO AVANÇADO</div>
                <h2 class="servicos-title">130.000 Kz <span style="font-size: 1.2rem; color: #6c757d;">/ mês</span>
                </h2>
                <p class="servicos-desc">Para famílias até 5 membros com acompanhamento completo.<br><small
                        style="color:#61D0AD;">Nota: Pagamento mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 8 consultas por mês
                        (partilhadas)</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> 2 terapias familiares por mês
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Check-up emocional trimestral
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Palestras exclusivas para pais
                    </div>
                </div>

                <div class="servicos-actions">
                    <a href="<?php echo e(auth()->check() ? route('plano') : route('login')); ?>" class="btn-primary-sc">Aderir ao plano</a>
                </div>
            </div>
        </div>

        <!-- Premium -->
        <div id="premium" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="<?php echo e(asset('assets/card/plano3-2.png')); ?>" alt="Plano Familiar Premium">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">03</div>
                <div class="servicos-subtitle">PLANO PREMIUM</div>
                <h2 class="servicos-title">200.000 Kz <span style="font-size: 1.2rem; color: #6c757d;">/ mês</span>
                </h2>
                <p class="servicos-desc">Cobertura total para famílias grandes com até 7 membros.<br><small
                        style="color:#61D0AD;">Nota: Pagamento mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Consultas ilimitadas (fair
                        use)</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia familiar semanal</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Apoio a cuidadores dedicado
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Workshops e palestras
                        gratuitos</div>
                </div>

                <div class="servicos-actions">
                    <a href="<?php echo e(auth()->check() ? route('plano') : route('login')); ?>" class="btn-primary-sc">Aderir ao plano</a>
                </div>
            </div>
        </div>

        <!-- Kandengue -->
        <div id="kandengue" class="servicos-tab-pane">
            <div class="servicos-content-img">
                <img src="<?php echo e(asset('assets/card/plano1.png')); ?>" alt="Plano Kandengue">
            </div>
            <div class="servicos-content-info">
                <div class="servicos-number-badge">04</div>
                <div class="servicos-subtitle">INFANTO-JUVENIL</div>
                <h2 class="servicos-title">Kandengue <span style="font-size: 1.2rem; color: #6c757d;">a partir de
                        45.000 Kz / mês</span></h2>
                <p class="servicos-desc">Cuidado especializado para crianças e adolescentes, com abordagens lúdicas
                    e suporte contínuo para pais e educadores.<br><small style="color:#61D0AD;">Nota: Pagamento
                        mínimo trimestral</small></p>

                <div class="servicos-list">
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Ludoterapia especializada
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Avaliação psicológica infantil
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Orientação parental</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Relatórios escolares</div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Terapia ABA (quando indicado)
                    </div>
                    <div class="servicos-list-item"><i class="fa-solid fa-check"></i> Prevenção precoce</div>
                </div>

                <div class="servicos-actions">
                    <a href="<?php echo e(auth()->check() ? route('plano') : route('login')); ?>" class="btn-primary-sc">Aderir ao plano</a>
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
            <h2>Porquê escolher o plano <b>Familiar & Kandengue</b>?</h2>
            <p>Benefícios exclusivos pensados para fortalecer os laços familiares e o desenvolvimento saudável dos
                mais novos.</p>
        </div>

        <div class="visao-geral-grid">
            <div class="vg-card fade-up-on-scroll delay-100">
                <div class="vg-icon"><i class="fa-solid fa-people-roof"></i></div>
                <h3>Toda a Família Coberta</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-200">
                <div class="vg-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <h3>Apoio a Cuidadores</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-300">
                <div class="vg-icon"><i class="fa-solid fa-user-doctor"></i></div>
                <h3>Especialistas Dedicados</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-400">
                <div class="vg-icon"><i class="fa-solid fa-comments"></i></div>
                <h3>Canais Exclusivos</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-500">
                <div class="vg-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <h3>Prioridade de Agenda</h3>
            </div>
            <div class="vg-card fade-up-on-scroll delay-600">
                <div class="vg-icon"><i class="fa-solid fa-money-bill-transfer"></i></div>
                <h3>Reembolso Estendido</h3>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-bottom-section animate-on-scroll fade-up-on-scroll delay-200">
        <div class="cta-container">
            <h2>Pronto para cuidar de toda a família?</h2>
            <p>Fale connosco e encontre o plano perfeito para a harmonia e bem-estar do seu lar.</p>
            <div class="cta-actions">
                <a href="<?php echo e(auth()->check() ? route('plano') : route('login')); ?>" class="btn-primary-sc">Aderir a um Plano</a>
                <a href="<?php echo e(url('/sobre')); ?>" class="btn-secondary-sc">Falar com a Equipa</a>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/planos/familiar.blade.php ENDPATH**/ ?>