/**
 * PREMIUM DIGITAL MARKETING CONSULTANT PORTFOLIO - MAIN SCRIPT
 * Handles header transitions, mobile navigation drawer, scroll progress bar, active link state,
 * consultation popup with session management, and floating contact actions (WhatsApp & Call).
 */

/**
 * ==========================================================================
 * GLOBAL CONTACT CONFIGURATION
 * Reuses existing project contact details from contact.html (+91 98765 43210).
 * Update these values to change phone/WhatsApp contact across all pages.
 * ==========================================================================
 */
const SITE_CONTACT_CONFIG = {
  // Configured WhatsApp number (country code + number, no '+' or spaces)
  whatsappNumber: '919289626986',
  // Configured telephone number for direct tel: links
  phoneNumber: '+919289626986',
  // Formatted telephone number for user-facing labels and tooltips
  displayPhone: '+91 92896 26986',
  email: 'Info@ritwiksachdeva.in',
  // Default WhatsApp greeting message
  defaultWhatsAppMessage: 'Hello Ritwik, I would like to inquire about a digital marketing consultation.'
};

function initAllAppFeatures() {
  initSharedHostingNavigation();
  initCustomCursor();
  document.querySelectorAll('.mobile-drawer:not(#mobile-drawer)').forEach((drawer) => drawer.remove());
  document.querySelectorAll('body > a.mobile-link, body > .mobile-actions').forEach((node) => node.remove());
  applySharedContactDetails();
  initNavbar();
  initHeaderTopBar();
  initMobileDrawer();
  initDropdownNav();
  initScrollProgress();
  initBackToTop();
  updateCurrentYear();
  highlightActiveNav();
  initFaqAccordion();
  initInquiryDispatchModal();
  initCopyContactButtons();
  initConsultationPopup();
  initServiceHeroLeadForm();
  initServiceCardDetails();
  initArticleTagsPosition();
  initArticleHeroConsultation();
  initArticleConsultationPlacement();
  initFloatingContactActions();
  normalizeFloatingWhatsAppIcons();
  initStaggeredScrollReveals();
  initHomeServiceEffects();
}

/* The experimental blue cursor created duplicate listeners and flicker on
   pages with repeated shared scripts. Preserve the reliable native cursor. */
function initCustomCursor() {
  document.documentElement.classList.remove('has-custom-cursor');
  document.body?.classList.remove('cursor-active');
  document.getElementById('custom-cursor')?.remove();
}

/*
 * Shared hosting fallback: some hosts route unknown clean URLs (for example
 * /about/) back to the homepage. Menu clicks therefore use the matching
 * physical page beside this site's current directory instead of assuming the
 * domain root or a working rewrite module.
 */
function initSharedHostingNavigation() {
  const routes = {
    '/': 'index.html',
    '/about/': 'about.html',
    '/services/': 'services.html',
    '/contact/': 'contact.html',
    '/blog/': 'blog.html',
    '/services/ecommerce-management/': 'service-ecommerce-management.html',
    '/services/graphic-designer/': 'service-graphic-designer.html',
    '/services/performance-marketing/': 'service-performance-marketing.html',
    '/services/ppc-expert/': 'service-ppc-expert.html',
    '/services/product-shoot/': 'service-product-shoot.html',
    '/services/seo-expert/': 'service-seo-expert.html',
    '/services/smo-services/': 'service-smo-services.html',
    '/services/social-media-marketing/': 'service-social-media-marketing.html',
    '/services/video-editing/': 'service-video-editing.html',
    '/services/website-designer/': 'service-website-designer.html',
    '/blog/business-growth-strategy/': 'blog-business-growth-strategy.html',
    '/blog/ai-in-business/': 'blog-ai-in-business.html',
    '/blog/digital-transformation-strategies/': 'blog-digital-transformation-strategies.html',
    '/blog/leadership-skills/': 'blog-leadership-skills.html',
    '/blog/marketing-strategies/': 'blog-marketing-strategies.html'
  };
  document.querySelectorAll('.nav-link, .mobile-link, .nav-dropdown-item, .mobile-sublink, .dropdown-view-all, .nav-actions a').forEach(link => {
    const destination = new URL(link.href, window.location.origin);
    const route = destination.pathname.replace(/\/?$/, '/') || '/';
    const file = routes[route];
    if (file) {
      link.setAttribute('href', '/' + file + destination.search + destination.hash);
    }
  });
}

function initArticleConsultationPlacement() {
  // The article sidebar is reserved for the table of contents. Consultation
  // requests open the shared modal, so no inline form/card is moved into it.
  document.querySelectorAll('.toc-sidebar > div').forEach((item) => {
    if (/Need Custom Implementation/i.test(item.textContent)) item.hidden = true;
  });
}

/* Place one normal inquiry form in the article hero. It is deliberately not
   part of the sticky TOC and does not affect the separate timed popup. */
function initArticleHeroConsultation() {
  const articleHeader = document.querySelector('.article-header');
  const heroContainer = articleHeader?.querySelector(':scope > .article-container');
  if (!heroContainer || heroContainer.querySelector('.blog-hero-form')) return;

  const copy = document.createElement('div');
  copy.className = 'article-hero-copy';
  while (heroContainer.firstChild) copy.appendChild(heroContainer.firstChild);

  const formCard = document.createElement('aside');
  formCard.className = 'blog-hero-form';
  formCard.setAttribute('aria-label', 'Consultation inquiry form');
  formCard.innerHTML = `
    <span class="blog-hero-form-badge">Free Growth Consultation</span>
    <h2>Build your next growth move.</h2>
    <p>Tell us where you want stronger, more predictable results.</p>
    <form action="/consult-submit.php" method="POST">
      <input type="text" name="website_url" class="blog-hero-form-honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">
      <div class="blog-hero-form-row">
      <label>Full Name<input type="text" name="name" autocomplete="name" placeholder="Alex" required></label>
        <label>Email Address<input type="email" name="email" autocomplete="email" placeholder="alex@company.com" required></label>
      </div>
      <label>Contact Number / Mobile<input type="tel" name="phone" autocomplete="tel" placeholder="00000-00000" required></label>
      <label>Message (Optional)<textarea name="message" rows="3" placeholder="Tell us about your goals, challenges, or timeline..."></textarea></label>
      <button type="submit">Submit Inquiry <span aria-hidden="true">→</span></button>
    </form>
    <small>Strictly confidential. Our advisory team responds within 24 business hours.</small>`;

  heroContainer.append(copy, formCard);
}

function initServiceCardDetails() {
  document.querySelectorAll('.services-catalog-wrap .service-premium-card').forEach((card) => {
    if (card.querySelector('.service-card-details')) return;
    const breakdown = card.querySelector('.service-breakdown-grid');
    const tools = card.querySelector('.service-tools-row');
    const footer = card.querySelector('.service-card-bottom');
    if (!breakdown || !footer) return;
    const details = document.createElement('details');
    details.className = 'service-card-details';
    const summary = document.createElement('summary');
    summary.textContent = 'View Details & Deliverables (6) +';
    details.append(summary, breakdown);
    if (tools) details.append(tools);
    footer.parentNode.insertBefore(details, footer);
  });
}

