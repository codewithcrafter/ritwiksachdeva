import os

# 1. GENERATE css/style.css
style_css = """/* ==========================================================================
   RITWIK SACHDEVA — STRATEGIC MANAGEMENT CONSULTANCY DESIGN SYSTEM
   Aesthetic: Swiss Editorial Architecture / International Corporate Advisory
   Visual Identity: Warm off-white (#F7F7F4), Pure white (#FFFFFF),
                    Deep charcoal (#171A1D), Secondary grey (#777C80),
                    Muted bronze accent (#B28A55)
   Typography: Newsreader (Editorial Serif) + Plus Jakarta Sans (Clean Swiss Neo-Grotesque)
               + JetBrains Mono (Technical Metadata & Indices)
   ========================================================================== */

@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,400;1,6..72,600&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap');

/* ==========================================================================
   1. TOKENS & ARCHITECTURAL FOUNDATIONS
   ========================================================================== */
:root {
  /* Restrained Corporate Palette */
  --bg-canvas: #F7F7F4;          /* Warm off-white canvas */
  --bg-primary: #F7F7F4;         /* Canonical background */
  --bg-surface: #FFFFFF;         /* Pure white structural card */
  --bg-secondary: #FFFFFF;       /* Elevated white surface */
  --bg-subtle: #EFEFEA;          /* Architectural secondary surface */
  --bg-beige: #EFEFEA;
  --bg-dark: #171A1D;            /* Deep charcoal */
  --bg-noir: #171A1D;            /* Monolith deep charcoal */
  --bg-noir-surface: #22262B;

  /* Typography Colors */
  --text-primary: #171A1D;       /* Deep charcoal headline & high contrast */
  --text-secondary: #4A4F54;     /* Highly readable charcoal-grey body */
  --text-muted: #777C80;         /* Secondary grey metadata */
  --text-subtle: #969B9E;        /* Annotations & rules */
  --text-inverse: #F7F7F4;       /* Warm off-white on dark */

  /* Muted Bronze Signature Accent */
  --accent-bronze: #B28A55;
  --accent-bronze-hover: #987242;
  --accent-bronze-light: rgba(178, 138, 85, 0.08);
  --accent-bronze-subtle: rgba(178, 138, 85, 0.16);
  --accent-primary: #B28A55;
  --accent-secondary: #171A1D;
  --accent-hover: #987242;
  --accent-light: rgba(178, 138, 85, 0.08);

  /* Swiss Hairlines & Rule Lines */
  --border-color: #E5E5DF;
  --border-subtle: #ECECE6;
  --border-strong: #D5D5CE;
  --border-dark: rgba(255, 255, 255, 0.12);
  --border-accent: rgba(178, 138, 85, 0.4);

  /* Status Tokens */
  --success: #2B6E4E;
  --warning: #B28A55;
  --error: #A83232;

  /* Typographic Hierarchy */
  --font-serif: 'Newsreader', Georgia, 'Times New Roman', serif;
  --font-display: 'Newsreader', Georgia, serif;
  --font-heading: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-mono: 'JetBrains Mono', SFMono-Regular, Menlo, Monaco, Consolas, monospace;

  /* Geometry: Architectural, Minimal Radii */
  --radius-xs: 0px;
  --radius-sm: 2px;
  --radius-md: 3px;
  --radius-lg: 4px;
  --radius-xl: 4px;
  --radius-pill: 2px;
  --radius-full: 9999px;

  /* Structural Shadows (Flat, Minimal, No Neon Glare) */
  --shadow-sm: 0 1px 2px rgba(23, 26, 29, 0.03);
  --shadow-card: 0 1px 3px rgba(23, 26, 29, 0.04), 0 4px 12px rgba(23, 26, 29, 0.02);
  --shadow-hover: 0 2px 8px rgba(23, 26, 29, 0.06), 0 8px 24px rgba(23, 26, 29, 0.04);
  --shadow-navbar: 0 1px 4px rgba(23, 26, 29, 0.04);
  --shadow-float: 0 8px 28px rgba(23, 26, 29, 0.08);

  /* Dimensions */
  --container-max: 1240px;
  --container-narrow: 880px;
  --header-height: 80px;
  --section-spacing: 104px;
  --section-spacing-sm: 64px;

  /* Transitions */
  --transition-fast: 0.18s ease;
  --transition-smooth: 0.28s ease;
}

/* ==========================================================================
   2. GLOBAL RESET & BASE RULES
   ========================================================================== */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  font-size: 16px;
  scroll-behavior: smooth;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering: optimizeLegibility;
  background-color: var(--bg-canvas);
  color: var(--text-primary);
}

body {
  font-family: var(--font-body);
  font-size: 16px;
  line-height: 1.7;
  color: var(--text-secondary);
  background-color: var(--bg-canvas);
  overflow-x: hidden;
  position: relative;
  min-height: 100vh;
}

/* Scrollbar */
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-track {
  background: var(--bg-canvas);
}
::-webkit-scrollbar-thumb {
  background: var(--border-strong);
}
::-webkit-scrollbar-thumb:hover {
  background: var(--accent-bronze);
}

::selection {
  background: var(--accent-bronze);
  color: #FFFFFF;
}

/* ==========================================================================
   3. SWISS EDITORIAL TYPOGRAPHY
   ========================================================================== */
h1, h2, h3, h4, h5, h6 {
  color: var(--text-primary);
  line-height: 1.15;
  font-weight: 600;
  letter-spacing: -0.02em;
}

h1 {
  font-family: var(--font-serif);
  font-size: clamp(2.4rem, 4.4vw, 3.8rem);
  line-height: 1.1;
  font-weight: 600;
  letter-spacing: -0.025em;
}

h2 {
  font-family: var(--font-serif);
  font-size: clamp(1.9rem, 3.2vw, 2.7rem);
  line-height: 1.15;
  font-weight: 600;
  letter-spacing: -0.02em;
}

h3 {
  font-family: var(--font-heading);
  font-size: clamp(1.2rem, 1.8vw, 1.55rem);
  line-height: 1.25;
  font-weight: 650;
  letter-spacing: -0.015em;
}

h4 {
  font-family: var(--font-heading);
  font-size: 1.12rem;
  line-height: 1.35;
  font-weight: 650;
}

p {
  margin-bottom: 1.25rem;
  max-width: 720px;
}

p:last-child {
  margin-bottom: 0;
}

a {
  color: inherit;
  text-decoration: none;
  transition: color var(--transition-fast), border-color var(--transition-fast);
}

img {
  max-width: 100%;
  height: auto;
  display: block;
}

ul, ol {
  list-style: none;
}

button, input, textarea, select {
  font-family: inherit;
  font-size: inherit;
  color: inherit;
}

/* Swiss Metadata & Kicker Stamps */
.arch-tag, .section-tag, .kicker-stamp {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: var(--accent-bronze);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 16px;
}

/* Clean divider rule */
.swiss-rule {
  height: 1px;
  background: var(--border-color);
  border: 0;
  margin: 36px 0;
}

/* ==========================================================================
   4. STRUCTURAL CONTAINERS
   ========================================================================== */
.container {
  width: 100%;
  max-width: var(--container-max);
  margin-left: auto;
  margin-right: auto;
  padding-left: clamp(20px, 4vw, 44px);
  padding-right: clamp(20px, 4vw, 44px);
}

.container-narrow {
  max-width: var(--container-narrow);
}

.section {
  padding-top: var(--section-spacing);
  padding-bottom: var(--section-spacing);
  position: relative;
  border-bottom: 1px solid var(--border-color);
}

.section-sm {
  padding-top: var(--section-spacing-sm);
  padding-bottom: var(--section-spacing-sm);
}

.section-bg-alt {
  background-color: var(--bg-surface);
}

.section-bg-white {
  background-color: var(--bg-surface);
}

/* Minimal Reading Progress Indicator */
#scroll-progress {
  position: fixed;
  top: 0;
  left: 0;
  height: 2px;
  width: 0%;
  background: var(--accent-bronze);
  z-index: 9999;
  transition: width 0.1s linear;
}

/* Discreet Background Layer (No Blurs or Gimmicks) */
.bg-ambient-layer {
  display: none;
}

/* ==========================================================================
   5. CORPORATE SWISS HEADER & NAVIGATION
   ========================================================================== */
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: var(--header-height);
  z-index: 1000;
  background-color: var(--bg-surface);
  border-bottom: 1px solid var(--border-color);
  transition: height var(--transition-fast), background-color var(--transition-fast), box-shadow var(--transition-fast);
}

.site-header.scrolled {
  height: 70px;
  box-shadow: var(--shadow-navbar);
}

.nav-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}

/* Corporate Brand Monogram */
.brand-logo {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  color: var(--text-primary);
}

.brand-monogram {
  width: 38px;
  height: 38px;
  background: var(--text-primary);
  border: 1px solid var(--accent-bronze);
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: 0.95rem;
  letter-spacing: -0.02em;
  transition: background-color var(--transition-fast);
}

.brand-logo:hover .brand-monogram {
  background: var(--accent-bronze);
}

.brand-info {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-family: var(--font-heading);
  line-height: 1.15;
  font-size: 1.12rem;
  font-weight: 700;
  color: var(--text-primary);
  letter-spacing: -0.02em;
}

.brand-title {
  font-size: 0.7rem;
  font-family: var(--font-mono);
  font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.12em;
}

/* Navigation Links */
.desktop-nav {
  display: flex;
  align-items: center;
  gap: 36px;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 32px;
}

.nav-item {
  position: relative;
}

.nav-link {
  font-size: 0.92rem;
  font-weight: 600;
  color: var(--text-secondary);
  padding: 8px 0;
  position: relative;
  text-decoration: none;
  transition: color var(--transition-fast);
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--text-primary);
  transition: width var(--transition-fast);
}

.nav-link:hover {
  color: var(--text-primary);
}

.nav-link:hover::after {
  width: 100%;
}

.nav-link.active {
  color: var(--text-primary);
  font-weight: 700;
}

.nav-link.active::after {
  width: 100%;
  background: var(--accent-bronze);
}

/* Structured Swiss Mega Dropdown */
.nav-item-has-dropdown {
  position: relative;
}

.dropdown-toggle {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
}

.dropdown-arrow {
  transition: transform var(--transition-fast);
}

.nav-item-has-dropdown:hover .dropdown-arrow,
.nav-item-has-dropdown:focus-within .dropdown-arrow {
  transform: rotate(180deg);
  color: var(--accent-bronze);
}

.nav-dropdown-menu {
  position: absolute;
  top: calc(100% + 14px);
  left: 50%;
  transform: translateX(-50%) translateY(8px);
  width: 580px;
  max-width: 94vw;
  max-height: calc(88vh - 40px);
  display: flex;
  flex-direction: column;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-float);
  padding: 20px 20px 14px;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: opacity var(--transition-fast), transform var(--transition-fast), visibility var(--transition-fast);
  z-index: 1200;
}

.nav-dropdown-menu::before {
  content: '';
  position: absolute;
  top: -16px;
  left: 0;
  right: 0;
  height: 16px;
}

.nav-item-has-dropdown:hover .nav-dropdown-menu,
.nav-item-has-dropdown:focus-within .nav-dropdown-menu {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
  transform: translateX(-50%) translateY(0);
}

.nav-dropdown-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 4px 6px 14px;
  border-bottom: 1px solid var(--border-color);
  margin-bottom: 8px;
  flex-shrink: 0;
}

.dropdown-header-title {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: var(--text-muted);
}

.dropdown-header-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-bronze);
  background: var(--accent-bronze-light);
  padding: 3px 10px;
  border-radius: var(--radius-sm);
  border: 1px solid var(--accent-bronze-subtle);
}

.nav-dropdown-list {
  display: flex;
  flex-direction: column;
  gap: 2px;
  overflow-y: auto;
  max-height: calc(88vh - 120px);
  overscroll-behavior: contain;
  padding-right: 4px;
}

.nav-dropdown-list::-webkit-scrollbar {
  width: 4px;
}
.nav-dropdown-list::-webkit-scrollbar-thumb {
  background: var(--border-color);
  border-radius: 2px;
}

.nav-dropdown-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 10px 12px;
  border-radius: var(--radius-sm);
  text-decoration: none;
  transition: background-color var(--transition-fast), border-color var(--transition-fast);
  border: 1px solid transparent;
}

.nav-dropdown-item:hover {
  background-color: var(--bg-canvas);
  border-color: var(--border-color);
}

.dropdown-item-num {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  color: var(--accent-bronze);
  line-height: 1;
  margin-top: 3px;
  flex-shrink: 0;
}

.dropdown-item-body {
  flex: 1;
}

.dropdown-item-title {
  font-family: var(--font-heading);
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.3;
  margin-bottom: 2px;
  transition: color var(--transition-fast);
}

.nav-dropdown-item:hover .dropdown-item-title {
  color: var(--accent-bronze);
}

.dropdown-item-desc {
  font-size: 0.8rem;
  color: var(--text-muted);
  line-height: 1.35;
}

.nav-dropdown-footer {
  margin-top: 10px;
  padding-top: 12px;
  border-top: 1px solid var(--border-color);
  text-align: center;
}

.dropdown-view-all {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 8px 14px;
  font-size: 0.85rem;
  font-weight: 700;
  color: var(--text-primary);
  text-decoration: none;
  transition: color var(--transition-fast);
}

.dropdown-view-all:hover {
  color: var(--accent-bronze);
}

/* Mobile Hamburger Toggle */
.mobile-nav-toggle {
  display: none;
  background: transparent;
  border: none;
  cursor: pointer;
  width: 44px;
  height: 44px;
  position: relative;
  z-index: 1100;
  align-items: center;
  justify-content: center;
  color: var(--text-primary);
}

.hamburger-line {
  display: block;
  width: 24px;
  height: 2px;
  background-color: var(--text-primary);
  transition: transform var(--transition-fast), opacity var(--transition-fast);
}

.hamburger-line:nth-child(2) {
  margin: 5px 0;
}

.mobile-nav-toggle.is-active .hamburger-line:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}
.mobile-nav-toggle.is-active .hamburger-line:nth-child(2) {
  opacity: 0;
}
.mobile-nav-toggle.is-active .hamburger-line:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}

/* Mobile Drawer */
.mobile-drawer {
  position: fixed;
  inset: 0;
  background-color: var(--bg-surface);
  z-index: 1050;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 48px 36px;
  transform: translateX(100%);
  transition: transform var(--transition-fast);
  pointer-events: none;
  overflow-y: auto;
}

.mobile-drawer.is-open {
  transform: translateX(0);
  pointer-events: auto;
}

.mobile-links {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-bottom: 36px;
}

.mobile-link {
  font-family: var(--font-serif);
  font-size: 1.85rem;
  font-weight: 600;
  color: var(--text-primary);
  text-decoration: none;
  transition: color var(--transition-fast);
  display: inline-block;
}

.mobile-link:hover,
.mobile-link.active {
  color: var(--accent-bronze);
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
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  width: 38px;
  height: 38px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-primary);
  cursor: pointer;
  transition: all var(--transition-fast);
}

.mobile-submenu-btn.is-expanded {
  transform: rotate(180deg);
  background: var(--text-primary);
  color: #FFFFFF;
}

.mobile-submenu {
  display: none;
  flex-direction: column;
  gap: 10px;
  padding: 14px 0 8px 16px;
  border-left: 2px solid var(--accent-bronze);
  margin: 10px 0 10px 8px;
}

.mobile-submenu.is-open {
  display: flex;
}

.mobile-sublink {
  font-size: 0.96rem;
  font-weight: 600;
  color: var(--text-secondary);
  text-decoration: none;
  padding: 4px 0;
  transition: color var(--transition-fast);
}

.mobile-sublink:hover,
.mobile-sublink.active {
  color: var(--accent-bronze);
}

.mobile-drawer-footer {
  border-top: 1px solid var(--border-color);
  padding-top: 24px;
  display: flex;
  flex-direction: column;
  gap: 14px;
}

/* ==========================================================================
   6. ARCHITECTURAL BUTTONS & ACTIONS
   ========================================================================== */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 12px 26px;
  border-radius: var(--radius-sm);
  font-family: var(--font-heading);
  font-size: 0.92rem;
  font-weight: 650;
  line-height: 1;
  cursor: pointer;
  border: 1px solid transparent;
  text-decoration: none;
  transition: background-color var(--transition-fast), border-color var(--transition-fast), color var(--transition-fast);
  position: relative;
  text-align: center;
  letter-spacing: 0.01em;
}

.btn-primary {
  background: var(--text-primary);
  color: #FFFFFF !important;
  border-color: var(--text-primary);
}

.btn-primary:hover {
  background: var(--accent-bronze);
  border-color: var(--accent-bronze);
  color: #FFFFFF !important;
}

.btn-secondary {
  background-color: var(--bg-surface);
  color: var(--text-primary);
  border-color: var(--border-color);
}

.btn-secondary:hover {
  border-color: var(--text-primary);
  color: var(--text-primary);
}

.btn-outline {
  background-color: transparent;
  color: var(--text-primary);
  border-color: var(--text-primary);
}

.btn-outline:hover {
  background-color: var(--text-primary);
  color: #FFFFFF;
}

.btn-bronze {
  background-color: var(--accent-bronze);
  color: #FFFFFF !important;
  border-color: var(--accent-bronze);
}

.btn-bronze:hover {
  background-color: var(--accent-bronze-hover);
  border-color: var(--accent-bronze-hover);
}

.btn-sm {
  padding: 9px 18px;
  font-size: 0.84rem;
}

.btn-lg {
  padding: 15px 32px;
  font-size: 1rem;
}

.btn-icon-right svg {
  transition: transform var(--transition-fast);
}

.btn:hover .btn-icon-right svg {
  transform: translateX(3px);
}

/* ==========================================================================
   7. CORPORATE SWISS COLOPHON & FOOTER
   ========================================================================== */
.site-footer {
  background-color: var(--bg-noir);
  color: #A0A5AA;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  padding: 88px 0 36px 0;
  position: relative;
}

.site-footer a {
  color: #A0A5AA;
  text-decoration: none;
  transition: color var(--transition-fast);
}

.site-footer a:hover {
  color: #FFFFFF;
}

.footer-grid {
  display: grid;
  grid-template-columns: 1.4fr 0.9fr 1.3fr 1fr;
  gap: 48px;
  margin-bottom: 64px;
}

.footer-brand-statement {
  font-size: 0.92rem;
  color: #8C9298;
  line-height: 1.7;
  margin-top: 18px;
  max-width: 360px;
}

.site-footer .brand-logo {
  color: #FFFFFF;
}

.site-footer .brand-monogram {
  background: rgba(255, 255, 255, 0.08);
  border-color: var(--accent-bronze);
}

.site-footer .brand-name {
  color: #FFFFFF;
}

.site-footer .brand-title {
  color: #8C9298;
}

.footer-heading {
  font-family: var(--font-mono);
  font-size: 0.78rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: #FFFFFF;
  margin-bottom: 22px;
}

.footer-links {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer-link {
  font-size: 0.9rem;
  display: inline-block;
  transition: color var(--transition-fast);
}

.footer-link:hover {
  color: var(--accent-bronze);
}

.footer-social-row {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}

.social-icon-btn {
  width: 38px;
  height: 38px;
  border-radius: var(--radius-sm);
  background-color: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #CBD0D5;
  transition: background-color var(--transition-fast), border-color var(--transition-fast), color var(--transition-fast);
}

.social-icon-btn:hover {
  background: var(--accent-bronze);
  border-color: var(--accent-bronze);
  color: #FFFFFF;
}

.footer-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  padding-top: 32px;
  font-size: 0.84rem;
  color: #777C80;
  flex-wrap: wrap;
  gap: 16px;
}

.back-to-top-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.12);
  padding: 6px 14px;
  border-radius: var(--radius-sm);
  color: #CBD0D5;
  font-family: var(--font-mono);
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.back-to-top-btn:hover {
  border-color: var(--accent-bronze);
  color: #FFFFFF;
  background: var(--accent-bronze);
}

/* ==========================================================================
   8. FORMS & CONSULTANCY INQUIRY
   ========================================================================== */
.contact-layout-grid {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: 52px;
  align-items: start;
}

.contact-info-card {
  background-color: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 44px;
  box-shadow: var(--shadow-card);
}

.contact-direct-items {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin: 32px 0;
}

.contact-direct-item {
  display: flex;
  align-items: flex-start;
  gap: 16px;
}

.contact-icon-box {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-bronze);
  flex-shrink: 0;
}

.contact-item-label {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--text-muted);
  font-weight: 600;
  margin-bottom: 2px;
}

.contact-item-value {
  font-size: 1.02rem;
  font-weight: 650;
  color: var(--text-primary);
}

.contact-item-value a:hover {
  color: var(--accent-bronze);
}

.form-card {
  background-color: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 44px;
  box-shadow: var(--shadow-card);
}

.form-group {
  margin-bottom: 22px;
  position: relative;
}

.form-label {
  display: block;
  font-size: 0.88rem;
  font-weight: 650;
  color: var(--text-primary);
  margin-bottom: 8px;
}

.form-label .required-mark {
  color: var(--accent-bronze);
}

.form-control {
  width: 100%;
  background-color: var(--bg-canvas);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 13px 16px;
  color: var(--text-primary);
  font-size: 0.94rem;
  transition: border-color var(--transition-fast), background-color var(--transition-fast);
}

.form-control:focus {
  outline: none;
  background-color: #FFFFFF;
  border-color: var(--accent-bronze);
}

.form-control.is-invalid {
  border-color: var(--error);
  background-color: #FDF4F4;
}

.form-error-msg {
  display: none;
  font-size: 0.78rem;
  color: var(--error);
  margin-top: 5px;
}

.form-control.is-invalid + .form-error-msg {
  display: block;
}

.form-row-2col {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

textarea.form-control {
  resize: vertical;
  min-height: 130px;
}

/* ==========================================================================
   9. MODALS & GLOBAL NOTIFICATIONS
   ========================================================================== */
.modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(23, 26, 29, 0.6);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  opacity: 0;
  pointer-events: none;
  transition: opacity var(--transition-fast);
}

.modal-overlay.is-open {
  opacity: 1;
  pointer-events: auto;
}

.modal-dialog {
  background-color: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 48px 40px;
  max-width: 500px;
  width: 100%;
  text-align: center;
  box-shadow: var(--shadow-float);
}

.modal-icon-circle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: rgba(43, 110, 78, 0.1);
  border: 1px solid var(--success);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--success);
  margin: 0 auto 20px auto;
}
"""

