/*
   MindCare portal shared interactions.
   Keep this file data-free: Blade/Eloquent owns portal content.
*/

function formatCurrentDate() {
  const el = document.getElementById('current-date');
  if (!el) return;

  el.textContent = new Date().toLocaleDateString('pt-AO', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
}

function initActiveBottomNav() {
  const currentPath = window.location.pathname;

  document.querySelectorAll('.bottom-nav__item').forEach((item) => {
    const href = item.getAttribute('href');
    if (!href) return;

    const itemUrl = new URL(href, window.location.origin);
    if (itemUrl.pathname === currentPath) {
      item.classList.add('active');
      item.setAttribute('aria-current', 'page');
    }
  });
}

function initSkeletons() {
  document.querySelectorAll('[data-skeleton]').forEach((target) => {
    target.style.visibility = 'hidden';

    const skeleton = document.createElement('div');
    skeleton.className = 'skeleton';
    skeleton.style.height = target.offsetHeight ? `${target.offsetHeight}px` : '60px';
    skeleton.style.width = '100%';
    skeleton.style.marginBottom = '12px';

    target.parentNode.insertBefore(skeleton, target);
    setTimeout(() => {
      skeleton.remove();
      target.style.visibility = 'visible';
    }, 600);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  formatCurrentDate();
  initActiveBottomNav();
  initSkeletons();

  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
});
