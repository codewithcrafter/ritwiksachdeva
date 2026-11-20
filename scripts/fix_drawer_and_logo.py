# -*- coding: utf-8 -*-
"""
Fix Header, Mobile Drawer Leaking on Desktop, Brand Logo, and About Page UI.
"""
import os
import re

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

# 1. Update css/style.css with the exact complete Navigation & Brand Logo & Mobile Drawer
with open("css/style.css", "r", encoding="utf-8") as f:
    css = f.read()

NAV_AND_BRAND_CSS = """/* ==========================================================================
   5. NAVIGATION (CREATIVE GROWTH LAB HEADER)
   ========================================================================== */
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: var(--header-height);
  z-index: 1000;
  background: rgba(255, 255, 255, 0.94);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 2px solid var(--border-strong);
  transition: height var(--transition-fast), background-color var(--transition-fast), box-shadow var(--transition-fast);
}

.site-header.scrolled {
  height: 72px;
  background: rgba(255, 255, 255, 0.98);
  box-shadow: 0 4px 20px rgba(23, 23, 23, 0.06);
}

.nav-container {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  height: 100%;
}

/* Brand Logo & Monogram */
.brand-logo {
  display: flex !important;
  align-items: center !important;
  gap: 14px !important;
  text-decoration: none !important;
  color: var(--text-primary) !important;
  flex-shrink: 0;
}

.brand-monogram {
  width: 44px;
  height: 44px;
  background: #171717;
  color: var(--acid-lime) !important;
  border: 1px solid #171717;
  border-radius: var(--radius-sm);
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-family: var(--font-display) !important;
  font-weight: 700 !important;
  font-size: 1.05rem !important;
  letter-spacing: -0.02em;
  box-shadow: 2px 2px 0px var(--cobalt-blue);
  transition: all var(--transition-fast);
  flex-shrink: 0;
}

.brand-logo:hover .brand-monogram {
  background: var(--cobalt-blue);
  color: #FFFFFF !important;
  box-shadow: 3px 3px 0px var(--acid-lime);
  transform: translate(-1px, -1px);
}

.brand-info {
  display: flex !important;
  flex-direction: column !important;
}

.brand-name {
  font-family: var(--font-display) !important;
  line-height: 1.15 !important;
  font-size: 1.18rem !important;
  font-weight: 700 !important;
  color: var(--text-primary) !important;
  letter-spacing: -0.03em;
}

.brand-title {
  font-size: 0.72rem !important;
  font-family: var(--font-mono) !important;
  text-transform: uppercase !important;
  letter-spacing: 0.12em !important;
  color: var(--cobalt-blue) !important;
  font-weight: 700 !important;
}

/* Desktop Navigation */
.desktop-nav {
  display: flex !important;
  align-items: center !important;
  gap: 32px !important;
}

.nav-links {
  display: flex !important;
  align-items: center !important;
  gap: 28px !important;
  list-style: none !important;
  margin: 0 !important;
  padding: 0 !important;
}

.nav-item {
  position: relative;
  list-style: none;
}

.nav-link {
  font-family: var(--font-display);
  font-size: 0.96rem;
  font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  padding: 8px 0;
  position: relative;
  transition: color var(--transition-fast);
  display: flex;
  align-items: center;
  gap: 6px;
}

.nav-link:hover,
.nav-link.active {
  color: var(--cobalt-blue);
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0%;
  height: 2px;
  background: var(--cobalt-blue);
  transition: width var(--transition-fast);
}

.nav-link:hover::after,
.nav-link.active::after {
  width: 100%;
}

.dropdown-arrow {
  transition: transform var(--transition-fast);
}

.nav-item-has-dropdown {
  position: relative;
}

.nav-item-has-dropdown:hover .dropdown-arrow {
  transform: rotate(180deg);
}

/* 2-Column Creative Growth Lab Dropdown Menu */
.nav-dropdown-menu {
  position: absolute;
  top: calc(100% + 14px);
  left: 50%;
  transform: translateX(-50%) translateY(10px);
  width: 660px;
  background: #FFFFFF;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 22px;
  box-shadow: 6px 6px 0px #171717;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.22s ease, transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.22s;
  z-index: 1050;
  pointer-events: none;
}

.nav-item-has-dropdown:hover .nav-dropdown-menu,
.nav-item-has-dropdown:focus-within .nav-dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateX(-50%) translateY(0);
  pointer-events: auto;
}

.nav-dropdown-menu::before {
  content: '';
  position: absolute;
  top: -16px;
  left: 0;
  right: 0;
  height: 16px;
}

.nav-dropdown-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 12px;
  margin-bottom: 14px;
  border-bottom: 1px solid var(--border-color);
}

.dropdown-header-title {
  font-family: var(--font-display);
  font-size: 0.88rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text-primary);
}

.dropdown-header-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  background: var(--acid-lime);
  color: #171717;
  border: 1px solid #171717;
  padding: 2px 10px;
  border-radius: var(--radius-pill);
}

.nav-dropdown-list {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px 16px;
  max-height: 380px;
  overflow-y: auto;
  padding-right: 4px;
}

.nav-dropdown-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  padding: 8px 10px;
  border-radius: var(--radius-sm);
  border: 1px solid transparent;
  text-decoration: none;
  transition: all var(--transition-fast);
}

.nav-dropdown-item:hover {
  background: var(--bg-secondary);
  border-color: var(--border-strong);
  box-shadow: 2px 2px 0px #171717;
  transform: translate(-1px, -1px);
}

.dropdown-item-num {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: var(--cobalt-blue);
  background: var(--cobalt-light);
  padding: 2px 6px;
  border-radius: 4px;
  flex-shrink: 0;
  margin-top: 2px;
}

.dropdown-item-body {
  display: flex;
  flex-direction: column;
}

.dropdown-item-title {
  font-family: var(--font-display);
  font-size: 0.86rem;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.25;
  transition: color var(--transition-fast);
}

.nav-dropdown-item:hover .dropdown-item-title {
  color: var(--cobalt-blue);
}

.dropdown-item-desc {
  font-size: 0.74rem;
  color: var(--text-secondary);
  line-height: 1.35;
  margin-top: 2px;
}

.nav-dropdown-footer {
  margin-top: 14px;
  padding-top: 12px;
  border-top: 1px solid var(--border-color);
  display: flex;
  justify-content: flex-end;
}

.dropdown-view-all {
  font-family: var(--font-display);
  font-size: 0.84rem;
  font-weight: 700;
  color: var(--cobalt-blue);
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: transform var(--transition-fast);
}

.dropdown-view-all:hover {
  transform: translateX(4px);
  color: var(--cobalt-hover);
}

/* Mobile Nav Toggle */
.mobile-nav-toggle,
.mobile-toggle {
  display: none;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 6px;
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  box-shadow: 2px 2px 0px #171717;
  padding: 10px;
  cursor: pointer;
  z-index: 1005;
}

.hamburger-line,
.mobile-toggle span {
  display: block;
  width: 100%;
  height: 2px;
  background-color: var(--text-primary);
  transition: all var(--transition-fast);
}

.mobile-nav-toggle.is-active .hamburger-line:nth-child(1),
.mobile-toggle.active span:nth-child(1) {
  transform: translateY(8px) rotate(45deg);
}
.mobile-nav-toggle.is-active .hamburger-line:nth-child(2),
.mobile-toggle.active span:nth-child(2) {
  opacity: 0;
}
.mobile-nav-toggle.is-active .hamburger-line:nth-child(3),
.mobile-toggle.active span:nth-child(3) {
  transform: translateY(-8px) rotate(-45deg);
}

/* ==========================================================================
   MOBILE DRAWER (STRICTLY HIDDEN ON DESKTOP!)
   ========================================================================== */
.mobile-drawer {
  position: fixed;
  inset: 0;
  background: #FFFFFF;
  z-index: 99999;
  display: none !important;
  flex-direction: column;
  padding: calc(var(--header-height) + 24px) 24px 36px;
  transform: translateX(100%);
  transition: transform var(--transition-smooth);
  overflow-y: auto;
}

@media (max-width: 1024px) {
  .desktop-nav {
    display: none !important;
  }
  .mobile-nav-toggle,
  .mobile-toggle {
    display: flex !important;
  }
  .mobile-drawer {
    display: flex !important;
  }
  .mobile-drawer.is-open,
  .mobile-drawer.open {
    transform: translateX(0);
  }
}

.mobile-links {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 32px;
}

.mobile-link {
  font-family: var(--font-display);
  font-size: 1.45rem;
  font-weight: 700;
  color: var(--text-primary);
  text-decoration: none;
  padding: 8px 0;
  border-bottom: 1px solid var(--border-color);
}

.mobile-link:hover,
.mobile-link.active {
  color: var(--cobalt-blue);
}

.mobile-nav-item-dropdown {
  display: flex;
  flex-direction: column;
}

.mobile-dropdown-header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.mobile-submenu-btn {
  background: none;
  border: none;
  padding: 8px;
  color: var(--text-primary);
  cursor: pointer;
}

.mobile-submenu {
  display: none;
  flex-direction: column;
  gap: 10px;
  padding: 12px 0 12px 16px;
  border-left: 2px solid var(--border-color);
  margin: 8px 0 16px 8px;
}

.mobile-submenu.is-open,
.mobile-submenu.open {
  display: flex;
}

.mobile-sublink {
  font-size: 0.95rem;
  font-weight: 500;
  color: var(--text-secondary);
  text-decoration: none;
  padding: 4px 0;
}

.mobile-sublink:hover {
  color: var(--cobalt-blue);
}

.mobile-drawer-footer {
  margin-top: auto;
  padding-top: 24px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
"""

