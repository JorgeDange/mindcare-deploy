const track = document.querySelector('.slider-track');
let cards = document.querySelectorAll('.card');

let index = 0;
let startX = 0;
let currentX = 0;
let isDragging = false;
let cardWidth;
let visibleCards;
let autoplay;

/* ===== CONFIGURAÇÕES DE SUAVIDADE ===== */
const AUTOPLAY_TIME = 5000;        // autoplay mais lento
const DRAG_RESISTANCE = 0.35;      // resistência do arrasto (quanto menor, mais suave)

function getVisibleCards() {
  if (window.innerWidth <= 520) return 1;
  if (window.innerWidth <= 900) return 2;
  return 3;
}

function updateSizes() {
  cards = document.querySelectorAll('.card');
  cardWidth = cards[0].offsetWidth;
  visibleCards = getVisibleCards();
  move(false);
}

function move(animated = true) {
  track.style.transition = animated
    ? 'transform 1s cubic-bezier(0.15, 0.85, 0.25, 1)'
    : 'none';

  track.style.transform = `translateX(-${index * cardWidth}px)`;
}

/* ===== SETAS ===== */
function nextSlide() {
  if (index < cards.length - visibleCards) {
    index++;
    move();
  }
}

function prevSlide() {
  if (index > 0) {
    index--;
    move();
  }
}

/* ===== AUTOPLAY ===== */
function startAutoplay() {
  autoplay = setInterval(nextSlide, AUTOPLAY_TIME);
}

function stopAutoplay() {
  clearInterval(autoplay);
}

startAutoplay();

/* ===== TOUCH (MOBILE) ===== */
track.addEventListener('touchstart', e => {
  startX = e.touches[0].clientX;
  isDragging = true;
  stopAutoplay();
  track.style.transition = 'none';
});

track.addEventListener('touchmove', e => {
  if (!isDragging) return;
  currentX = e.touches[0].clientX;

  const diff = (currentX - startX) * DRAG_RESISTANCE;

  track.style.transform = `translateX(${-(index * cardWidth) + diff}px)`;
});

track.addEventListener('touchend', () => {
  isDragging = false;
  const diff = startX - currentX;

  if (diff > cardWidth / 2) nextSlide();
  else if (diff < -cardWidth / 2) prevSlide();
  else move();

  startAutoplay();
});

/* ===== MOUSE DRAG (DESKTOP) ===== */
track.addEventListener('mousedown', e => {
  startX = e.clientX;
  isDragging = true;
  stopAutoplay();
  track.style.transition = 'none';
});

window.addEventListener('mousemove', e => {
  if (!isDragging) return;
  currentX = e.clientX;

  const diff = (currentX - startX) * DRAG_RESISTANCE;

  track.style.transform = `translateX(${-(index * cardWidth) + diff}px)`;
});

window.addEventListener('mouseup', () => {
  if (!isDragging) return;
  isDragging = false;

  const diff = startX - currentX;

  if (diff > cardWidth / 2) nextSlide();
  else if (diff < -cardWidth / 2) prevSlide();
  else move();

  startAutoplay();
});

/* ===== RESIZE ===== */
window.addEventListener('resize', updateSizes);

updateSizes();