/* Keep article topics close to the editorial heading instead of after the body. */
function initArticleTagsPosition() {
  document.querySelectorAll('.article-tags-wrap').forEach((tags) => {
    const column = tags.closest('.article-layout-grid')?.querySelector('.article-prose-column');
    const prose = column?.querySelector('.article-prose');
    if (column && prose && !column.contains(tags)) column.insertBefore(tags, prose);
  });
}

function applySharedContactDetails() {
  document.querySelectorAll('a[href^="mailto:"]').forEach((link) => {
    link.href = `mailto:${SITE_CONTACT_CONFIG.email}`;
    const span = link.querySelector('span');
    if (span) {
      if (span.textContent.trim().includes('@')) span.textContent = SITE_CONTACT_CONFIG.email;
    } else {
      let replaced = false;
      link.childNodes.forEach((node) => {
        if (!replaced && node.nodeType === Node.TEXT_NODE && node.textContent.includes('@')) {
          node.textContent = ` ${SITE_CONTACT_CONFIG.email}`;
          replaced = true;
        }
      });
    }
  });
  document.querySelectorAll('a[href^="tel:"]').forEach((link) => {
    link.href = `tel:${SITE_CONTACT_CONFIG.phoneNumber}`;
    const span = link.querySelector('span');
    if (span) {
      if (/\d/.test(span.textContent)) span.textContent = SITE_CONTACT_CONFIG.displayPhone;
    } else {
      let replaced = false;
      link.childNodes.forEach((node) => {
        if (!replaced && node.nodeType === Node.TEXT_NODE && /\d/.test(node.textContent)) {
          node.textContent = ` ${SITE_CONTACT_CONFIG.displayPhone}`;
          replaced = true;
        }
      });
    }
  });
  document.querySelectorAll('a[href*="wa.me/"]').forEach((link) => {
    link.href = `https://wa.me/${SITE_CONTACT_CONFIG.whatsappNumber}`;
  });
  document.querySelectorAll('[data-copy-value]').forEach((control) => {
    const current = control.getAttribute('data-copy-value') || '';
    if (current.includes('@')) control.setAttribute('data-copy-value', SITE_CONTACT_CONFIG.email);
    if (/\d/.test(current)) control.setAttribute('data-copy-value', SITE_CONTACT_CONFIG.displayPhone);
  });
  const socialLinks = {
    LinkedIn: 'https://www.linkedin.com/in/ritwik-sachdeva-3595081ba/',
    Instagram: 'https://www.instagram.com/ritwik_sachdeva_official/',
    Facebook: 'https://www.facebook.com/profile.php?id=61571461323750'
  };
  document.querySelectorAll('.footer-social-links a, .social-link').forEach((link) => {
    const label = link.getAttribute('aria-label') || '';
    Object.entries(socialLinks).forEach(([name, url]) => { if (label.includes(name)) link.href = url; });
  });
  document.querySelectorAll('a[aria-label*="Twitter"], a[aria-label*="Substack"]').forEach((link) => {
    const isFacebook = (link.getAttribute('aria-label') || '').includes('Twitter');
    link.href = isFacebook ? socialLinks.Facebook : socialLinks.Instagram;
    link.setAttribute('aria-label', isFacebook ? 'Facebook Profile' : 'Instagram Profile');
    link.innerHTML = isFacebook
      ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 22v-8h2.75l.41-3.2H13.5V8.76c0-.93.26-1.56 1.59-1.56h1.7V4.34c-.29-.04-1.28-.13-2.43-.13-2.41 0-4.06 1.47-4.06 4.18v2.33H7.57V14h2.73v8h3.2Z"/></svg>'
      : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor"/></svg>';
  });
}

function initHomeServiceEffects() {
  const section = document.getElementById('services');
  if (!section) return;
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const cards = [...section.querySelectorAll('.arch-ledger-card')];
  cards.forEach((card, index) => { card.classList.add('conic-border-trace', 'sliding-drawer-curtain'); card.style.setProperty('--drawer-delay', `${index * 80}ms`); });
  if (reduceMotion) { cards.forEach((card) => card.classList.add('is-drawer-open')); return; }
  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => { if (!entry.isIntersecting) return; entry.target.classList.add('is-drawer-open'); obs.unobserve(entry.target); });
  }, { threshold: .14 });
  cards.forEach((card) => observer.observe(card));
}

function initServiceHeroLeadForm() {
  const pageName = (window.location.pathname.split('/').pop() || '').toLowerCase();
  const isCleanServiceRoute = /^\/services\/[a-z0-9-]+\/?$/i.test(window.location.pathname);
  if (!pageName.startsWith('service-') && !isCleanServiceRoute) return;
  const hero = document.querySelector('.service-detail-header-wrap');
  const legacyHero = document.querySelector('.marketing-hero-wrap');
  if ((!hero && !legacyHero) || document.querySelector('.service-hero-inquiry')) return;

  const panel = document.createElement('aside');
  panel.className = 'service-hero-inquiry';
  panel.innerHTML = `
    <div class="service-form-status"><span></span> Available for a consultation</div>
    <h2>Start a Conversation</h2>
    <p>Tell us what you are working on. Ritwik's team will reply within 24 business hours.</p>
    <form class="service-inquiry-form" novalidate>
      <label>Your Name <input name="name" required autocomplete="name" placeholder="e.g. Alex Morgan"></label>
      <label>Work Email <input name="email" type="email" required autocomplete="email" placeholder="e.g. alex@company.com"></label>
      <label>Phone <input name="phone" type="tel" autocomplete="tel" placeholder="+91 92896 26986"></label>
      <label>Primary Focus <select name="focus"><option>Growth Strategy</option><option>Performance Marketing</option><option>SEO & Content</option><option>Website & E-Commerce</option></select></label>
      <label>Brief <textarea name="message" rows="3" placeholder="What would you like help with?"></textarea></label>
      <button type="submit">Request Consultation <span aria-hidden="true">&rarr;</span></button>
      <p class="service-form-note">Your information stays confidential.</p>
      <p class="service-form-feedback" role="status" aria-live="polite"></p>
    </form>`;
  if (hero) {
    const copy = document.createElement('div');
    copy.className = 'service-hero-copy';
    while (hero.firstChild) copy.appendChild(hero.firstChild);
    hero.append(copy, panel);
  } else {
    const imageColumn = legacyHero.querySelector('.marketing-image-col');
    if (imageColumn) imageColumn.appendChild(panel);
    else legacyHero.appendChild(panel);
  }

  const form = panel.querySelector('.service-inquiry-form');
  const feedback = panel.querySelector('.service-form-feedback');
  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (!form.reportValidity()) return;
    const button = form.querySelector('button');
    button.disabled = true; button.textContent = 'Sending...';
    try {
      const response = await fetch('api/contact.php', { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ ...Object.fromEntries(new FormData(form)), source: 'Service Hero Inquiry' }) });
      if (!response.ok) throw new Error('Request failed');
      form.reset(); feedback.textContent = 'Thank you — your consultation request has been sent.';
    } catch (error) {
      feedback.innerHTML = `Unable to send this right now. Please <a href="https://wa.me/${SITE_CONTACT_CONFIG.whatsappNumber}" target="_blank" rel="noopener">message Ritwik on WhatsApp</a>.`;
    } finally {
      button.disabled = false; button.innerHTML = 'Request Consultation <span aria-hidden="true">&rarr;</span>';
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initAllAppFeatures);
} else {
  initAllAppFeatures();
}