# Replace navigation and header section completely
css = re.sub(
    r'/\* ==========================================================================\s*5\. NAVIGATION.*?(?=/\* ==========================================================================\s*6\. CREATIVE CTA BUTTONS)',
    NAV_AND_BRAND_CSS + "\n\n",
    css,
    flags=re.DOTALL
)

# Custom Cursor initial opacity fix
css = re.sub(
    r'\.custom-cursor-dot\s*\{([^}]*)\}',
    r'''.custom-cursor-dot {
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
}''',
    css
)

css = re.sub(
    r'\.custom-cursor-ring\s*\{([^}]*)\}',
    r'''.custom-cursor-ring {
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
}''',
    css
)

with open("css/style.css", "w", encoding="utf-8") as f:
    f.write(css)

print("Fixed css/style.css with proper Brand Logo, Desktop Nav, and Mobile Drawer hiding!")

# 2. Update js/interactions.js to ensure cursor becomes visible upon first mouse movement
with open("js/interactions.js", "r", encoding="utf-8") as f:
    js = f.read()

if "cursorDot.style.opacity = '1';" not in js:
    js = js.replace(
        "cursorDot.style.left = `${mouseX}px`;",
        "cursorDot.style.opacity = '1';\n    cursorRing.style.opacity = '1';\n    cursorDot.style.left = `${mouseX}px`;"
    )
    with open("js/interactions.js", "w", encoding="utf-8") as f:
        f.write(js)
    print("Updated js/interactions.js with cursor initial visibility handler!")

