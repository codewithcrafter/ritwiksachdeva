with open('js/main.js', 'r', encoding='utf-8') as f:
    c = f.read()

# 1. Update highlightActiveNav
old_highlight = """function highlightActiveNav() {
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
}"""

new_highlight = """function highlightActiveNav() {
  const rawPath = window.location.pathname.toLowerCase();
  const currentPath = rawPath.replace(/\\/index\\.(html|php)$/, '/').replace(/\\/$/, '') + '/';
  const navLinks = document.querySelectorAll('.nav-link, .mobile-link, .nav-dropdown-item, .mobile-sublink');

  navLinks.forEach(link => {
    const rawHref = link.getAttribute('href');
    if (!rawHref) return;
    const linkPath = rawHref.split('?')[0].split('#')[0].replace(/\\/index\\.(html|php)$/, '/').replace(/\\/$/, '') + '/';

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
}"""

assert old_highlight in c, "old_highlight not found in js/main.js"
c = c.replace(old_highlight, new_highlight, 1)

# 2. Update initConsultationPopup
old_popup = """function initConsultationPopup() {
  const pageName = (window.location.pathname.split('/').pop() || 'index.html').toLowerCase();
  const isExcludedPage = pageName === 'contact.html' || pageName === 'blog-detail.php' || pageName.startsWith('service-') || (pageName.startsWith('blog-') && pageName !== 'blog.html');
  if (isExcludedPage) return;"""

new_popup = """function initConsultationPopup() {
  const cleanPath = window.location.pathname.toLowerCase().replace(/\\/index\\.(html|php)$/, '/').replace(/\\/$/, '') + '/';
  const isExcludedPage = cleanPath === '/contact/' || (cleanPath.startsWith('/services/') && cleanPath !== '/services/') || (cleanPath.startsWith('/blog/') && cleanPath !== '/blog/');
  if (isExcludedPage) return;"""

assert old_popup in c, "old_popup not found in js/main.js"
c = c.replace(old_popup, new_popup, 1)

with open('js/main.js', 'w', encoding='utf-8') as f:
    f.write(c)

print("js/main.js updated cleanly for clean URLs.")