/**
 * Navbar scroll behavior: Adds backdrop blur and solid background when scrolled
 */
function initNavbar() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  const handleScroll = () => {
    if (window.scrollY > 40) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll(); // Initial check
}

/**
 * Mobile Navigation Drawer Toggle
 */
function initMobileDrawer() {
  const toggleBtn = document.querySelector('.mobile-nav-toggle');
  const drawer = document.querySelector('.mobile-drawer');
  const mobileLinks = document.querySelectorAll('.mobile-link, .mobile-drawer .btn');

  if (!toggleBtn || !drawer) return;

  const openDrawer = () => {
    toggleBtn.classList.add('is-active');
    drawer.classList.add('is-open');
    drawerBackdrop.classList.add('is-open');
    toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  };

  const closeDrawer = () => {
    toggleBtn.classList.remove('is-active');
    drawer.classList.remove('is-open');
    drawerBackdrop.classList.remove('is-open');
    toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  };

  let drawerBackdrop = document.getElementById('mobile-drawer-backdrop');
  if (!drawerBackdrop) {
    drawerBackdrop = document.createElement('button');
    drawerBackdrop.type = 'button';
    drawerBackdrop.id = 'mobile-drawer-backdrop';
    drawerBackdrop.className = 'mobile-drawer-backdrop';
    drawerBackdrop.setAttribute('aria-label', 'Close navigation menu');
    document.body.appendChild(drawerBackdrop);
  }
  drawerBackdrop.addEventListener('click', closeDrawer);

  // A visible close control inside the compact drawer is clearer than asking
  // mobile visitors to find the hamburger again behind the panel.
  let drawerClose = drawer.querySelector('.mobile-drawer-close');
  if (!drawerClose) {
    drawerClose = document.createElement('button');
    drawerClose.type = 'button';
    drawerClose.className = 'mobile-drawer-close';
    drawerClose.setAttribute('aria-label', 'Close navigation menu');
    drawerClose.innerHTML = `
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
        <path d="M6 6l12 12M18 6L6 18"></path>
      </svg>`;
    drawer.prepend(drawerClose);
  }
  drawerClose.addEventListener('click', closeDrawer);

  if (!drawer.querySelector('.mobile-drawer-brand')) {
    const headerBrand = document.querySelector('.site-header .brand-logo');
    if (headerBrand) {
      const drawerBrand = headerBrand.cloneNode(true);
      drawerBrand.classList.add('mobile-drawer-brand');
      drawerBrand.setAttribute('aria-label', 'Ritwik Sachdeva home');
      drawerClose.insertAdjacentElement('afterend', drawerBrand);
    }
  }

  toggleBtn.addEventListener('click', () => {
    const isOpen = drawer.classList.contains('is-open');
    if (isOpen) {
      closeDrawer();
    } else {
      openDrawer();
    }
  });

  // Close when clicking any link inside drawer (except submenu toggle)
  mobileLinks.forEach(link => {
    link.addEventListener('click', closeDrawer);
  });

  // Mobile submenu expander
  const submenuToggles = drawer.querySelectorAll('.mobile-submenu-btn');
  submenuToggles.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const parent = btn.closest('.mobile-nav-item-dropdown');
      const submenu = parent ? parent.querySelector('.mobile-submenu') : null;
      if (!submenu) return;
      const isExpanded = btn.classList.contains('is-expanded');
      if (isExpanded) {
        btn.classList.remove('is-expanded');
        btn.setAttribute('aria-expanded', 'false');
        submenu.classList.remove('is-open');
      } else {
        btn.classList.add('is-expanded');
        btn.setAttribute('aria-expanded', 'true');
        submenu.classList.add('is-open');
      }
    });
  });

  // Close with Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
      closeDrawer();
    }
  });
}

/**
 * Desktop Nav Dropdown Accessibility and Click Toggle
 */
function initDropdownNav() {
  const dropdownItems = document.querySelectorAll('.nav-item-has-dropdown');
  dropdownItems.forEach(item => {
    const toggle = item.querySelector('.dropdown-toggle');
    if (!toggle) return;

    // Toggle on click for touch screens or explicit click
    toggle.addEventListener('click', (e) => {
      // If user clicks the arrow or on mobile/tablet touch, prevent instant navigate if not open
      if (window.innerWidth <= 991) {
        // Let mobile drawer handle it
        return;
      }
      // On desktop, if double-clicked or clicked directly, navigate, but allow click toggle if desired
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!item.contains(e.target)) {
        item.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });

    // Escape closes dropdown
    item.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        item.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  });
}

/**
 * Scroll Progress Bar Indicator
 */
function initScrollProgress() {
  const progressBar = document.getElementById('scroll-progress');
  if (!progressBar) return;

  const updateProgress = () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    if (docHeight <= 0) return;
    const scrollPercentage = (scrollTop / docHeight) * 100;
    progressBar.style.width = `${Math.min(100, Math.max(0, scrollPercentage))}%`;
  };

  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();
}

/**
 * Back to Top Smooth Scroll with Circular SVG Progress Ring
 */
function initBackToTop() {
  const backToTopBtn = document.getElementById('back-to-top');
  if (!backToTopBtn) return;

  // Inject SVG progress ring if not present in HTML
  let ringFill = backToTopBtn.querySelector('.ring-fill');
  if (!ringFill) {
    const ringWrap = document.createElement('span');
    ringWrap.innerHTML = `
      <svg class="back-to-top-ring" viewBox="0 0 36 36" aria-hidden="true">
        <circle class="ring-bg" cx="18" cy="18" r="15"></circle>
        <circle class="ring-fill" cx="18" cy="18" r="15"></circle>
      </svg>
    `;
    backToTopBtn.appendChild(ringWrap.firstElementChild);
    ringFill = backToTopBtn.querySelector('.ring-fill');
  }

  const updateRingProgress = () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    if (docHeight <= 0) return;
    const progress = Math.min(1, Math.max(0, scrollTop / docHeight));
    // 2 * PI * 15 —^ 94.25
    const offset = 94.25 - (progress * 94.25);
    if (ringFill) {
      ringFill.style.strokeDashoffset = `${offset}`;
    }
  };

  window.addEventListener('scroll', updateRingProgress, { passive: true });
  updateRingProgress();

  backToTopBtn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

