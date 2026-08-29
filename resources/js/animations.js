
    // Configuração dos elementos que receberão animação
    const animateElements = [
        // Página: Sobre Nós
        { selector: '.desc_sobre', class: 'animate-on-scroll', stagger: true },
        { selector: '.valores-title', class: 'scale-on-scroll' },
        { selector: '.valor-card', class: 'animate-on-scroll', stagger: true },
        { selector: '.section-title, .section-title h2, .section-title span', class: 'scale-on-scroll' },
        { selector: '.plan-card', class: 'animate-on-scroll', stagger: true },
        { selector: '.quem-atendemos h2', class: 'fade-right-on-scroll' },
        { selector: '.quem-atendemos .item', class: 'animate-on-scroll', stagger: true },
        { selector: '.especialistas-section h2', class: 'scale-on-scroll' },
        { selector: '.card', class: 'animate-on-scroll', stagger: true }, // Cards dos especialistas
        { selector: '.clientes h2', class: 'scale-on-scroll' },
        { selector: '.circulos .circle', class: 'scale-on-scroll', stagger: true },
        
        // Página: Início (Index)
        { selector: '.content-desc', class: 'fade-right-on-scroll' },
        { selector: '.area-r h2', class: 'fade-right-on-scroll' },
        { selector: '.desc-rate', class: 'animate-on-scroll' },
        { selector: '.box-el', class: 'scale-on-scroll', stagger: true },
        { selector: '.step', class: 'fade-right-on-scroll', stagger: true },
        { selector: '.ilustre', class: 'fade-left-on-scroll' },
        { selector: '.stats-box', class: 'fade-right-on-scroll' },
        { selector: '.testimonial-card', class: 'fade-left-on-scroll' },
        { selector: '.imagens-mosaico', class: 'scale-on-scroll' },
        { selector: '.texto', class: 'animate-on-scroll' }
    ];

    animateElements.forEach(config => {
        const elements = document.querySelectorAll(config.selector);
        elements.forEach((el, index) => {
            el.classList.add(config.class);
            if (config.stagger) {
                // Adiciona delay escalonado para criar efeito em cascata (máximo de 6 itens para não demorar muito)
                const delay = ((index % 6) + 1) * 100;
                el.classList.add(`delay-${delay}`);
            }
        });
    });

    // Configuração do Intersection Observer
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -50px 0px', // Aciona um pouco antes de aparecer completamente
        threshold: 0.15 // Aciona quando 15% do elemento estiver visível
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // Mantém a animação acesa depois de visível (se quiser que refaça a animação ao subir/descer, comente a linha abaixo)
                // observer.unobserve(entry.target); 
            } else {
                 // Removendo a classe se o elemento sair da tela, permitindo que a animação ocorra de novo ao dar scroll
                 entry.target.classList.remove('is-visible');
            }
        });
    }, observerOptions);

    // Observa todos os elementos com as classes de animação
    const allAnimatedElements = document.querySelectorAll('.animate-on-scroll, .scale-on-scroll, .fade-right-on-scroll, .fade-left-on-scroll');
    allAnimatedElements.forEach(el => observer.observe(el));

