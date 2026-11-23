with open('css/style.css', 'r', encoding='utf-8') as f:
    css = f.read()

old_css = '''/* ==========================================================================
   9. CUSTOM ANIMATED CURSOR (CREATIVE GROWTH LAB)
   ========================================================================== */
.custom-cursor-dot {
  position: fixed;
  top: 0;
  left: 0;
  width: 10px;
  height: 10px;
  background-color: var(--cobalt-blue);
  border-radius: 50%;
  pointer-events: none;
  z-index: 999999;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: opacity 0.2s ease;
}

.custom-cursor-ring {
  position: fixed;
  top: 0;
  left: 0;
  width: 40px;
  height: 40px;
  border: 2px solid var(--cobalt-blue);
  background-color: rgba(36, 75, 255, 0.04);
  border-radius: 50%;
  pointer-events: none;
  z-index: 999998;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: width 0.26s cubic-bezier(0.16, 1, 0.3, 1),
    height 0.26s cubic-bezier(0.16, 1, 0.3, 1),
    opacity 0.2s ease,
    background-color 0.2s ease,
    border-color 0.2s ease;
}

.custom-cursor-ring.cursor-active {
  width: 64px;
  height: 64px;
  border-color: #0F172A;
  background-color: var(--acid-lime-light);
  box-shadow: 0 0 24px rgba(213, 255, 69, 0.45);
}'''

new_css = '''/* ==========================================================================
   9. CUSTOM ANIMATED CURSOR
   Hide native operating system mouse cursor completely on pointer devices.
   Only the custom circular cursor (ring + centered dot) is shown.
   ========================================================================== */
@media (pointer: fine) {
  html,
  body,
  *,
  *::before,
  *::after {
    cursor: none !important;
  }
}

.custom-cursor {
  position: fixed;
  top: 0;
  left: 0;
  width: 0;
  height: 0;
  pointer-events: none;
  z-index: 9999999;
  opacity: 0;
  transition: opacity 0.2s ease;
  will-change: transform;
}

.custom-cursor-ring {
  position: absolute;
  top: 0;
  left: 0;
  width: 36px;
  height: 36px;
  transform: translate(-50%, -50%);
  border: 2px solid #2563EB;
  background-color: rgba(37, 99, 235, 0.05);
  border-radius: 50%;
  pointer-events: none;
  transition: width 0.22s cubic-bezier(0.16, 1, 0.3, 1),
              height 0.22s cubic-bezier(0.16, 1, 0.3, 1),
              background-color 0.2s ease,
              border-color 0.2s ease,
              box-shadow 0.2s ease,
              transform 0.15s ease;
}

.custom-cursor-dot {
  position: absolute;
  top: 0;
  left: 0;
  width: 8px;
  height: 8px;
  transform: translate(-50%, -50%);
  background-color: #2563EB;
  border-radius: 50%;
  pointer-events: none;
  transition: transform 0.15s ease, background-color 0.2s ease;
}

/* Hover state on interactive elements */
.custom-cursor.cursor-active .custom-cursor-ring {
  width: 50px;
  height: 50px;
  border-color: #1D4ED8;
  background-color: rgba(212, 245, 66, 0.25);
  box-shadow: 0 0 20px rgba(37, 99, 235, 0.25);
}

.custom-cursor.cursor-active .custom-cursor-dot {
  background-color: #1D4ED8;
  transform: translate(-50%, -50%) scale(1.2);
}

/* Click state on mouse press */
.custom-cursor.cursor-clicking .custom-cursor-ring {
  width: 28px;
  height: 28px;
  background-color: rgba(37, 99, 235, 0.2);
}

.custom-cursor.cursor-clicking .custom-cursor-dot {
  transform: translate(-50%, -50%) scale(0.8);
}

/* Hide custom cursor completely on touch/mobile devices */
@media (pointer: coarse) {
  .custom-cursor,
  .custom-cursor-dot,
  .custom-cursor-ring {
    display: none !important;
  }
}'''

# Normalize newlines for replacement
if old_css in css:
    css = css.replace(old_css, new_css)
    with open('css/style.css', 'w', encoding='utf-8') as f:
        f.write(css)
    print("Updated css/style.css successfully!")
elif old_css.replace('\r\n', '\n') in css.replace('\r\n', '\n'):
    # try normalized
    css_norm = css.replace('\r\n', '\n')
    css_norm = css_norm.replace(old_css.replace('\r\n', '\n'), new_css)
    with open('css/style.css', 'w', encoding='utf-8') as f:
        f.write(css_norm)
    print("Updated css/style.css (with normalized newlines) successfully!")
else:
    print("Could not find exact block in css/style.css")

# Update js/interactions.js
with open('js/interactions.js', 'r', encoding='utf-8') as f:
    js = f.read()

import re
old_func_pattern = re.compile(r'/\*\*\s*\*\s*1\.\s*Custom Trailing Animated Cursor[\s\S]*?function initCustomCursor\(\)\s*\{[\s\S]*?\n\}', re.MULTILINE)

new_func = '''/**
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
}'''

if old_func_pattern.search(js):
    js = old_func_pattern.sub(new_func, js, count=1)
    with open('js/interactions.js', 'w', encoding='utf-8') as f:
        f.write(js)
    print("Updated js/interactions.js successfully!")
else:
    print("Could not match old initCustomCursor function in js/interactions.js")