/**
 * Dynamic Current Year in Footer
 */
function updateCurrentYear() {
  const yearEl = document.getElementById('current-year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }
}

/**
 * Highlights Active Navigation Link Based on Current URL
 */
function highlightActiveNav() {
  const rawPath = window.location.pathname.toLowerCase();
  const currentPath = rawPath.replace(/\/index\.(html|php)$/, '/').replace(/\/$/, '') + '/';
  const navLinks = document.querySelectorAll('.nav-link, .mobile-link, .nav-dropdown-item, .mobile-sublink');

  navLinks.forEach(link => {
    const rawHref = link.getAttribute('href');
    if (!rawHref) return;
    const linkPath = rawHref.split('?')[0].split('#')[0].replace(/\/index\.(html|php)$/, '/').replace(/\/$/, '') + '/';

    // Direct match
    if (linkPath === currentPath) {
      link.classList.add('active');
    } else if (linkPath === '/blog/' && (currentPath.startsWith('/blog/') || currentPath.includes('blog'))) {
      link.classList.add('active');
    } else if (linkPath === '/services/' && (currentPath.startsWith('/services/') || currentPath.includes('service'))) {
      link.classList.add('active');
    }
  });

  // If on a service subpage, auto-expand mobile submenu if present
  if (currentPath.startsWith('/services/') && currentPath !== '/services/') {
    const mobileSubmenu = document.querySelector('.mobile-submenu');
    const submenuBtn = document.querySelector('.mobile-submenu-btn');
    if (mobileSubmenu && submenuBtn) {
      mobileSubmenu.classList.add('is-open');
      submenuBtn.classList.add('is-expanded');
      submenuBtn.setAttribute('aria-expanded', 'true');
    }
  }
}



/**
 * Contact inquiry dispatch modal.
 */
function initInquiryDispatchModal() {
  const form = document.getElementById('consultation-inquiry-form');
  const modal = document.getElementById('contact-success-modal');
  if (!form || !modal) return;

  // Always start in the closed state, including after a browser back/forward restore.
  modal.classList.remove('is-open');
  modal.setAttribute('aria-hidden', 'true');
  document.body.classList.remove('modal-open');

  const closeModal = () => {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
  };

  form.addEventListener('submit', event => {
    event.preventDefault();
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    const value = id => document.getElementById(id)?.value.trim() || '';
    const nameVal = value('client-name');
    const emailVal = value('client-email');
    const phoneVal = value('client-phone');
    const companyVal = value('client-company');
    const serviceVal = value('client-service');
    const budgetVal = value('client-budget');
    const messageVal = value('client-message');

    const message = `Name: ${nameVal}\nEmail: ${emailVal}\nPhone: ${phoneVal}\nCompany: ${companyVal}\nService: ${serviceVal}\nBudget: ${budgetVal}\n\nProject Details:\n${messageVal}`;
    document.getElementById('modal-client-name').textContent = nameVal || 'there';
    document.getElementById('modal-mailto-btn').href = `mailto:${SITE_CONTACT_CONFIG.email}?subject=Strategic%20Inquiry&body=${encodeURIComponent(message)}`;
    document.getElementById('modal-whatsapp-btn').href = `https://wa.me/${SITE_CONTACT_CONFIG.whatsappNumber}?text=${encodeURIComponent(message)}`;

    // Asynchronously record lead in CRM database
    fetch('api/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name: nameVal,
        email: emailVal,
        phone: phoneVal,
        company: companyVal,
        service: serviceVal,
        budget: budgetVal,
        message: messageVal,
        source: 'Website Contact Page'
      })
    }).catch(() => {});

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
    modal.querySelector('.modal-close-trigger')?.focus();
  });

  modal.querySelector('.modal-close-trigger')?.addEventListener('click', closeModal);
  modal.addEventListener('click', event => { if (event.target === modal) closeModal(); });
  document.addEventListener('keydown', event => { if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal(); });
}

/** Copy direct contact details without navigating away from the page. */
function initCopyContactButtons() {
  document.querySelectorAll('.copy-contact-btn').forEach(button => {
    button.addEventListener('click', async () => {
      const value = button.dataset.copyValue;
      if (!value) return;
      const originalLabel = button.textContent;
      try {
        await navigator.clipboard.writeText(value);
      } catch {
        const helper = document.createElement('textarea');
        helper.value = value;
        document.body.appendChild(helper);
        helper.select();
        document.execCommand('copy');
        helper.remove();
      }
      button.textContent = 'Copied!';
      button.classList.add('is-copied');
      window.setTimeout(() => {
        button.textContent = originalLabel;
        button.classList.remove('is-copied');
      }, 1400);
    });
  });
}

/**
 * FAQ Accordion Interactivity
 */
function initFaqAccordion() {
  const items = [...document.querySelectorAll('.faq-item, .arch-faq-item, .rs-faq-item')];
  if (!items.length) return;

  const getGroup = item => item.closest('.faq-section, #faq, #dm-faq, .faq-wrap, .arch-faq-list') || item.parentElement;
  const closeItem = item => {
    item.classList.remove('active');
    item.querySelector('.faq-question, .arch-faq-question, .rs-faq-question')?.setAttribute('aria-expanded', 'false');
  };

  items.forEach(item => {
    const question = item.querySelector('.faq-question, .arch-faq-question, .rs-faq-question');
    if (!question) return;

    if (item.classList.contains('is-active')) item.classList.add('active');
    question.setAttribute('aria-expanded', String(item.classList.contains('active')));

    question.addEventListener('click', () => {
      const shouldOpen = !item.classList.contains('active');
      items.filter(other => getGroup(other) === getGroup(item)).forEach(closeItem);
      if (shouldOpen) {
        item.classList.add('active');
        question.setAttribute('aria-expanded', 'true');
      }
    });
  });
}

/**
 * ==========================================================================
 * FLOATING WHATSAPP & CALL ACTIONS
 * Injects floating action buttons on every page if not already in DOM.
 * ==========================================================================
 */