with open('css/style.css', 'w', encoding='utf-8') as f:
    f.write(style_css)
print("css/style.css written successfully")

# 2. GENERATE css/home-live.css
home_live_css = """/* ==========================================================================
   HOMEPAGE ARCHITECTURAL STYLESHEET (home-live.css)
   Swiss Editorial Management Consultancy Architecture
   Palette: Warm off-white (#F7F7F4), Pure white (#FFFFFF),
            Deep charcoal (#171A1D), Secondary grey (#777C80),
            Muted bronze accent (#B28A55)
   ========================================================================== */

/* --- HERO EDITORIAL MONOLITH --- */
#hero {
  padding: calc(var(--header-height, 80px) + 48px) 0 88px;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
  position: relative;
}

#hero .hp-container {
  max-width: var(--container-max);
  margin: 0 auto;
  padding: 0 clamp(20px, 4vw, 44px);
}

.hp-hero-editorial-wrap {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: 56px;
  align-items: center;
}

.hp-hero-copy-column {
  display: flex;
  flex-direction: column;
}

.hp-hero-kicker-bar {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.hp-hero-kicker {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--accent-bronze);
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  padding: 5px 14px;
  border-radius: var(--radius-sm);
}

#hero .hp-h1 {
  font-family: var(--font-serif);
  font-size: clamp(2.4rem, 4.4vw, 3.8rem);
  font-weight: 600;
  line-height: 1.1;
  letter-spacing: -0.025em;
  color: var(--text-primary);
  margin: 0 0 24px;
}

#hero .hp-body {
  font-size: 1.08rem;
  line-height: 1.74;
  color: var(--text-secondary);
  margin-bottom: 32px;
  max-width: 620px;
}

.hp-hero-actions-row {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 48px;
}

.hp-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 14px 30px;
  border-radius: var(--radius-sm);
  font-family: var(--font-heading);
  font-size: 0.95rem;
  font-weight: 650;
  line-height: 1;
  text-decoration: none;
  cursor: pointer;
  transition: background-color var(--transition-fast), border-color var(--transition-fast), color var(--transition-fast);
}

.hp-btn-primary {
  background: var(--text-primary);
  color: #FFFFFF !important;
  border: 1px solid var(--text-primary);
}

.hp-btn-primary:hover {
  background: var(--accent-bronze);
  border-color: var(--accent-bronze);
  color: #FFFFFF !important;
}

/* Swiss Metrics Ledger inside Hero */
.hp-hero-stats-ledger {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  padding-top: 32px;
  border-top: 1px solid var(--border-color);
}

.hp-stat-ledger-item {
  display: flex;
  flex-direction: column;
}

.hp-stat-number {
  font-family: var(--font-serif);
  font-size: clamp(1.9rem, 2.8vw, 2.4rem);
  font-weight: 600;
  color: var(--text-primary);
  line-height: 1.1;
  margin-bottom: 4px;
  letter-spacing: -0.02em;
}

.hp-stat-label {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-weight: 600;
}

/* Hero Visual Architecture */
.hp-hero-visual-column {
  position: relative;
}

.hp-visual-composition-frame {
  position: relative;
  border-radius: var(--radius-md);
  border: 1px solid var(--border-color);
  background: var(--bg-surface);
  box-shadow: var(--shadow-card);
  padding: 20px;
}

.hp-visual-composition-frame img {
  width: 100%;
  height: auto;
  max-height: 480px;
  object-fit: contain;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
}

.hp-floating-meta-chip {
  position: absolute;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 10px 16px;
  box-shadow: var(--shadow-sm);
  z-index: 2;
}

.hp-chip-top {
  top: 16px;
  right: -12px;
}

.hp-chip-bottom {
  bottom: 16px;
  left: -12px;
}

.hp-chip-title {
  font-family: var(--font-mono);
  font-size: 0.68rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--accent-bronze);
  margin-bottom: 2px;
}

.hp-chip-val {
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: 0.88rem;
  color: var(--text-primary);
}

/* --- SECTION 1: WHAT A DIGITAL MARKETING CONSULTANT DOES --- */
#what-consultant-does {
  padding: 96px 0;
  background-color: var(--bg-surface);
  border-bottom: 1px solid var(--border-color);
}

.arch-spread-layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: 56px;
  align-items: start;
}

.arch-spread-header {
  position: sticky;
  top: calc(var(--header-height, 80px) + 24px);
}

.arch-spread-index {
  font-family: var(--font-mono);
  font-size: 0.82rem;
  font-weight: 700;
  color: var(--accent-bronze);
  margin-bottom: 14px;
  display: block;
  letter-spacing: 0.12em;
}

.arch-spread-title {
  font-family: var(--font-serif);
  font-size: clamp(1.9rem, 3.2vw, 2.6rem);
  font-weight: 600;
  line-height: 1.15;
  letter-spacing: -0.02em;
  color: var(--text-primary);
  margin-bottom: 18px;
}

.arch-spread-body-wrap {
  display: flex;
  flex-direction: column;
  gap: 24px;
  padding: 40px;
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  border-left: 3px solid var(--accent-bronze);
}

.arch-spread-body-wrap p {
  font-size: 1.05rem;
  line-height: 1.74;
  color: var(--text-secondary);
  max-width: 100%;
}

.arch-spread-body-wrap p:first-child {
  font-size: 1.18rem;
  font-weight: 600;
  color: var(--text-primary);
  line-height: 1.6;
  border-bottom: 1px solid var(--border-color);
  padding-bottom: 22px;
}

/* --- SECTION 2: DIGITAL MARKETING SERVICES IN DELHI --- */
#services {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.arch-ledger-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 40px;
}

.arch-ledger-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 32px 30px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: var(--shadow-sm);
  text-decoration: none !important;
  color: inherit !important;
  transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.arch-ledger-card:hover {
  border-color: var(--accent-bronze);
  box-shadow: var(--shadow-hover);
}

.arch-card-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 18px;
}

.arch-card-coord {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: var(--accent-bronze);
  background: var(--accent-bronze-light);
  border: 1px solid var(--accent-bronze-subtle);
  padding: 3px 8px;
  border-radius: var(--radius-sm);
  letter-spacing: 0.08em;
}

.arch-card-icon-glyph {
  width: 38px;
  height: 38px;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-primary);
  transition: background-color var(--transition-fast), color var(--transition-fast);
}

.arch-ledger-card:hover .arch-card-icon-glyph {
  background: var(--accent-bronze);
  border-color: var(--accent-bronze);
  color: #FFFFFF;
}

.arch-card-title {
  font-family: var(--font-heading);
  font-size: 1.18rem;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.25;
  margin-bottom: 10px;
  transition: color var(--transition-fast);
}

.arch-ledger-card:hover .arch-card-title {
  color: var(--accent-bronze);
}

.arch-card-desc {
  font-size: 0.94rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* --- SECTION 3: WHO THIS IS FOR --- */
#who-for {
  padding: 96px 0;
  background-color: var(--bg-surface);
  border-bottom: 1px solid var(--border-color);
}

.arch-archetype-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 40px;
}

.arch-archetype-item {
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 28px 26px;
  display: flex;
  align-items: flex-start;
  gap: 16px;
  box-shadow: var(--shadow-sm);
  transition: border-color var(--transition-fast);
}

.arch-archetype-item:hover {
  border-color: var(--accent-bronze);
}

.arch-archetype-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-bronze);
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  padding: 3px 8px;
  border-radius: var(--radius-sm);
  flex-shrink: 0;
  margin-top: 2px;
}

.arch-archetype-item span {
  font-size: 0.98rem;
  line-height: 1.65;
  color: var(--text-secondary);
}

/* --- SECTION 4: CHOOSING A DIGITAL MARKETING CONSULTANT IN DELHI --- */
#choosing-consultant {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.arch-advisory-framework-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 48px 44px;
  box-shadow: var(--shadow-sm);
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.arch-advisory-framework-card p {
  font-size: 1.05rem;
  line-height: 1.74;
  color: var(--text-secondary);
  max-width: 100%;
}

.arch-advisory-framework-card p:first-child {
  font-size: 1.18rem;
  font-weight: 650;
  color: var(--text-primary);
  line-height: 1.62;
  border-bottom: 1px solid var(--border-color);
  padding-bottom: 20px;
}

/* --- SECTION 5: RESULTS-FOCUSED DIGITAL MARKETING --- */
#results-focused-marketing {
  padding: 96px 0;
  background-color: var(--bg-surface);
  border-bottom: 1px solid var(--border-color);
}

.arch-kpi-matrix-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 22px;
  margin-top: 40px;
}

.arch-kpi-card {
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 32px 26px;
  display: flex;
  flex-direction: column;
  border-top: 3px solid var(--text-primary);
  transition: border-color var(--transition-fast);
}

.arch-kpi-card:hover {
  border-top-color: var(--accent-bronze);
  background: #FFFFFF;
}

.arch-kpi-coord {
  font-family: var(--font-mono);
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--accent-bronze);
  margin-bottom: 14px;
}

.arch-kpi-title {
  font-family: var(--font-heading);
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 12px;
}

.arch-kpi-desc {
  font-size: 0.94rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* --- SECTION 6: TRUSTED BY BUSINESSES SEARCHING FOR --- */
#trusted-businesses-searching {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.arch-authority-ledger {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 42px 38px;
  box-shadow: var(--shadow-sm);
}

.arch-authority-ledger p {
  font-size: 1.04rem;
  line-height: 1.72;
  color: var(--text-secondary);
  max-width: 100%;
}

.arch-searches-cloud {
  margin-top: 22px;
  padding-top: 20px;
  border-top: 1px solid var(--border-color);
  font-family: var(--font-mono);
  font-size: 0.86rem;
  color: var(--text-primary);
  line-height: 1.75;
  font-weight: 500;
}

/* --- SECTION 7: FREQUENTLY ASKED QUESTIONS --- */
#dm-faq {
  padding: 96px 0;
  background-color: var(--bg-surface);
  border-bottom: 1px solid var(--border-color);
}

.arch-faq-list {
  max-width: 860px;
  margin: 40px auto 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.arch-faq-item {
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  overflow: hidden;
  transition: border-color var(--transition-fast);
}

.arch-faq-item:hover,
.arch-faq-item.active {
  border-color: var(--accent-bronze);
  background: #FFFFFF;
}

.arch-faq-question {
  width: 100%;
  padding: 20px 24px;
  background: transparent;
  border: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  cursor: pointer;
  text-align: left;
  color: var(--text-primary);
  font-family: var(--font-heading);
  font-size: 1.05rem;
  font-weight: 650;
  line-height: 1.35;
}

.arch-faq-coord {
  font-family: var(--font-mono);
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--accent-bronze);
  margin-right: 8px;
}

.arch-faq-toggle-icon {
  font-size: 1.25rem;
  font-weight: 400;
  color: var(--accent-bronze);
  transition: transform var(--transition-fast);
  line-height: 1;
}

.arch-faq-item.active .arch-faq-toggle-icon {
  transform: rotate(45deg);
  color: var(--text-primary);
}

.arch-faq-answer {
  display: none;
  padding: 0 24px 22px;
  color: var(--text-secondary);
  font-size: 0.98rem;
  line-height: 1.7;
  border-top: 1px solid var(--border-subtle);
}

.arch-faq-item.active .arch-faq-answer {
  display: block !important;
}

/* --- SECTION 8: EXECUTIVE BRIEFING CTA --- */
#cta-consultant-delhi {
  padding: 104px 0;
  background-color: var(--bg-noir);
  color: #FFFFFF;
  position: relative;
}

.arch-cta-monolith {
  max-width: 900px;
  margin: 0 auto;
  text-align: center;
}

.arch-cta-kicker {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--accent-bronze);
  margin-bottom: 20px;
}

.arch-cta-title {
  font-family: var(--font-serif);
  font-size: clamp(2rem, 3.8vw, 3.1rem);
  font-weight: 600;
  line-height: 1.15;
  letter-spacing: -0.025em;
  color: #FFFFFF;
  margin-bottom: 20px;
}

.arch-cta-text {
  font-size: 1.08rem;
  line-height: 1.72;
  color: #CBD0D5;
  max-width: 680px;
  margin: 0 auto 38px;
}

.arch-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 15px 36px;
  background: var(--accent-bronze);
  color: #FFFFFF !important;
  border-radius: var(--radius-sm);
  font-family: var(--font-heading);
  font-size: 0.98rem;
  font-weight: 650;
  text-decoration: none;
  border: 1px solid var(--accent-bronze);
  transition: background-color var(--transition-fast), border-color var(--transition-fast);
}

.arch-cta-btn:hover {
  background: var(--accent-bronze-hover);
  border-color: var(--accent-bronze-hover);
}

/* --- RESPONSIVE LAYOUTS --- */
@media (max-width: 992px) {
  .hp-hero-editorial-wrap {
    grid-template-columns: 1fr;
    gap: 40px;
  }
  .arch-spread-layout {
    grid-template-columns: 1fr;
    gap: 32px;
  }
  .arch-spread-header {
    position: static;
  }
  .arch-ledger-grid {
    grid-template-columns: 1fr;
  }
  .arch-archetype-grid {
    grid-template-columns: 1fr;
  }
  .arch-kpi-matrix-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  #hero, #what-consultant-does, #services, #who-for, #choosing-consultant,
  #results-focused-marketing, #trusted-businesses-searching, #dm-faq, #cta-consultant-delhi {
    padding: 64px 0;
  }
  .hp-hero-stats-ledger {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .arch-spread-body-wrap,
  .arch-advisory-framework-card,
  .arch-authority-ledger {
    padding: 24px 20px;
  }
}
"""

