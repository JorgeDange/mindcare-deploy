if (window.lucide) lucide.createIcons();

/* menu bar */

let menu = document.getElementById('menu');



const menuToggle = document.getElementById('menuToggle');
const menuMobile = document.getElementById('menuMobile');
const overlay = document.getElementById('overlay');
const closeMenu = document.getElementById('closeMenu');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        menuMobile.classList.toggle('active');
        overlay.classList.toggle('active');
    });
}

if (overlay) {
    overlay.addEventListener('click', () => {
        menuMobile.classList.remove('active');
        overlay.classList.remove('active');
    });
}

if (closeMenu) {
    closeMenu.addEventListener('click', () => {
        menuMobile.classList.remove('active');
        overlay.classList.remove('active');
    });
}

/** faq */

const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');

    question.addEventListener('click', () => {
        const isActive = item.classList.contains('active');

        // Fecha todos os itens
        faqItems.forEach(i => {
            i.classList.remove('active');
        });

        // Abre o item clicado se não estava ativo
        if (!isActive) {
            item.classList.add('active');
        }
    });
});