function initFloatingContactActions() {
  if (document.getElementById('rs-floating-actions') || document.querySelector('.floating-actions-container') || document.querySelector('.floating-actions')) return;

  const container = document.createElement('div');
  container.id = 'rs-floating-actions';
  container.className = 'floating-actions-container';
  container.setAttribute('aria-label', 'Direct contact options');

  const waEncodedMsg = encodeURIComponent(SITE_CONTACT_CONFIG.defaultWhatsAppMessage);
  const waUrl = `https://wa.me/${SITE_CONTACT_CONFIG.whatsappNumber}?text=${waEncodedMsg}`;
  const telUrl = `tel:${SITE_CONTACT_CONFIG.phoneNumber}`;

  container.innerHTML = `
    <!-- WhatsApp Floating Action -->
    <a href="${waUrl}"
       target="_blank"
       rel="noopener noreferrer"
       class="floating-action-btn floating-action-wa"
       aria-label="Chat with Ritwik Sachdeva on WhatsApp (${SITE_CONTACT_CONFIG.displayPhone})"
       title="WhatsApp: ${SITE_CONTACT_CONFIG.displayPhone}">
      <span class="floating-btn-tooltip">Chat on WhatsApp</span>
      <svg class="floating-icon" width="26" height="26" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2ZM12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.59 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19.01L7.55 18.83L4.44 19.65L5.27 16.61L5.07 16.3C4.24 14.98 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.67 12.05 3.67ZM8.95 7.36C8.75 7.36 8.52 7.43 8.32 7.64C8.12 7.86 7.55 8.39 7.55 9.47C7.55 10.55 8.34 11.59 8.45 11.74C8.56 11.89 10 14.1 12.16 15.03C12.67 15.25 13.07 15.38 13.38 15.48C13.89 15.65 14.36 15.62 14.73 15.57C15.14 15.51 15.99 15.05 16.17 14.55C16.35 14.04 16.35 13.61 16.3 13.52C16.25 13.43 16.1 13.38 15.88 13.27C15.65 13.15 14.54 12.61 14.33 12.54C14.13 12.46 13.98 12.42 13.83 12.64C13.68 12.87 13.25 13.38 13.12 13.52C12.99 13.67 12.87 13.69 12.64 13.57C12.42 13.46 11.69 13.22 10.83 12.45C10.16 11.85 9.71 11.11 9.58 10.89C9.46 10.66 9.57 10.54 9.68 10.43C9.78 10.33 9.9 10.17 10.02 10.04C10.13 9.9 10.17 9.8 10.25 9.63C10.33 9.47 10.29 9.32 10.23 9.21C10.17 9.1 9.74 8.04 9.56 7.61C9.38 7.18 9.2 7.24 9.07 7.23C8.95 7.23 8.81 7.23 8.67 7.23L8.95 7.36Z"/>
      </svg>
    </a>

    <!-- Phone Call Floating Action -->
    <a href="${telUrl}"
       class="floating-action-btn floating-action-call"
       aria-label="Call Ritwik Sachdeva directly at ${SITE_CONTACT_CONFIG.displayPhone}"
       title="Call: ${SITE_CONTACT_CONFIG.displayPhone}">
      <span class="floating-btn-tooltip">Call Direct</span>
      <svg class="floating-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
    </a>
  `;

  document.body.appendChild(container);
}

/* Legacy pages carry their own floating buttons. Keep their WhatsApp mark
   consistent with the globally injected version without changing their links. */
function normalizeFloatingWhatsAppIcons() {
  const whatsappIcon = `
    <svg class="floating-icon" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
      <path d="M20.5 11.8a8.5 8.5 0 0 1-12.55 7.5L3.5 20.5l1.2-4.15A8.5 8.5 0 1 1 20.5 11.8Z" />
      <path d="M8.3 7.9c.16-.38.33-.4.61-.4h.52c.16 0 .38.06.48.31l.67 1.62c.08.21.07.37-.04.55l-.42.68c-.09.14-.18.29-.07.48.1.18.46.75.99 1.22.69.62 1.28.81 1.46.9.18.09.29.08.39-.05l.62-.73c.13-.16.27-.13.46-.06l1.56.74c.23.11.38.16.44.25.06.09.06.52-.12 1.02-.17.5-1.01.96-1.38 1.01-.35.05-.79.17-2.68-.57-2.27-.89-3.72-3.08-3.83-3.23-.11-.15-.92-1.22-.92-2.33 0-1.11.58-1.66.79-1.89Z" />
    </svg>`;

  document.querySelectorAll('.floating-btn-whatsapp, .floating-action-wa').forEach((button) => {
    const existingIcon = button.querySelector('svg');
    if (existingIcon) existingIcon.outerHTML = whatsappIcon;
  });
}

/**
 * ==========================================================================
 * CONSULTATION POPUP MODAL
 * - Automatically opens 4 seconds after initial arrival
 * - Shown once per browser session via sessionStorage
 * - Fully accessible keyboard navigation (Tab trap, Escape key, focus restore)
 * - Backdrop click to close
 * - Labeled fields in required order: Name, Email, Number, Message (optional)
 * - Clear field validation and status feedback
 * - Submits to api/contact.php and only shows success when backend succeeds
 * ==========================================================================
 */
