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
  // 3D card tilt disabled across the site in favor of restrained CSS hover feedback
  initStatsCounters();
  // FAQs are initialized centrally in main.js to prevent duplicate click handlers.
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
 * 1. Custom Single Unified Cursor (Ring + Centered Dot)
 * Hides OS mouse and displays the custom circular cursor centered on pointer coordinates.
 */
function initCustomCursor() {
  if (window.matchMedia('(pointer: coarse)').matches) return;

  // Clean up any existing cursor instances
  const existingWrapper = document.getElementById('custom-cursor');
  if (existingWrapper) existingWrapper.remove();
  document.querySelectorAll('.custom-cursor-dot, .custom-cursor-ring').forEach(el => el.remove());

  const cursorWrapper = document.createElement('div');
  cursorWrapper.id = 'custom-cursor';
  cursorWrapper.className = 'custom-cursor';
  cursorWrapper.setAttribute('aria-hidden', 'true');

  const cursorRing = document.createElement('div');
  cursorRing.className = 'custom-cursor-ring';

  const cursorDot = document.createElement('div');
  cursorDot.className = 'custom-cursor-dot';

  cursorWrapper.appendChild(cursorRing);
  cursorWrapper.appendChild(cursorDot);
  document.body.appendChild(cursorWrapper);

  let mouseX = -100;
  let mouseY = -100;
  let isVisible = false;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;

    cursorWrapper.style.transform = `translate3d(${mouseX}px, ${mouseY}px, 0)`;

    if (!isVisible) {
      isVisible = true;
      cursorWrapper.style.opacity = '1';
    }
  }, { passive: true });

  document.addEventListener('mouseleave', () => {
    isVisible = false;
    cursorWrapper.style.opacity = '0';
  });

  document.addEventListener('mouseenter', () => {
    isVisible = true;
    cursorWrapper.style.opacity = '1';
  });

  window.addEventListener('mousedown', () => {
    cursorWrapper.classList.add('cursor-clicking');
  });

  window.addEventListener('mouseup', () => {
    cursorWrapper.classList.remove('cursor-clicking');
  });

  // Delegated hover detection for all interactive and card elements
  const hoverSelector = 'a, button, input, select, textarea, [role="button"], .card, .arch-ledger-card, .service-premium-card, .hp-service-slab, .faq-question, .hp-visual-composition-frame, .filter-pill, .share-btn, .tag-pill, .blog-card, .floating-btn, .nav-link, .brand-logo';

  document.addEventListener('mouseover', (e) => {
    if (e.target && e.target.closest && e.target.closest(hoverSelector)) {
      cursorWrapper.classList.add('cursor-active');
    }
  });

  document.addEventListener('mouseout', (e) => {
    if (e.target && e.target.closest && e.target.closest(hoverSelector)) {
      const related = e.relatedTarget;
      if (!related || !related.closest || !related.closest(hoverSelector)) {
        cursorWrapper.classList.remove('cursor-active');
      }
    }
  });
}

/**
 * 2. Magnetic Buttons with Spring Physics
 */
function initMagneticButtons() {
  if (window.matchMedia('(pointer: coarse)').matches) return;
  const magneticElements = document.querySelectorAll('.btn-primary, .hp-btn-primary, .rs-ecom-btn, .arch-cta-btn, .brand-monogram, .back-to-top-btn');

  magneticElements.forEach(el => {
    if (el.dataset.magneticBound) return;
    el.dataset.magneticBound = 'true';

    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      el.style.transform = `translate(${x * 0.25}px, ${y * 0.25}px)`;
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
 * 3. Card Hover (3D Perspective Card Tilt disabled)
 * Cards retain restrained, elegant CSS hover feedback (translateY, border-color, shadow).
 */

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


