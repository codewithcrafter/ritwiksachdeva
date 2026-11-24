/**
 * ANIMATIONS & SCROLL REVEAL ENGINE
 * Utilizes modern IntersectionObserver for high performance 60fps animations.
 * Features customizable animated number counters and respects reduced-motion.
 */

document.addEventListener('DOMContentLoaded', () => {
  initScrollReveals();
  initAnimatedCounters();
  initPracticeCardHighlights();
});

function initPracticeCardHighlights() {
  const cards = document.querySelectorAll('#services .arch-ledger-card');
  if (!cards.length) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    cards.forEach(card => card.classList.add('is-highlighted'));
    return;
  }

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const index = [...cards].indexOf(entry.target);
      window.setTimeout(() => entry.target.classList.add('is-highlighted'), index * 90);
      obs.unobserve(entry.target);
    });
  }, { threshold: .12, rootMargin: '0px 0px -45px' });

  cards.forEach(card => observer.observe(card));
}

/**
 * Initializes IntersectionObserver for elements with reveal classes
 */
function initScrollReveals() {
  // Check if user prefers reduced motion
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReducedMotion) {
    document.querySelectorAll('.reveal-on-scroll, .reveal-from-left, .reveal-from-right, .reveal-scale-up').forEach(el => {
      el.classList.add('is-visible');
    });
    return;
  }

  const revealElements = document.querySelectorAll('.reveal-on-scroll, .reveal-from-left, .reveal-from-right, .reveal-scale-up');
  if (!revealElements.length) return;

  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target); // Trigger only once for performance
      }
    });
  }, {
    root: null,
    threshold: 0.12,
    rootMargin: '0px 0px -40px 0px'
  });

  revealElements.forEach(el => revealObserver.observe(el));
}

/**
 * Animated Number Counters
 * Triggers counting animation when metrics enter viewport
 */
function initAnimatedCounters() {
  const counterElements = document.querySelectorAll('.counter-value');
  if (!counterElements.length) return;

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const animateCounter = (el) => {
    const target = parseFloat(el.getAttribute('data-target') || el.textContent);
    const duration = parseInt(el.getAttribute('data-duration') || '1800', 10);
    const prefix = el.getAttribute('data-prefix') || '';
    const suffix = el.getAttribute('data-suffix') || '';
    const decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);

    if (prefersReducedMotion || isNaN(target)) {
      el.textContent = `${prefix}${target.toFixed(decimals)}${suffix}`;
      return;
    }

    let startTime = null;

    const easeOutQuad = (t) => t * (2 - t);

    const step = (timestamp) => {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      const easedProgress = easeOutQuad(progress);
      const currentValue = easedProgress * target;

      el.textContent = `${prefix}${currentValue.toFixed(decimals)}${suffix}`;

      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        el.textContent = `${prefix}${target.toFixed(decimals)}${suffix}`;
      }
    };

    window.requestAnimationFrame(step);
  };

  const counterObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.25
  });

  counterElements.forEach(counter => counterObserver.observe(counter));
}