function initConsultationPopup() {
  // Pages carrying the shared two-column popup use consult-popup.js as the
  // single controller. Do not create the older alternate modal as well.
  if (document.getElementById('consult-popup-overlay')) return;
  const cleanPath = window.location.pathname.toLowerCase().replace(/\/index\.(html|php)$/, '/').replace(/\/$/, '') + '/';
  const isExcludedPage = cleanPath === '/contact/' || (cleanPath.startsWith('/services/') && cleanPath !== '/services/') || (cleanPath.startsWith('/blog/') && cleanPath !== '/blog/');
  if (isExcludedPage) return;
  const SESSION_KEY = 'rs_consultation_popup_seen';

  // Older pages included an unused static modal. The enhanced shared modal is
  // the only one kept on eligible pages, so there is no duplicate backdrop.
  const legacyPopup = document.getElementById('consultation-popup');
  if (legacyPopup) legacyPopup.remove();

  let popupOverlay = document.getElementById('rs-consultation-popup');
  if (!popupOverlay) {
    popupOverlay = document.createElement('div');
    popupOverlay.id = 'rs-consultation-popup';
    popupOverlay.className = 'consultation-popup-overlay';
    popupOverlay.setAttribute('role', 'dialog');
    popupOverlay.setAttribute('aria-modal', 'true');
    popupOverlay.setAttribute('aria-labelledby', 'consultation-popup-title');
    popupOverlay.setAttribute('aria-describedby', 'consultation-popup-desc');

    const waEncodedMsg = encodeURIComponent('Hello Ritwik, I have submitted a consultation request and would like to connect.');
    const waUrl = `https://wa.me/${SITE_CONTACT_CONFIG.whatsappNumber}?text=${waEncodedMsg}`;

    popupOverlay.innerHTML = `
      <div class="consultation-popup-backdrop" data-close-popup="true"></div>
      <div class="consultation-popup-dialog">
        <button type="button" class="consultation-popup-close" id="consultation-popup-close-btn" aria-label="Close consultation dialog" data-close-popup="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>

        <div class="consultation-popup-header">
          <div class="consultation-popup-badge">Free Growth Consultation</div>
          <h2 id="consultation-popup-title" class="consultation-popup-title">Book a Consultation</h2>
          <p id="consultation-popup-desc" class="consultation-popup-desc">
            Share your goals and challenges with Ritwik Sachdeva. We'll connect with you within 24 business hours.
          </p>
        </div>

        <form id="rs-consultation-popup-form" class="consultation-popup-form" novalidate>
          <!-- 1. Name — required -->
          <div class="consultation-form-group">
            <label for="popup-client-name" class="consultation-form-label">Name <span class="required-mark">*</span></label>
            <input type="text" id="popup-client-name" name="name" class="consultation-form-input" placeholder="e.g. Alex Morgan" required autocomplete="name">
            <div class="consultation-field-error" id="err-popup-name">Please enter your full name (at least 2 characters).</div>
          </div>

          <!-- 2. Email — required -->
          <div class="consultation-form-group">
            <label for="popup-client-email" class="consultation-form-label">Email <span class="required-mark">*</span></label>
            <input type="email" id="popup-client-email" name="email" class="consultation-form-input" placeholder="e.g. alex@company.com" required autocomplete="email">
            <div class="consultation-field-error" id="err-popup-email">Please enter a valid email address.</div>
          </div>

          <!-- 3. Number — required -->
          <div class="consultation-form-group">
            <label for="popup-client-phone" class="consultation-form-label">Mobile Number <span class="required-mark">*</span></label>
            <input type="tel" id="popup-client-phone" name="phone" class="consultation-form-input" placeholder="e.g. +91 9876543210" inputmode="tel" minlength="10" required autocomplete="tel">
            <div class="consultation-field-error" id="err-popup-phone">Please enter a valid 10-digit mobile number.</div>
          </div>

          <!-- 4. Message — optional -->
          <div class="consultation-form-group">
            <label for="popup-client-message" class="consultation-form-label">Message <span class="optional-mark">(Optional)</span></label>
            <textarea id="popup-client-message" name="message" class="consultation-form-textarea" rows="3" placeholder="Give us a bit about your idea..."></textarea>
            <div class="consultation-field-error" id="err-popup-message"></div>
          </div>

          <!-- Submission Status Banner -->
          <div class="consultation-popup-status" id="popup-submission-status" role="alert" aria-live="polite" style="display: none;"></div>

          <!-- Submit Button -->
          <button type="submit" class="consultation-popup-submit-btn" id="popup-submit-btn">
            <span class="btn-text">Submit Request</span><span aria-hidden="true">&rarr;</span>
          </button>

          <div class="consultation-popup-footer-note">
            Y"' Strictly confidential. Your information is never shared.
          </div>
        </form>

        <!-- Success View (Shown ONLY on successful backend submission) -->
        <div id="popup-success-view" class="consultation-popup-success" style="display: none;">
          <div class="consultation-success-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </div>
          <h3 class="consultation-success-title">Consultation Request Received!</h3>
          <p class="consultation-success-desc" id="popup-success-message">
            Thank you! Your strategic consultation request has been recorded. Ritwik will review your brief and connect with you within 24 business hours.
          </p>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="${waUrl}"
               target="_blank"
               rel="noopener noreferrer"
               class="btn btn-secondary"
               style="width: 100%; text-align: center; justify-content: center;">
              Fast-Track via WhatsApp
            </a>
            <button type="button" class="btn btn-outline" style="width: 100%;" data-close-popup="true">
              Close
            </button>
          </div>
        </div>
      </div>
    `;

    document.body.appendChild(popupOverlay);
  }

  let previousActiveElement = null;
  let isPopupOpen = false;

  function openPopup() {
    if (isPopupOpen) return;
    try {
      sessionStorage.setItem(SESSION_KEY, 'seen');
    } catch (e) {}

    previousActiveElement = document.activeElement;
    isPopupOpen = true;

    popupOverlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';

    // Move focus into the first input field
    const nameInput = document.getElementById('popup-client-name');
    if (nameInput) {
      setTimeout(() => nameInput.focus(), 80);
    }
  }

  function closePopup() {
    if (!isPopupOpen) return;
    isPopupOpen = false;

    try {
      sessionStorage.setItem('rs_consultation_popup_dismissed', 'true');
    } catch (e) {}

    popupOverlay.classList.remove('is-active');
    document.body.style.overflow = '';
    if (previousActiveElement && typeof previousActiveElement.focus === 'function') {
      previousActiveElement.focus();
    }
  }

  // Bind close triggers (button and backdrop)
  popupOverlay.addEventListener('click', (e) => {
    if (e.target && e.target.closest('[data-close-popup="true"]')) {
      closePopup();
    }
  });

  // Accessible Keyboard Navigation & Focus Trap
  document.addEventListener('keydown', (e) => {
    if (!isPopupOpen) return;

    if (e.key === 'Escape') {
      e.preventDefault();
      closePopup();
      return;
    }

    if (e.key === 'Tab') {
      const focusableElements = popupOverlay.querySelectorAll(
        'button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), a[href], [tabindex]:not([tabindex="-1"])'
      );
      if (!focusableElements.length) return;

      const firstEl = focusableElements[0];
      const lastEl = focusableElements[focusableElements.length - 1];

      if (e.shiftKey) {
        if (document.activeElement === firstEl) {
          e.preventDefault();
          lastEl.focus();
        }
      } else {
        if (document.activeElement === lastEl) {
          e.preventDefault();
          firstEl.focus();
        }
      }
    }
  });

  // Handle Form Submission
  const form = document.getElementById('rs-consultation-popup-form');
  const submitBtn = document.getElementById('popup-submit-btn');
  const statusBanner = document.getElementById('popup-submission-status');
  const successView = document.getElementById('popup-success-view');

  const nameInput = document.getElementById('popup-client-name');
  const emailInput = document.getElementById('popup-client-email');
  const phoneInput = document.getElementById('popup-client-phone');
  const messageInput = document.getElementById('popup-client-message');

  const errName = document.getElementById('err-popup-name');
  const errEmail = document.getElementById('err-popup-email');
  const errPhone = document.getElementById('err-popup-phone');

  function clearErrors() {
    [nameInput, emailInput, phoneInput, messageInput].forEach(inp => {
      if (inp) inp.classList.remove('is-invalid');
    });
    [errName, errEmail, errPhone].forEach(err => {
      if (err) {
        err.classList.remove('is-visible');
        err.style.display = 'none';
      }
    });
    if (statusBanner) {
      statusBanner.className = 'consultation-popup-status';
      statusBanner.style.display = 'none';
      statusBanner.textContent = '';
    }
  }

  // Clear errors as user inputs values
  [nameInput, emailInput, phoneInput].forEach(inp => {
    if (inp) {
      inp.addEventListener('input', () => {
        inp.classList.remove('is-invalid');
        const errEl = document.getElementById('err-' + inp.id.replace('client-', ''));
        if (errEl) errEl.style.display = 'none';
      });
    }
  });

  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      clearErrors();

      const nameVal = nameInput ? nameInput.value.trim() : '';
      const emailVal = emailInput ? emailInput.value.trim() : '';
      const phoneVal = phoneInput ? phoneInput.value.trim() : '';
      const messageVal = messageInput ? messageInput.value.trim() : '';

      let isValid = true;

      // 1. Name validation (required, >= 2 chars)
      if (nameVal.length < 2) {
        isValid = false;
        if (nameInput) nameInput.classList.add('is-invalid');
        if (errName) {
          errName.textContent = 'Please enter your full name (at least 2 characters).';
          errName.style.display = 'block';
        }
      }

      // 2. Email validation (required, valid format)
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailVal || !emailRegex.test(emailVal)) {
        isValid = false;
        if (emailInput) emailInput.classList.add('is-invalid');
        if (errEmail) {
          errEmail.textContent = 'Please enter a valid email address.';
          errEmail.style.display = 'block';
        }
      }

      // 3. Number validation (required, >= 7 digits)
      const cleanPhone = phoneVal.replace(/[^0-9]/g, '');
        if (cleanPhone.length < 10) {
        isValid = false;
        if (phoneInput) phoneInput.classList.add('is-invalid');
        if (errPhone) {
          errPhone.textContent = 'Please enter a valid 10-digit mobile number.';
          errPhone.style.display = 'block';
        }
      }

      if (!isValid) return;

      // Submission in progress
      if (submitBtn) {
        submitBtn.disabled = true;
        const btnText = submitBtn.querySelector('.btn-text');
        if (btnText) btnText.textContent = 'Submitting Request...';
      }

      try {
        const response = await fetch('api/contact.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            name: nameVal,
            email: emailVal,
            phone: phoneVal,
            message: messageVal,
            source: 'Website Consultation Popup'
          })
        });

        const data = await response.json().catch(() => null);

        if (response.ok && data && data.success) {
          // Verified backend success! Show success confirmation
          form.style.display = 'none';
          if (successView) {
            successView.style.display = 'block';
            const msgEl = document.getElementById('popup-success-message');
            if (msgEl && data.message) msgEl.textContent = data.message;
          }
        } else {
          // Backend error returned
          let errorMsg = 'An error occurred while saving your inquiry. Please try again or reach out directly.';
          if (data && data.errors) {
            errorMsg = Object.values(data.errors).join(' ');
          } else if (data && data.error) {
            errorMsg = data.error;
          }

          if (statusBanner) {
            statusBanner.className = 'consultation-popup-status is-error';
            statusBanner.textContent = errorMsg;
            statusBanner.style.display = 'block';
          }
        }
      } catch (err) {
        // Network or server unreachable
        if (statusBanner) {
          statusBanner.className = 'consultation-popup-status is-error';
          statusBanner.innerHTML = `Unable to reach the server. Please reach out directly via <a href="https://wa.me/${SITE_CONTACT_CONFIG.whatsappNumber}" target="_blank" style="color: inherit; text-decoration: underline; font-weight: 700;">WhatsApp</a> or <a href="tel:${SITE_CONTACT_CONFIG.phoneNumber}" style="color: inherit; text-decoration: underline; font-weight: 700;">Call (${SITE_CONTACT_CONFIG.displayPhone})</a>.`;
          statusBanner.style.display = 'block';
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          const btnText = submitBtn.querySelector('.btn-text');
          if (btnText) btnText.textContent = 'Submit Request';
        }
      }
    });
  }

  // Expose to window for global access, testing, and other button hooks
  window.openConsultationPopup = openPopup;
  window.closeConsultationPopup = closePopup;

  // Bind any CTA or link that wants to trigger the consultation popup
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-open-popup="consultation"], a[href="#consultation"], a[href="#popup"]');
    if (trigger) {
      e.preventDefault();
      openPopup();
    }
  });

  // If URL contains ?popup=1 or #popup or #consultation, open immediately
  if (
    window.location.search.includes('popup') ||
    window.location.hash === '#popup' ||
    window.location.hash === '#consultation'
  ) {
    setTimeout(openPopup, 300);
  } else {
    // One invitation per page visit; refreshing schedules it again.
    window.setTimeout(() => {
      if (!isPopupOpen) openPopup();
    }, 5000);
  }
}

