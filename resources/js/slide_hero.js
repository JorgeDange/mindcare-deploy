// MindCare Slider customizado (Fade puro ao invés de Flowbite nativo)
const carouselItems = document.querySelectorAll('.mc-slide');
const indicators = document.querySelectorAll('[data-carousel-slide-to]');

// Se não tiver carousel, sai
if (carouselItems.length > 0) {
    let currentIndex = 0;
    const totalItems = carouselItems.length;
    let autoSlideInterval;

    const updateSlider = (newIndex) => {
        const prevIndex = currentIndex;

        carouselItems.forEach((item, index) => {
            item.classList.remove('active');
            item.classList.remove('last-active');

            if (index === newIndex) {
                item.classList.add('active');
            } else if (index === prevIndex) {
                item.classList.add('last-active');
            }
        });

        // Atualiza indicadores
        indicators.forEach((ind, index) => {
            ind.setAttribute('aria-current', index === newIndex ? 'true' : 'false');
        });

        currentIndex = newIndex;
    };

    // Auto Play
    const startAutoSlide = () => {
        autoSlideInterval = setInterval(() => {
            let nextIndex = (currentIndex + 1) % totalItems;
            updateSlider(nextIndex);
        }, 5000); // Muda a cada 5 segundos
    };

    // Reset Auto Play quando clicado
    const resetAutoSlide = () => {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    };

    // Evento de clique nos indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            updateSlider(index);
            resetAutoSlide();
        });
    });

    // Inicilizar primeiro slide
    updateSlider(0);
    startAutoSlide();
}