# 3. Update css/responsive.css to strictly hide mobile drawer on >= 1025px
RESPONSIVE_FIX = """/* ==========================================================================
   RESPONSIVE DESIGN & MOBILE OPTIMIZATIONS (Creative Growth Lab)
   ========================================================================== */

@media (min-width: 1025px) {
  .mobile-drawer {
    display: none !important;
  }
  .mobile-nav-toggle,
  .mobile-toggle {
    display: none !important;
  }
  .desktop-nav {
    display: flex !important;
  }
}

@media (max-width: 1024px) {
  :root {
    --header-height: 72px;
    --section-spacing: 76px;
  }

  .desktop-nav {
    display: none !important;
  }

  .mobile-nav-toggle,
  .mobile-toggle {
    display: flex !important;
  }

  .mobile-drawer {
    display: flex !important;
  }

  .hp-hero-editorial-wrap,
  .arch-spread-layout,
  .rs-ecom-grid,
  .about-preview-grid {
    grid-template-columns: 1fr !important;
    gap: 44px;
  }

  .hp-service-slab {
    grid-template-columns: 1fr;
    gap: 22px;
  }

  .hp-slab-action {
    justify-content: flex-start;
  }

  .footer-grid {
    grid-template-columns: 1fr 1fr;
    gap: 40px;
  }

  .services-metrics-strip {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  :root {
    --header-height: 66px;
    --section-spacing: 60px;
  }

  .hp-hero-stats-ledger,
  .arch-ledger-grid,
  .arch-kpi-quad,
  .hp-framework-grid,
  .hp-queries-grid,
  .footer-grid,
  .services-metrics-strip,
  .expertise-grid {
    grid-template-columns: 1fr !important;
    gap: 18px;
  }

  .hp-floating-meta-chip,
  .about-badge-experience {
    position: static;
    margin-top: 14px;
  }

  .hp-cta-editorial-box,
  .cta-box {
    padding: 40px 24px;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 18px;
    text-align: center;
  }
}
"""

with open("css/responsive.css", "w", encoding="utf-8") as f:
    f.write(RESPONSIVE_FIX)

print("Updated css/responsive.css with strict media query controls!")