/**
 * ==========================================================================
 * COMPACT HEADER TOP BAR INJECTOR
 * Injects the clickable contact links row into the header if not statically present.
 * ==========================================================================
 */
function initHeaderTopBar() {
  const header = document.querySelector('.site-header');
  if (!header || header.querySelector('.header-top-bar')) return;

  const topBar = document.createElement('div');
  topBar.className = 'header-top-bar';
  topBar.innerHTML = `
    <div class="container header-top-container">
      <div class="header-top-left">
        <span class="header-top-status-dot"></span>
        <span>Available for Q1 Consulting & Growth Audits</span>
      </div>
      <div class="header-top-links">
        <a href="mailto:${SITE_CONTACT_CONFIG.email}" class="header-top-link">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <span>${SITE_CONTACT_CONFIG.email}</span>
        </a>
        <span class="header-top-sep">|</span>
        <a href="tel:${SITE_CONTACT_CONFIG.phoneNumber}" class="header-top-link">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          <span>${SITE_CONTACT_CONFIG.displayPhone}</span>
        </a>
      </div>
    </div>
  `;
  header.insertBefore(topBar, header.firstChild);
}

/**
 * ==========================================================================
 * FAST 0-100% PRELOADER & CURTAIN WIPE
 * Runs once per browser session via sessionStorage. Respects reduced motion.
 * ==========================================================================
 */
function initPreloader() {
  const PRELOADER_KEY = 'rs_preloader_seen';
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (prefersReducedMotion || sessionStorage.getItem(PRELOADER_KEY)) {
    return;
  }

  const preloader = document.createElement('div');
  preloader.id = 'rs-preloader';
  preloader.className = 'site-preloader';
  preloader.innerHTML = `
    <div class="preloader-counter"><span id="preloader-num">0</span>%</div>
    <div class="preloader-track"><div class="preloader-fill" id="preloader-fill"></div></div>
  `;
  document.body.appendChild(preloader);
  document.body.style.overflow = 'hidden';

  const numEl = document.getElementById('preloader-num');
  const fillEl = document.getElementById('preloader-fill');

  let current = 0;
  const target = 100;
  const duration = 520;
  const startTime = performance.now();

  function updatePreloader(now) {
    const elapsed = now - startTime;
    const progress = Math.min(elapsed / duration, 1);
    current = Math.floor(progress * target);

    if (numEl) numEl.textContent = current;
    if (fillEl) fillEl.style.width = `${current}%`;

    if (progress < 1) {
      requestAnimationFrame(updatePreloader);
    } else {
      sessionStorage.setItem(PRELOADER_KEY, 'true');
      preloader.classList.add('preloader-curtain-up');
      document.body.style.overflow = '';
      setTimeout(() => {
        if (preloader.parentNode) preloader.parentNode.removeChild(preloader);
      }, 550);
    }
  }

  requestAnimationFrame(updatePreloader);
}

/**
 * ==========================================================================
 * BLUE PARTICLE CONSTELLATION CANVAS
 * Renders behind the Home hero section. Pauses when hidden, reduced on mobile.
 * ==========================================================================
 */
