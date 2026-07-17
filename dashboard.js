// ===== DASHBOARD JS =====

document.addEventListener('DOMContentLoaded', function() {
  initSlider();
  animateStats();
});

function initSlider() {
  const track = document.getElementById('sliderTrack');
  const prev = document.getElementById('sliderPrev');
  const next = document.getElementById('sliderNext');
  const dotsContainer = document.getElementById('sliderDots');
  if (!track) return;

  const slides = track.querySelectorAll('.slider-slide');
  let current = 0;
  let autoplay;

  slides.forEach((_, i) => {
    const dot = document.createElement('button');
    dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
    dot.onclick = () => goTo(i);
    dotsContainer.appendChild(dot);
  });

  function updateDots() {
    dotsContainer.querySelectorAll('.slider-dot').forEach((d, i) => {
      d.classList.toggle('active', i === current);
    });
  }

  function goTo(index) {
    current = (index + slides.length) % slides.length;
    track.style.transform = `translateX(-${current * 100}%)`;
    updateDots();
    resetAutoplay();
  }

  function resetAutoplay() {
    clearInterval(autoplay);
    autoplay = setInterval(() => goTo(current + 1), 5000);
  }

  if (prev) prev.onclick = () => goTo(current - 1);
  if (next) next.onclick = () => goTo(current + 1);
  resetAutoplay();
}

function animateStats() {
  const values = document.querySelectorAll('.stat-value');
  values.forEach(el => {
    const target = parseInt(el.textContent);
    if (isNaN(target)) return;
    let start = 0;
    const step = Math.max(target / 20, 0.1);
    const timer = setInterval(() => {
      start += step;
      if (start >= target) { el.textContent = target; clearInterval(timer); }
      else { el.textContent = Math.floor(start); }
    }, 40);
  });
}

