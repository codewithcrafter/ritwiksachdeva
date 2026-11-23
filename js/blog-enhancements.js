/* Lightweight editorial interactions shared by the listing and static article readers. */
document.addEventListener('DOMContentLoaded', () => {
  // Reveal animation on scroll
  document.querySelectorAll('.blog-hero h1, .featured-blog-title, .article-title, .article-prose h2, .article-author-card, .blog-card').forEach((item) => item.classList.add('blog-reveal'));
  const reveal = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });
  document.querySelectorAll('.blog-reveal').forEach((item) => reveal.observe(item));

  // Note: 3D tilt effects have been strictly removed per design standards.
  // Subtle neo-brutalist hover elevation is handled purely via CSS.

  // Ripple feedback on click
  document.querySelectorAll('.blog-card, .featured-blog-card, .share-btn, .read-more-link').forEach((item) => {
    item.addEventListener('click', (event) => {
      const bounds = item.getBoundingClientRect();
      const ripple = document.createElement('span');
      ripple.className = 'blog-ripple';
      ripple.style.width = ripple.style.height = `${Math.max(bounds.width, bounds.height)}px`;
      ripple.style.left = `${event.clientX - bounds.left - bounds.width / 2}px`;
      ripple.style.top = `${event.clientY - bounds.top - bounds.height / 2}px`;
      item.style.position = 'relative';
      item.style.overflow = 'hidden';
      item.appendChild(ripple);
      ripple.addEventListener('animationend', () => ripple.remove());
    });
  });

  const prose = document.querySelector('.article-prose');
  const toc = document.querySelector('.toc-sidebar');
  if (!prose || !toc) return;

  // Turn markdown-style unit-economics tables into real responsive tables
  prose.querySelectorAll('p').forEach((paragraph) => {
    const lines = paragraph.textContent.split(/\n/).map((line) => line.trim()).filter(Boolean);
    if (lines.length < 3 || !lines[0].startsWith('|') || !lines[1].includes(':---')) return;
    const rows = lines.filter((line) => line.startsWith('|')).map((line) => line.split('|').slice(1, -1).map((cell) => cell.trim()));
    if (rows.length < 3) return;
    const table = document.createElement('table');
    const header = document.createElement('thead');
    header.innerHTML = `<tr>${rows[0].map((cell) => `<th>${cell}</th>`).join('')}</tr>`;
    const body = document.createElement('tbody');
    rows.slice(2).forEach((row) => {
      const tr = document.createElement('tr');
      tr.innerHTML = row.map((cell) => `<td>${cell}</td>`).join('');
      body.appendChild(tr);
    });
    table.append(header, body);
    paragraph.replaceWith(table);
  });

  // Ensure consultation widget exists inside TOC sidebar if not already present
  const existingForm = toc.querySelector('.toc-consultation');
  if (!existingForm) {
    const form = document.createElement('form');
    form.className = 'toc-consultation';
    form.action = '/contact/';
    form.method = 'get';
    form.innerHTML = `<div class="section-tag">Need Custom Implementation?</div><h3>Request Consultation</h3><p>I work directly with founders and leadership teams to execute these frameworks.</p><input name="name" required aria-label="Your Name" placeholder="Your Name *"><input name="email" type="email" required aria-label="Work Email" placeholder="Work Email *"><select name="focus" aria-label="Primary Focus"><option>Business Strategy & Advisory</option><option>Performance Marketing</option><option>Digital Transformation</option><option>Leadership & Growth</option></select><textarea name="bottleneck" aria-label="Key growth bottleneck" placeholder="Key growth bottleneck..."></textarea><button type="submit">Request Consultation &rarr;</button>`;
    toc.appendChild(form);
    const legacyCta = toc.querySelector('div[style*="margin-top"]');
    if (legacyCta) legacyCta.remove();
  }

  // Active heading spy for Table of Contents
  const links = [...toc.querySelectorAll('.toc-link')].filter((link) => {
    const href = link.getAttribute('href');
    return href && href.startsWith('#') && document.querySelector(href);
  });
  const headings = links.map((link) => document.querySelector(link.getAttribute('href')));
  if (headings.length > 0) {
    const spy = new IntersectionObserver((entries) => {
      const current = entries.filter((entry) => entry.isIntersecting).sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top)[0];
      if (!current) return;
      links.forEach((link) => link.classList.toggle('active', link.getAttribute('href') === `#${current.target.id}`));
    }, { rootMargin: '-22% 0px -65% 0px', threshold: 0 });
    headings.forEach((heading) => spy.observe(heading));
  }
});
