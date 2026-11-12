/**
 * PREMIUM DIGITAL MARKETING CONSULTANT PORTFOLIO - MAIN SCRIPT
 * Handles header transitions, mobile navigation drawer, scroll progress bar, and active link state.
 */

document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileDrawer();
  initDropdownNav();
  initScrollProgress();
  initBackToTop();
  updateCurrentYear();
  highlightActiveNav();
});

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
    toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  };

  const closeDrawer = () => {
    toggleBtn.classList.remove('is-active');
    drawer.classList.remove('is-open');
    toggleBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  };

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
 * Back to Top Smooth Scroll
 */
function initBackToTop() {
  const backToTopBtn = document.getElementById('back-to-top');
  if (!backToTopBtn) return;

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
  const path = window.location.pathname;
  const currentFile = path.split('/').pop() || 'index.html';
  const navLinks = document.querySelectorAll('.nav-link, .mobile-link, .nav-dropdown-item, .mobile-sublink');

  navLinks.forEach(link => {
    const href = link.getAttribute('href');
    if (!href) return;
    const cleanHref = href.split('/').pop().replace(/#.*$/, '');

    // Direct match
    if (cleanHref === currentFile || (currentFile === '' && cleanHref === 'index.html')) {
      link.classList.add('active');
    } else if ((cleanHref === 'blog.php' || cleanHref === 'blog.html') && (currentFile.includes('blog') || path.includes('/blog'))) {
      link.classList.add('active');
    } else if (cleanHref === 'services.html' && (currentFile.startsWith('service-') || currentFile === 'services.html')) {
      link.classList.add('active');
    }
  });

  // If on a service subpage, auto-expand mobile submenu if present
  if (currentFile.startsWith('service-')) {
    const mobileSubmenu = document.querySelector('.mobile-submenu');
    const submenuBtn = document.querySelector('.mobile-submenu-btn');
    if (mobileSubmenu && submenuBtn) {
      mobileSubmenu.classList.add('is-open');
      submenuBtn.classList.add('is-expanded');
      submenuBtn.setAttribute('aria-expanded', 'true');
    }
  }
}