with open('css/home-live.css', 'w', encoding='utf-8') as f:
    f.write(home_live_css)
print("css/home-live.css written successfully")

# 3. GENERATE css/animations.css (Subtle, purposeful transitions only)
animations_css = """/* ==========================================================================
   ANIMATIONS & TRANSITIONS (Subtle, Purposeful, Zero Clutter)
   ========================================================================== */

/* Clean fade reveals */
.reveal-on-scroll {
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.4s ease, transform 0.4s ease;
  will-change: opacity, transform;
}

.reveal-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.reveal-from-left {
  opacity: 0;
  transform: translateX(-16px);
  transition: opacity 0.4s ease, transform 0.4s ease;
}
.reveal-from-left.is-visible {
  opacity: 1;
  transform: translateX(0);
}

.reveal-from-right {
  opacity: 0;
  transform: translateX(16px);
  transition: opacity 0.4s ease, transform 0.4s ease;
}
.reveal-from-right.is-visible {
  opacity: 1;
  transform: translateX(0);
}

/* Respect user's motion preferences */
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
"""

with open('css/animations.css', 'w', encoding='utf-8') as f:
    f.write(animations_css)
print("css/animations.css written successfully")

# 4. GENERATE css/services.css (Swiss catalog & practice layouts)
services_css = """/* ==========================================================================
   SERVICES DIRECTORY & DETAIL STYLES - RITWIK SACHDEVA
   Swiss Editorial Architecture
   ========================================================================== */

.services-hero {
  padding-top: calc(var(--header-height) + 48px);
  padding-bottom: 48px;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.services-metrics-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  margin-top: 40px;
  padding-top: 32px;
  border-top: 1px solid var(--border-color);
}

.metric-strip-item {
  display: flex;
  flex-direction: column;
}

.metric-strip-val {
  font-family: var(--font-serif);
  font-size: clamp(2rem, 3vw, 2.6rem);
  font-weight: 600;
  color: var(--text-primary);
  line-height: 1.1;
  margin-bottom: 4px;
}

.metric-strip-label {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-weight: 600;
}

.services-subnav-sticky {
  position: sticky;
  top: var(--header-height);
  z-index: 900;
  background: var(--bg-surface);
  border-bottom: 1px solid var(--border-color);
  padding: 12px 0;
  overflow-x: auto;
}

.services-subnav-track {
  display: flex;
  gap: 8px;
  align-items: center;
  white-space: nowrap;
}

.subnav-pill {
  font-size: 0.82rem;
  font-weight: 600;
  padding: 6px 14px;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  color: var(--text-secondary);
  text-decoration: none;
  transition: all var(--transition-fast);
}

.subnav-pill:hover,
.subnav-pill.active {
  background: var(--text-primary);
  color: #FFFFFF;
  border-color: var(--text-primary);
}

.services-quick-select-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  padding: 20px 24px;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  margin: 36px 0 48px;
  box-shadow: var(--shadow-sm);
  flex-wrap: wrap;
}

.quick-select-label-wrap {
  display: flex;
  align-items: center;
  gap: 14px;
}

.quick-select-icon {
  width: 36px;
  height: 36px;
  border-radius: var(--radius-sm);
  background: var(--accent-bronze-light);
  border: 1px solid var(--accent-bronze-subtle);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-bronze);
}

.quick-select-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: var(--text-primary);
}

.quick-select-subtitle {
  font-size: 0.8rem;
  color: var(--text-muted);
}

.service-jump-select {
  padding: 10px 16px;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border-color);
  background: var(--bg-canvas);
  color: var(--text-primary);
  font-size: 0.88rem;
  font-weight: 600;
  cursor: pointer;
}

.service-catalog-item {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 44px;
  margin-bottom: 40px;
  box-shadow: var(--shadow-sm);
  transition: border-color var(--transition-fast);
}

.service-catalog-item:hover {
  border-color: var(--accent-bronze);
}

@media (max-width: 768px) {
  .services-metrics-strip {
    grid-template-columns: repeat(2, 1fr);
  }
  .service-catalog-item {
    padding: 28px 20px;
  }
}
"""

with open('css/services.css', 'w', encoding='utf-8') as f:
    f.write(services_css)
print("css/services.css written successfully")
