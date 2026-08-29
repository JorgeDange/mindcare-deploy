import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * MindCare — Entry Point JavaScript
 * Inicializa módulos conforme a página actual
 */

// Módulos comuns (carregam em todas as páginas)
import './init.js';
import './animations.js';
import './loading.js';

// Módulos condicionais
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.hero-new')) {
        import('./slide_hero.js');
    }

    if (document.querySelector('.slider-track')) {
        import('./slide.js');
    }

    if (document.getElementById('testimonialText')) {
        import('./func.js');
    }

    if (document.getElementById('support-btn')) {
        import('./chat.js');
    }

    if (document.querySelector('.portal-wrapper')) {
        import('./portal.js');
    }
});