function initConstellationCanvas() {
  const heroSection = document.getElementById('hero');
  if (!heroSection) return;

  const canvas = document.createElement('canvas');
  canvas.className = 'hero-constellation-canvas';
  canvas.id = 'hero-constellation';
  canvas.setAttribute('aria-hidden', 'true');
  heroSection.insertBefore(canvas, heroSection.firstChild);

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  let width = 0;
  let height = 0;
  let particles = [];
  let animationId = null;
  let isPaused = false;

  const isMobile = window.innerWidth <= 768;
  const particleCount = isMobile ? 26 : 56;
  const maxDistance = isMobile ? 85 : 120;

  function resize() {
    width = heroSection.offsetWidth;
    height = heroSection.offsetHeight;
    canvas.width = width;
    canvas.height = height;
  }

  function createParticles() {
    particles = [];
    for (let i = 0; i < particleCount; i++) {
      particles.push({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.45,
        vy: (Math.random() - 0.5) * 0.45,
        radius: Math.random() * 1.8 + 1
      });
    }
  }

  function render() {
    if (isPaused) return;
    ctx.clearRect(0, 0, width, height);

    for (let i = 0; i < particles.length; i++) {
      const p = particles[i];
      p.x += p.vx;
      p.y += p.vy;

      if (p.x < 0) p.x = width;
      else if (p.x > width) p.x = 0;
      if (p.y < 0) p.y = height;
      else if (p.y > height) p.y = 0;

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(29, 78, 216, 0.45)';
      ctx.fill();

      for (let j = i + 1; j < particles.length; j++) {
        const p2 = particles[j];
        const dx = p.x - p2.x;
        const dy = p.y - p2.y;
        const dist = Math.sqrt(dx * dx + dy * dy);

        if (dist < maxDistance) {
          const alpha = (1 - dist / maxDistance) * 0.22;
          ctx.beginPath();
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(p2.x, p2.y);
          ctx.strokeStyle = `rgba(29, 78, 216, ${alpha})`;
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }

    animationId = requestAnimationFrame(render);
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      isPaused = true;
      if (animationId) cancelAnimationFrame(animationId);
    } else {
      isPaused = false;
      render();
    }
  });

  window.addEventListener('resize', () => {
    resize();
  }, { passive: true });

  resize();
  createParticles();
  render();
}

/**
 * ==========================================================================
 * SUBTLE MOUSE SPOTLIGHT & GENTLE 3D TILT (±4°)
 * Applied to Practice cards, Metric cards, and Contact cards. Disabled on touch.
 * ==========================================================================
 */
function initGentleTiltAndSpotlight() {
  if (window.matchMedia('(pointer: coarse)').matches) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const cards = document.querySelectorAll(
    '.hp-service-slab, .service-premium-card, .rs-ecom-card, ' +
    '.hp-stat-ledger-item, .metric-strip-item, .arch-kpi-card, .contact-direct-item'
  );

  cards.forEach(card => {
    card.classList.add('has-spotlight', 'gentle-tilt');

    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      card.style.setProperty('--spot-x', `${x}px`);
      card.style.setProperty('--spot-y', `${y}px`);

      const normX = ((x / rect.width) - 0.5) * 2;
      const normY = ((y / rect.height) - 0.5) * 2;
      const rotateX = Math.max(-4, Math.min(4, -normY * 4));
      const rotateY = Math.max(-4, Math.min(4, normX * 4));

      card.style.transform = `perspective(700px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-2px)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
      card.style.transition = 'transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease';
    });

    card.addEventListener('mouseenter', () => {
      card.style.transition = 'none';
    });
  });
}

/**
 * ==========================================================================
 * INTERSECTION OBSERVER REVEAL WITH 80MS STAGGER
 * ==========================================================================
 */
function initStaggeredScrollReveals() {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const elements = document.querySelectorAll('.reveal-on-scroll, .reveal-from-left, .reveal-from-right, .arch-ledger-card, .hp-framework-col');
  if (!elements.length) return;

  if (prefersReducedMotion) {
    elements.forEach(el => {
      el.classList.add('is-revealed', 'is-visible');
    });
    return;
  }

  const observer = new IntersectionObserver((entries, obs) => {
    let staggerIndex = 0;
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        setTimeout(() => {
          el.classList.add('is-revealed', 'is-visible');
        }, staggerIndex * 80);
        staggerIndex++;
        obs.unobserve(el);
      }
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -40px 0px'
  });

  elements.forEach(el => observer.observe(el));
}

/**
 * ==========================================================================
 * CHARACTER-SCRAMBLE HOVER ON LIME HERO BADGE
 * ==========================================================================
 */
function initHeroBadgeScramble() {
  const kickers = document.querySelectorAll('.hp-hero-kicker, .hero-kicker, .section-tag');
  const chars = '_/>*#[]01!+~=';

  kickers.forEach(kicker => {
    const originalText = kicker.textContent.trim();
    kicker.setAttribute('aria-label', originalText);
    let interval = null;
    let isScrambling = false;

    kicker.addEventListener('mouseenter', () => {
      if (isScrambling) return;
      isScrambling = true;

      let iteration = 0;
      clearInterval(interval);

      interval = setInterval(() => {
        kicker.textContent = originalText
          .split('')
          .map((char, index) => {
            if (char === ' ') return ' ';
            if (index < iteration) {
              return originalText[index];
            }
            return chars[Math.floor(Math.random() * chars.length)];
          })
          .join('');

        if (iteration >= originalText.length) {
          clearInterval(interval);
          kicker.textContent = originalText;
          isScrambling = false;
        }

        iteration += 1 / 2;
      }, 30);
    });

    kicker.addEventListener('mouseleave', () => {
      clearInterval(interval);
      kicker.textContent = originalText;
      isScrambling = false;
    });
  });
}

/**
 * ==========================================================================
 * MAGNETIC BUTTONS (~0.25 STRENGTH)
 * ==========================================================================
 */
function initMagneticButtons() {
  if (window.matchMedia('(pointer: coarse)').matches) return;
  const buttons = document.querySelectorAll('.btn-primary, .hp-btn-primary, .btn-magnetic, .arch-cta-btn');

  buttons.forEach(btn => {
    if (btn.dataset.magneticBound) return;
    btn.dataset.magneticBound = 'true';

    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      btn.style.transform = `translate(${x * 0.25}px, ${y * 0.25}px)`;
    });

    btn.addEventListener('mouseleave', () => {
      btn.style.transform = 'translate(0px, 0px)';
      btn.style.transition = 'transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
    });

    btn.addEventListener('mouseenter', () => {
      btn.style.transition = 'none';
    });
  });
}

/**
 * ==========================================================================
 * LIGHTWEIGHT CLICK RIPPLE GENERATOR
 * ==========================================================================
 */
function initClickRipples() {
  document.addEventListener('click', (e) => {
    if (e.target && e.target.closest('input, textarea, select')) return;

    const ripple = document.createElement('div');
    ripple.className = 'click-ripple';
    ripple.style.left = `${e.clientX}px`;
    ripple.style.top = `${e.clientY}px`;
    document.body.appendChild(ripple);

    setTimeout(() => {
      if (ripple.parentNode) ripple.parentNode.removeChild(ripple);
    }, 460);
  });
}


