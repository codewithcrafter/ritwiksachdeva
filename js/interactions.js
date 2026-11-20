/**
 * CREATIVE GROWTH LAB — ADVANCED INTERACTION ENGINE
 * - Custom trailing cursor with magnetic reaction and expansion
 * - Physics-based magnetic buttons
 * - 3D Perspective Card Tilt on mouse movement
 * - Interactive mouse-responsive coordinates
 * - Animated statistics count-up
 * - FAQ accordion
 * - Scroll progress indicator
 * - Contact form prefill & validation
 */

document.addEventListener('DOMContentLoaded', () => {
  initCustomCursor();
  initMagneticButtons();
  init3DCardTilt();
  initStatsCounters();
  initFaqAccordion();
  initScrollProgress();
  initContactForm();
  prefillServiceFromUrl();
});

function prefillServiceFromUrl() {
  const urlParams = new URLSearchParams(window.location.search);
  const serviceParam = urlParams.get('service');
  const serviceSelect = document.getElementById('client-service');

  if (serviceParam && serviceSelect) {
    for (let i = 0; i < serviceSelect.options.length; i++) {
      if (serviceSelect.options[i].value === serviceParam) {
        serviceSelect.selectedIndex = i;
        break;
      }
    }
  }
}

/**
 * 1. Custom Trailing Animated Cursor
 */
function initCustomCursor() {
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const cursorDot = document.createElement('div');
  const cursorRing = document.createElement('div');

  cursorDot.className = 'custom-cursor-dot';
  cursorRing.className = 'custom-cursor-ring';

  document.body.appendChild(cursorDot);
  document.body.appendChild(cursorRing);

  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;
  let ringX = mouseX;
  let ringY = mouseY;
  let isMoving = false;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;

    cursorDot.style.opacity = '1';
    cursorRing.style.opacity = '1';
    cursorDot.style.left = `${mouseX}px`;
    cursorDot.style.top = `${mouseY}px`;

    if (!isMoving) {
      isMoving = true;
      requestAnimationFrame(renderCursor);
    }
  });

  function renderCursor() {
    ringX += (mouseX - ringX) * 0.18;
    ringY += (mouseY - ringY) * 0.18;

    cursorRing.style.left = `${ringX}px`;
    cursorRing.style.top = `${ringY}px`;

    if (Math.abs(mouseX - ringX) > 0.1 || Math.abs(mouseY - ringY) > 0.1) {
      requestAnimationFrame(renderCursor);
    } else {
      isMoving = false;
    }
  }

  // Interactive Hover Targets
  const hoverables = document.querySelectorAll('a, button, input, select, textarea, .card, .arch-ledger-card, .service-premium-card, .hp-service-slab, .faq-question, .hp-visual-composition-frame');
  hoverables.forEach(el => {
    el.addEventListener('mouseenter', () => cursorRing.classList.add('cursor-active'));
    el.addEventListener('mouseleave', () => cursorRing.classList.remove('cursor-active'));
  });
}

/**
 * 2. Magnetic Buttons with Spring Physics
 */
function initMagneticButtons() {
  const magneticElements = document.querySelectorAll('.btn-primary, .hp-btn-primary, .rs-ecom-btn, .arch-cta-btn, .brand-monogram, .back-to-top-btn');

  magneticElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      el.style.transform = `translate(${x * 0.28}px, ${y * 0.28}px)`;
    });

    el.addEventListener('mouseleave', () => {
      el.style.transform = 'translate(0px, 0px)';
      el.style.transition = 'transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
    });

    el.addEventListener('mouseenter', () => {
      el.style.transition = 'none';
    });
  });
}

/**
 * 3. 3D Perspective Card Tilt
 */
function init3DCardTilt() {
  const cards = document.querySelectorAll('.card, .arch-ledger-card, .arch-kpi-card, .service-premium-card, .hp-stat-ledger-item, .metric-strip-item, .hp-visual-composition-frame');

  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -6;
      const rotateY = ((x - centerX) / centerX) * 6;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translate(-2px, -2px)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translate(0px, 0px)';
      card.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1)';
    });

    card.addEventListener('mouseenter', () => {
      card.style.transition = 'none';
    });
  });
}

/**
 * 4. Animated Statistics Counters
 */
function initStatsCounters() {
  const statNumbers = document.querySelectorAll('.hp-stat-number, .metric-strip-val');
  if (!statNumbers.length) return;

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateValue(entry.target);
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  statNumbers.forEach(stat => observer.observe(stat));

  function animateValue(obj) {
    const text = obj.textContent.trim();
    const hasPlus = text.includes('+');
    const hasDecimal = text.includes('.');
    const cleanNum = parseFloat(text.replace(/[^0-9.]/g, ''));

    if (isNaN(cleanNum)) return;

    let start = 0;
    const duration = 1500;
    const startTime = performance.now();

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      const current = start + (cleanNum - start) * ease;

      if (hasDecimal) {
        obj.textContent = current.toFixed(1) + (hasPlus ? '+' : '');
      } else {
        obj.textContent = Math.floor(current) + (hasPlus ? '+' : '');
      }

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        obj.textContent = text;
      }
    }

    requestAnimationFrame(update);
  }
}

/**
 * 5. FAQ Accordion Interaction
 */
function initFaqAccordion() {
  const faqItems = document.querySelectorAll('.faq-item, .arch-faq-item, .rs-faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question, .arch-faq-question, .rs-faq-question');
    if (!questionBtn) return;

    questionBtn.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      faqItems.forEach(other => {
        if (other !== item) other.classList.remove('active');
      });

      item.classList.toggle('active', !isActive);
    });
  });
}

/**
 * 6. High-Voltage Scroll Progress Indicator
 */
function initScrollProgress() {
  let progressBar = document.getElementById('scroll-progress');
  if (!progressBar) {
    progressBar = document.createElement('div');
    progressBar.id = 'scroll-progress';
    document.body.appendChild(progressBar);
  }

  window.addEventListener('scroll', () => {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    progressBar.style.width = scrolled + '%';
  }, { passive: true });
}

/**
 * 7. Contact Form Validation & State
 */
function initContactForm() {
  const form = document.getElementById('consultation-form') || document.querySelector('.contact-form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        isValid = false;
        field.style.borderColor = 'var(--coral)';
      } else {
        field.style.borderColor = 'var(--border-strong)';
      }
    });

    if (!isValid) {
      e.preventDefault();
      alert('Please complete all required fields to submit your inquiry.');
    }
  });
}
