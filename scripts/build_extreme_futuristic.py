# BUILD EXTREME FUTURISTIC DIGITAL MARKETING EXPERT DESIGN SYSTEM

# 1. css/style.css
style_css = """/* ==========================================================================
   RITWIK SACHDEVA — EXTREME FUTURISTIC DIGITAL MARKETING EXPERT
   Visual Identity: Deep Midnight Void (#05070E), Glassmorphic Cyber Surfaces,
                    Electric Violet (#8B5CF6), Cyber Cyan (#00F0FF), Neon Rose (#EC4899)
   Typography: Syne & Plus Jakarta Sans + JetBrains Mono
   Aesthetic: Immersive Creative Studio / Digital Growth Laboratory
   ========================================================================== */

@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Syne:wght@600;700;800&display=swap');

/* ==========================================================================
   1. DESIGN TOKENS & CYBER FOUNDATIONS
   ========================================================================== */
:root {
  /* Midnight Navy / Near-Black Void Surfaces */
  --bg-canvas: #05070E;
  --bg-primary: #05070E;
  --bg-surface: rgba(13, 18, 32, 0.7);
  --bg-secondary: rgba(13, 18, 32, 0.7);
  --bg-surface-elevated: rgba(19, 26, 46, 0.85);
  --bg-subtle: rgba(255, 255, 255, 0.03);
  --bg-glass: rgba(13, 18, 32, 0.65);
  --bg-noir: #030508;
  --bg-noir-surface: #090C16;

  /* Typography Colors */
  --text-primary: #FFFFFF;
  --text-secondary: #94A3B8;
  --text-muted: #64748B;
  --text-subtle: #475569;
  --text-inverse: #05070E;

  /* Electric Neon Accents */
  --accent-cyan: #00F0FF;
  --accent-cyan-glow: rgba(0, 240, 255, 0.35);
  --accent-violet: #8B5CF6;
  --accent-purple: #7C3AED;
  --accent-purple-glow: rgba(139, 92, 246, 0.4);
  --accent-pink: #EC4899;
  --accent-pink-glow: rgba(236, 72, 153, 0.35);

  --accent-primary: #00F0FF;
  --accent-secondary: #8B5CF6;
  --accent-hover: #38BDF8;
  --accent-light: rgba(0, 240, 255, 0.08);

  /* Glowing Gradients */
  --gradient-cyber: linear-gradient(135deg, #00F0FF 0%, #8B5CF6 50%, #EC4899 100%);
  --gradient-purple-cyan: linear-gradient(135deg, #8B5CF6 0%, #00F0FF 100%);
  --gradient-glow: linear-gradient(135deg, rgba(0, 240, 255, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);

  /* Neon Hairlines & Glass Borders */
  --border-color: rgba(255, 255, 255, 0.08);
  --border-subtle: rgba(255, 255, 255, 0.05);
  --border-strong: rgba(255, 255, 255, 0.15);
  --border-glow-cyan: rgba(0, 240, 255, 0.45);
  --border-glow-purple: rgba(139, 92, 246, 0.45);

  /* Status Tokens */
  --success: #10B981;
  --warning: #F59E0B;
  --error: #EF4444;

  /* Typography Families */
  --font-display: 'Syne', 'Plus Jakarta Sans', sans-serif;
  --font-heading: 'Plus Jakarta Sans', -apple-system, sans-serif;
  --font-body: 'Plus Jakarta Sans', -apple-system, sans-serif;
  --font-mono: 'JetBrains Mono', SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  --font-serif: 'Syne', sans-serif;

  /* Geometry & Glass Radii */
  --radius-xs: 4px;
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 20px;
  --radius-pill: 9999px;
  --radius-full: 9999px;

  /* Cyber Glow Shadows */
  --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.4);
  --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.45);
  --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.6), 0 0 25px rgba(0, 240, 255, 0.2);
  --shadow-navbar: 0 4px 20px rgba(0, 0, 0, 0.5);
  --shadow-glow: 0 0 30px rgba(139, 92, 246, 0.35);

  /* Spatial Grid System */
  --container-max: 1200px;
  --container-narrow: 880px;
  --header-height: 80px;
  --section-spacing: 96px;
  --section-spacing-sm: 64px;

  /* Transitions */
  --transition-fast: 0.18s cubic-bezier(0.16, 1, 0.3, 1);
  --transition-smooth: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

/* ==========================================================================
   2. GLOBAL RESET & BASE
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

/* Custom Cyber Scrollbar */
::-webkit-scrollbar {
  width: 6px;
}
::-webkit-scrollbar-track {
  background: var(--bg-canvas);
}
::-webkit-scrollbar-thumb {
  background: rgba(139, 92, 246, 0.3);
  border-radius: var(--radius-pill);
}
::-webkit-scrollbar-thumb:hover {
  background: var(--accent-cyan);
}

::selection {
  background: var(--accent-purple);
  color: #FFFFFF;
}

/* ==========================================================================
   3. CYBER TYPOGRAPHY
   ========================================================================== */
h1, h2, h3, h4, h5, h6 {
  color: var(--text-primary);
  line-height: 1.15;
  font-weight: 700;
  letter-spacing: -0.02em;
}

h1 {
  font-family: var(--font-display);
  font-size: clamp(2.4rem, 4.4vw, 3.8rem);
  line-height: 1.1;
  letter-spacing: -0.03em;
}

h2 {
  font-family: var(--font-display);
  font-size: clamp(1.9rem, 3.2vw, 2.7rem);
  line-height: 1.15;
  letter-spacing: -0.025em;
}

h3 {
  font-family: var(--font-heading);
  font-size: clamp(1.2rem, 1.8vw, 1.55rem);
  line-height: 1.25;
  font-weight: 700;
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

/* Gradient Text Highlights */
.gradient-text, .text-gradient {
  background: var(--gradient-cyber) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  display: inline-block;
}

.gradient-text-alt {
  background: var(--gradient-purple-cyan) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
}

/* Cyber Stamp & Technical Kicker */
.arch-tag, .section-tag, .kicker-stamp {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--accent-cyan);
  background: rgba(0, 240, 255, 0.08);
  border: 1px solid rgba(0, 240, 255, 0.25);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 0 14px rgba(0, 240, 255, 0.15);
  margin-bottom: 18px;
}

/* ==========================================================================
   4. CONTAINER CONSTRAINTS & AMBIENT CANVAS
   ========================================================================== */
#main-content,
.ecom-page-wrapper,
main {
  width: 100%;
  max-width: var(--container-max, 1200px);
  margin-left: auto;
  margin-right: auto;
  padding-left: clamp(20px, 3.5vw, 36px);
  padding-right: clamp(20px, 3.5vw, 36px);
  box-sizing: border-box;
}

.container {
  width: 100%;
  max-width: var(--container-max, 1200px);
  margin-left: auto;
  margin-right: auto;
  padding-left: clamp(20px, 3.5vw, 36px);
  padding-right: clamp(20px, 3.5vw, 36px);
  box-sizing: border-box;
}

main .container,
#main-content .container {
  padding-left: 0;
  padding-right: 0;
  max-width: 100%;
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

/* Futuristic Ambient Light Layer */
.bg-ambient-layer {
  position: fixed;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
  z-index: 0;
}

.ambient-glow-circle {
  position: absolute;
  border-radius: 50%;
  filter: blur(140px);
  opacity: 0.28;
  pointer-events: none;
}

.ambient-glow-1 {
  width: 550px;
  height: 550px;
  background: radial-gradient(circle, #8B5CF6 0%, transparent 70%);
  top: -100px;
  right: -50px;
}

.ambient-glow-2 {
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, #00F0FF 0%, transparent 70%);
  bottom: 15%;
  left: -80px;
}

.grid-pattern-overlay {
  position: absolute;
  inset: 0;
  background-image: 
    linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
  background-size: 48px 48px;
  mask-image: radial-gradient(circle at center, black 40%, transparent 90%);
  -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 90%);
}

/* Glowing Scroll Progress Bar */
#scroll-progress {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  width: 0%;
  background: var(--gradient-cyber);
  box-shadow: 0 0 12px rgba(0, 240, 255, 0.8);
  z-index: 9999;
  transition: width 0.1s linear;
}

/* ==========================================================================
   5. TRANSPARENT-TO-GLASS NAVIGATION
   ========================================================================== */
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: var(--header-height);
  z-index: 1000;
  background: rgba(5, 7, 14, 0.7);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border-color);
  transition: height var(--transition-fast), background-color var(--transition-fast), box-shadow var(--transition-fast);
}

.site-header.scrolled {
  height: 70px;
  background: rgba(5, 7, 14, 0.92);
  border-bottom: 1px solid rgba(139, 92, 246, 0.25);
  box-shadow: var(--shadow-navbar);
}

.nav-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}

/* Glowing Brand Monogram */
.brand-logo {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  color: var(--text-primary);
}

.brand-monogram {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, rgba(0, 240, 255, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
  border: 1px solid rgba(0, 240, 255, 0.4);
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  font-family: var(--font-display);
  font-weight: 800;
  font-size: 0.95rem;
  letter-spacing: -0.02em;
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
  transition: all var(--transition-fast);
}

.brand-logo:hover .brand-monogram {
  border-color: var(--accent-cyan);
  box-shadow: 0 0 22px rgba(0, 240, 255, 0.5);
  transform: translateY(-2px);
}

.brand-info {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-family: var(--font-heading);
  line-height: 1.15;
  font-size: 1.12rem;
  font-weight: 750;
  color: var(--text-primary);
  letter-spacing: -0.02em;
}

.brand-title {
  font-size: 0.7rem;
  font-family: var(--font-mono);
  font-weight: 600;
  color: var(--accent-cyan);
  text-transform: uppercase;
  letter-spacing: 0.14em;
}

/* Navigation Links */
.desktop-nav {
  display: flex;
  align-items: center;
  gap: 32px;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 28px;
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
  background: var(--gradient-cyber);
  box-shadow: 0 0 8px rgba(0, 240, 255, 0.6);
  transition: width var(--transition-fast);
}

.nav-link:hover {
  color: #FFFFFF;
}

.nav-link:hover::after {
  width: 100%;
}

.nav-link.active {
  color: #FFFFFF;
  font-weight: 700;
}

.nav-link.active::after {
  width: 100%;
}

/* Futuristic Dropdown Menu */
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
  color: var(--accent-cyan);
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
  background: rgba(10, 14, 26, 0.94);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(139, 92, 246, 0.3);
  border-radius: var(--radius-md);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8), 0 0 25px rgba(139, 92, 246, 0.15);
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
  color: var(--accent-cyan);
  background: rgba(0, 240, 255, 0.1);
  padding: 3px 10px;
  border-radius: var(--radius-pill);
  border: 1px solid rgba(0, 240, 255, 0.3);
}

.nav-dropdown-list {
  display: flex;
  flex-direction: column;
  gap: 4px;
  overflow-y: auto;
  max-height: calc(88vh - 120px);
  overscroll-behavior: contain;
  padding-right: 4px;
}

.nav-dropdown-list::-webkit-scrollbar {
  width: 4px;
}
.nav-dropdown-list::-webkit-scrollbar-thumb {
  background: rgba(139, 92, 246, 0.4);
  border-radius: 2px;
}

.nav-dropdown-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 10px 12px;
  border-radius: var(--radius-sm);
  text-decoration: none;
  transition: background-color var(--transition-fast), border-color var(--transition-fast), transform var(--transition-fast);
  border: 1px solid transparent;
}

.nav-dropdown-item:hover {
  background-color: rgba(255, 255, 255, 0.04);
  border-color: rgba(0, 240, 255, 0.3);
  transform: translateX(4px);
}

.dropdown-item-num {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  color: var(--accent-cyan);
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
  color: #FFFFFF;
  line-height: 1.3;
  margin-bottom: 2px;
  transition: color var(--transition-fast);
}

.nav-dropdown-item:hover .dropdown-item-title {
  color: var(--accent-cyan);
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
  color: var(--accent-cyan);
  text-decoration: none;
  transition: all var(--transition-fast);
}

.dropdown-view-all:hover {
  color: #FFFFFF;
  text-shadow: 0 0 10px rgba(0, 240, 255, 0.8);
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
  color: #FFFFFF;
}

.hamburger-line {
  display: block;
  width: 24px;
  height: 2px;
  background-color: #FFFFFF;
  transition: transform var(--transition-fast), opacity var(--transition-fast);
}

.hamburger-line:nth-child(2) {
  margin: 5px 0;
}

.mobile-nav-toggle.is-active .hamburger-line:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
  background-color: var(--accent-cyan);
}
.mobile-nav-toggle.is-active .hamburger-line:nth-child(2) {
  opacity: 0;
}
.mobile-nav-toggle.is-active .hamburger-line:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
  background-color: var(--accent-cyan);
}

/* Mobile Drawer */
.mobile-drawer {
  position: fixed;
  inset: 0;
  background-color: rgba(5, 7, 14, 0.98);
  backdrop-filter: blur(28px);
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
  font-family: var(--font-display);
  font-size: 1.85rem;
  font-weight: 700;
  color: #FFFFFF;
  text-decoration: none;
  transition: color var(--transition-fast);
  display: inline-block;
}

.mobile-link:hover,
.mobile-link.active {
  color: var(--accent-cyan);
  text-shadow: 0 0 12px rgba(0, 240, 255, 0.5);
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
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--border-color);
  width: 38px;
  height: 38px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.mobile-submenu-btn.is-expanded {
  transform: rotate(180deg);
  background: var(--accent-purple);
  color: #FFFFFF;
  border-color: var(--accent-purple);
}

.mobile-submenu {
  display: none;
  flex-direction: column;
  gap: 10px;
  padding: 14px 0 8px 16px;
  border-left: 2px solid var(--accent-cyan);
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
  color: var(--accent-cyan);
}

.mobile-drawer-footer {
  border-top: 1px solid var(--border-color);
  padding-top: 24px;
  display: flex;
  flex-direction: column;
  gap: 14px;
}

/* ==========================================================================
   6. MAGNETIC GLOWING BUTTONS
   ========================================================================== */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 12px 28px;
  border-radius: var(--radius-pill);
  font-family: var(--font-heading);
  font-size: 0.92rem;
  font-weight: 700;
  line-height: 1;
  cursor: pointer;
  border: 1px solid transparent;
  text-decoration: none;
  transition: all var(--transition-fast);
  position: relative;
  text-align: center;
  letter-spacing: 0.01em;
  overflow: hidden;
}

.btn-primary {
  background: var(--gradient-cyber);
  color: #05070E !important;
  font-weight: 800;
  box-shadow: 0 0 20px rgba(0, 240, 255, 0.4);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 35px rgba(0, 240, 255, 0.7), 0 0 15px rgba(139, 92, 246, 0.5);
  color: #05070E !important;
}

.btn-secondary {
  background: rgba(255, 255, 255, 0.05);
  color: #FFFFFF;
  border: 1px solid var(--border-color);
  backdrop-filter: blur(12px);
}

.btn-secondary:hover {
  background: rgba(255, 255, 255, 0.1);
  border-color: var(--accent-cyan);
  box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
  color: #FFFFFF;
}

.btn-outline {
  background: transparent;
  color: #FFFFFF;
  border: 1px solid var(--accent-cyan);
  box-shadow: 0 0 12px rgba(0, 240, 255, 0.2);
}

.btn-outline:hover {
  background: rgba(0, 240, 255, 0.1);
  border-color: var(--accent-cyan);
  box-shadow: 0 0 24px rgba(0, 240, 255, 0.5);
  color: #FFFFFF;
}

.btn-sm {
  padding: 10px 20px;
  font-size: 0.85rem;
}

.btn-lg {
  padding: 15px 34px;
  font-size: 1rem;
}

.btn-icon-right svg {
  transition: transform var(--transition-fast);
}

.btn:hover .btn-icon-right svg {
  transform: translateX(3px);
}

/* ==========================================================================
   7. MIDNIGHT CYBER FOOTER
   ========================================================================== */
.site-footer {
  background-color: var(--bg-noir);
  color: #94A3B8;
  border-top: 1px solid rgba(139, 92, 246, 0.2);
  padding: 88px 0 36px 0;
  position: relative;
  overflow: hidden;
}

.site-footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 60%;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--accent-cyan), var(--accent-violet), transparent);
  box-shadow: 0 0 15px var(--accent-cyan);
}

.site-footer a {
  color: #94A3B8;
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
  color: #64748B;
  line-height: 1.7;
  margin-top: 18px;
  max-width: 360px;
}

.site-footer .brand-logo {
  color: #FFFFFF;
}

.site-footer .brand-monogram {
  background: rgba(0, 240, 255, 0.08);
  border-color: rgba(0, 240, 255, 0.4);
}

.site-footer .brand-name {
  color: #FFFFFF;
}

.site-footer .brand-title {
  color: var(--accent-cyan);
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
  transition: color var(--transition-fast), transform var(--transition-fast);
}

.footer-link:hover {
  color: var(--accent-cyan);
  transform: translateX(3px);
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
  border: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #94A3B8;
  transition: all var(--transition-fast);
}

.social-icon-btn:hover {
  background: rgba(0, 240, 255, 0.15);
  border-color: var(--accent-cyan);
  color: var(--accent-cyan);
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
  transform: translateY(-2px);
}

.footer-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid var(--border-color);
  padding-top: 32px;
  font-size: 0.84rem;
  color: #64748B;
  flex-wrap: wrap;
  gap: 16px;
}

.back-to-top-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid var(--border-color);
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  color: #CBD5E1;
  font-family: var(--font-mono);
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.back-to-top-btn:hover {
  border-color: var(--accent-cyan);
  color: #FFFFFF;
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
}

/* ==========================================================================
   8. GLASSMORPHIС FORMS & INQUIRY
   ========================================================================== */
.contact-layout-grid {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: 48px;
  align-items: start;
}

.contact-info-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-lg);
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
  background: rgba(0, 240, 255, 0.08);
  border: 1px solid rgba(0, 240, 255, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-cyan);
  flex-shrink: 0;
  box-shadow: 0 0 12px rgba(0, 240, 255, 0.2);
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
  color: #FFFFFF;
}

.contact-item-value a:hover {
  color: var(--accent-cyan);
  text-shadow: 0 0 8px rgba(0, 240, 255, 0.6);
}

.form-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-lg);
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
  color: #FFFFFF;
  margin-bottom: 8px;
}

.form-label .required-mark {
  color: var(--accent-cyan);
}

.form-control {
  width: 100%;
  background-color: rgba(5, 7, 14, 0.6);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 13px 16px;
  color: #FFFFFF;
  font-size: 0.94rem;
  transition: all var(--transition-fast);
}

.form-control:focus {
  outline: none;
  background-color: rgba(13, 18, 32, 0.9);
  border-color: var(--accent-cyan);
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.3);
}

.form-control.is-invalid {
  border-color: var(--error);
  box-shadow: 0 0 12px rgba(239, 68, 68, 0.3);
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
   9. CUSTOM GLOWING CURSOR (DESKTOP)
   ========================================================================== */
.custom-cursor-dot {
  position: fixed;
  top: 0;
  left: 0;
  width: 8px;
  height: 8px;
  background-color: var(--accent-cyan);
  border-radius: 50%;
  pointer-events: none;
  z-index: 10000;
  opacity: 0;
  transform: translate(-50%, -50%);
  transition: opacity 0.2s ease, transform 0.1s ease;
  box-shadow: 0 0 12px var(--accent-cyan);
}

.custom-cursor-ring {
  position: fixed;
  top: 0;
  left: 0;
  width: 36px;
  height: 36px;
  border: 1.5px solid rgba(0, 240, 255, 0.5);
  border-radius: 50%;
  pointer-events: none;
  z-index: 9999;
  opacity: 0;
  transform: translate(-50%, -50%);
  transition: opacity 0.2s ease, width 0.2s ease, height 0.2s ease, border-color 0.2s ease, background-color 0.2s ease;
}

.custom-cursor-ring.cursor-active {
  width: 56px;
  height: 56px;
  border-color: var(--accent-purple);
  background-color: rgba(139, 92, 246, 0.12);
  box-shadow: 0 0 25px rgba(139, 92, 246, 0.4);
}

/* Modal Dialog */
.modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(3, 5, 8, 0.85);
  backdrop-filter: blur(16px);
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
  background: var(--bg-surface-elevated);
  border: 1px solid rgba(0, 240, 255, 0.3);
  border-radius: var(--radius-md);
  padding: 48px 40px;
  max-width: 500px;
  width: 100%;
  text-align: center;
  box-shadow: 0 0 40px rgba(0, 240, 255, 0.2);
}

.modal-icon-circle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: rgba(16, 185, 129, 0.15);
  border: 1px solid var(--success);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--success);
  box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
  margin: 0 auto 20px auto;
}

/* ==========================================================================
   10. COMMON EDITORIAL & INTERACTIVE COMPONENTS
   ========================================================================== */
.section-header {
  margin-bottom: 48px;
}

.section-header.text-center {
  text-align: center;
}

.section-header.text-center .section-subtitle {
  margin-left: auto;
  margin-right: auto;
}

.section-title {
  font-family: var(--font-display);
  font-size: clamp(1.9rem, 3.2vw, 2.7rem);
  font-weight: 700;
  line-height: 1.15;
  letter-spacing: -0.02em;
  color: #FFFFFF;
  margin-bottom: 14px;
}

.section-subtitle {
  font-size: 1.05rem;
  line-height: 1.7;
  color: var(--text-secondary);
  max-width: 680px;
}

.expertise-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 22px;
  margin-top: 36px;
}

.card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 34px 30px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-smooth);
  position: relative;
  overflow: hidden;
}

.card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: var(--gradient-cyber);
  opacity: 0;
  transition: opacity var(--transition-fast);
}

.card:hover {
  border-color: rgba(0, 240, 255, 0.4);
  transform: translateY(-4px);
  box-shadow: var(--shadow-hover);
}

.card:hover::before {
  opacity: 1;
}

.card-icon {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: rgba(0, 240, 255, 0.08);
  border: 1px solid rgba(0, 240, 255, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-cyan);
  margin-bottom: 18px;
  box-shadow: 0 0 14px rgba(0, 240, 255, 0.2);
}

.step-phase {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-cyan);
  text-transform: uppercase;
  letter-spacing: 0.12em;
  margin-bottom: 8px;
}

.badge-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: var(--radius-pill);
  background: rgba(139, 92, 246, 0.1);
  border: 1px solid rgba(139, 92, 246, 0.3);
  color: #FFFFFF;
  display: inline-block;
}

/* About Layout */
.about-preview-grid {
  display: grid;
  grid-template-columns: 0.95fr 1.05fr;
  gap: 56px;
  align-items: center;
}

.about-preview-image-wrap {
  position: relative;
}

.about-preview-portrait {
  border: 1px solid rgba(139, 92, 246, 0.3);
  border-radius: var(--radius-md);
  overflow: hidden;
  background: var(--bg-surface);
  padding: 16px;
  box-shadow: 0 0 30px rgba(139, 92, 246, 0.2);
}

.about-preview-img {
  width: 100%;
  height: auto;
  max-height: 480px;
  object-fit: cover;
  border-radius: var(--radius-sm);
}

.about-badge-experience {
  position: absolute;
  bottom: 24px;
  right: -14px;
  background: rgba(10, 14, 26, 0.92);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 240, 255, 0.4);
  border-radius: var(--radius-sm);
  padding: 14px 20px;
  box-shadow: 0 0 25px rgba(0, 240, 255, 0.3);
}

.about-badge-exp-num {
  font-family: var(--font-display);
  font-size: 2.2rem;
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1;
}

.about-badge-exp-text {
  font-family: var(--font-mono);
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--accent-cyan);
  font-weight: 700;
  margin-top: 4px;
}

/* Methodology */
.methodology-timeline {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 40px;
}

.methodology-step {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-sm);
  padding: 28px 24px;
  box-shadow: var(--shadow-sm);
  border-top: 3px solid var(--accent-violet);
  transition: all var(--transition-fast);
}

.methodology-step:hover {
  border-top-color: var(--accent-cyan);
  box-shadow: 0 0 20px rgba(0, 240, 255, 0.25);
  transform: translateY(-3px);
}

@media (max-width: 992px) {
  .desktop-nav { display: none; }
  .mobile-nav-toggle { display: flex; }
  .expertise-grid { grid-template-columns: 1fr; }
  .about-preview-grid { grid-template-columns: 1fr; }
  .methodology-timeline { grid-template-columns: repeat(2, 1fr); }
  .footer-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
  .contact-layout-grid { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
  .methodology-timeline { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
}
"""

with open('css/style.css', 'w', encoding='utf-8') as f:
    f.write(style_css)
print("css/style.css updated for extreme futuristic visual identity")

# 2. css/animations.css
animations_css = """/* ==========================================================================
   FUTURISTIC ANIMATION & INTERACTION ENGINE
   GPU-accelerated transforms, particle glows, and cyber transitions
   ========================================================================== */

/* Keyframe Animations */
@keyframes cyber-pulse {
  0%, 100% {
    transform: scale(1);
    opacity: 0.25;
  }
  50% {
    transform: scale(1.08);
    opacity: 0.38;
  }
}

.ambient-glow-1 {
  animation: cyber-pulse 12s ease-in-out infinite alternate;
}

.ambient-glow-2 {
  animation: cyber-pulse 16s ease-in-out infinite alternate-reverse;
}

/* Glowing Neon Shimmer */
@keyframes neon-shimmer {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

.animated-gradient-text {
  background: linear-gradient(90deg, #00F0FF, #8B5CF6, #EC4899, #00F0FF);
  background-size: 300% 300%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: neon-shimmer 8s ease infinite;
}

/* Floating Analytics Widgets */
@keyframes widget-float {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-8px) rotate(0.5deg);
  }
}

.floating-widget-1 {
  animation: widget-float 6s ease-in-out infinite;
}

.floating-widget-2 {
  animation: widget-float 7.5s ease-in-out infinite 1s;
}

/* Scroll Reveals */
.reveal-on-scroll {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  will-change: opacity, transform;
}

.reveal-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.reveal-from-left {
  opacity: 0;
  transform: translateX(-30px);
  transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal-from-left.is-visible {
  opacity: 1;
  transform: translateX(0);
}

.reveal-from-right {
  opacity: 0;
  transform: translateX(30px);
  transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
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
print("css/animations.css updated for futuristic animations")

# 3. css/home-live.css
home_live_css = """/* ==========================================================================
   HOMEPAGE ARCHITECTURAL STYLESHEET (home-live.css)
   Futuristic Cyber Marketing Laboratory Architecture
   ========================================================================== */

#main-content {
  width: 100%;
  max-width: var(--container-max, 1200px);
  margin: 0 auto;
  padding-left: clamp(20px, 3.5vw, 36px);
  padding-right: clamp(20px, 3.5vw, 36px);
  box-sizing: border-box;
}

.hp-container {
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
  padding: 0;
  box-sizing: border-box;
}

/* --- CINEMATIC CYBER HERO --- */
#hero {
  padding: calc(var(--header-height, 80px) + 36px) 0 76px;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
  position: relative;
}

.hp-hero-editorial-wrap {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: 52px;
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
  margin-bottom: 18px;
}

.hp-hero-kicker {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--accent-cyan);
  background: rgba(0, 240, 255, 0.08);
  border: 1px solid rgba(0, 240, 255, 0.3);
  padding: 5px 14px;
  border-radius: var(--radius-pill);
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
}

#hero .hp-h1 {
  font-family: var(--font-display);
  font-size: clamp(2.3rem, 4.2vw, 3.6rem);
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: -0.03em;
  color: #FFFFFF;
  margin: 0 0 22px;
}

#hero .hp-body {
  font-size: 1.05rem;
  line-height: 1.74;
  color: var(--text-secondary);
  margin-bottom: 30px;
  max-width: 620px;
}

.hp-hero-actions-row {
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 40px;
}

.hp-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 14px 32px;
  border-radius: var(--radius-pill);
  font-family: var(--font-heading);
  font-size: 0.94rem;
  font-weight: 700;
  line-height: 1;
  text-decoration: none;
  cursor: pointer;
  transition: all var(--transition-fast);
}

.hp-btn-primary {
  background: var(--gradient-cyber);
  color: #05070E !important;
  font-weight: 800;
  border: none;
  box-shadow: 0 0 25px rgba(0, 240, 255, 0.45);
}

.hp-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 40px rgba(0, 240, 255, 0.75), 0 0 20px rgba(139, 92, 246, 0.5);
  color: #05070E !important;
}

/* Luminous Stats Ledger */
.hp-hero-stats-ledger {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  padding-top: 28px;
  border-top: 1px solid var(--border-color);
}

.hp-stat-ledger-item {
  display: flex;
  flex-direction: column;
}

.hp-stat-number {
  font-family: var(--font-display);
  font-size: clamp(1.9rem, 2.8vw, 2.4rem);
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.1;
  margin-bottom: 4px;
  letter-spacing: -0.02em;
  background: var(--gradient-cyber);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hp-stat-label {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-weight: 600;
}

/* Hero Visual Composition with Floating Analytics Widgets */
.hp-hero-visual-column {
  position: relative;
}

.hp-visual-composition-frame {
  position: relative;
  border-radius: var(--radius-lg);
  border: 1px solid rgba(139, 92, 246, 0.3);
  background: rgba(13, 18, 32, 0.75);
  backdrop-filter: blur(20px);
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6), 0 0 30px rgba(139, 92, 246, 0.2);
  padding: 20px;
}

.hp-visual-composition-frame img {
  width: 100%;
  height: auto;
  max-height: 460px;
  object-fit: contain;
  border-radius: var(--radius-md);
  background: rgba(5, 7, 14, 0.6);
}

.hp-floating-meta-chip {
  position: absolute;
  background: rgba(10, 14, 26, 0.92);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(0, 240, 255, 0.35);
  border-radius: var(--radius-sm);
  padding: 10px 16px;
  box-shadow: 0 0 20px rgba(0, 240, 255, 0.25);
  z-index: 2;
}

.hp-chip-top {
  top: 14px;
  right: -10px;
}

.hp-chip-bottom {
  bottom: 14px;
  left: -10px;
}

.hp-chip-title {
  font-family: var(--font-mono);
  font-size: 0.68rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--accent-cyan);
  margin-bottom: 2px;
}

.hp-chip-val {
  font-family: var(--font-heading);
  font-weight: 750;
  font-size: 0.88rem;
  color: #FFFFFF;
}

/* --- SECTION 1: WHAT A DIGITAL MARKETING CONSULTANT DOES --- */
#what-consultant-does {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-spread-layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: 52px;
  align-items: start;
}

.arch-spread-header {
  position: sticky;
  top: calc(var(--header-height, 80px) + 24px);
}

.arch-spread-index {
  font-family: var(--font-mono);
  font-size: 0.8rem;
  font-weight: 700;
  color: var(--accent-cyan);
  margin-bottom: 12px;
  display: block;
  letter-spacing: 0.12em;
}

.arch-spread-title {
  font-family: var(--font-display);
  font-size: clamp(1.85rem, 3vw, 2.5rem);
  font-weight: 700;
  line-height: 1.15;
  letter-spacing: -0.02em;
  color: #FFFFFF;
  margin-bottom: 16px;
}

.arch-spread-body-wrap {
  display: flex;
  flex-direction: column;
  gap: 22px;
  padding: 38px 36px;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  border-left: 3px solid var(--accent-cyan);
  box-shadow: var(--shadow-sm);
}

.arch-spread-body-wrap p {
  font-size: 1.02rem;
  line-height: 1.74;
  color: var(--text-secondary);
  max-width: 100%;
}

.arch-spread-body-wrap p:first-child {
  font-size: 1.15rem;
  font-weight: 600;
  color: #FFFFFF;
  line-height: 1.6;
  border-bottom: 1px solid var(--border-color);
  padding-bottom: 20px;
}

/* --- SECTION 2: DIGITAL MARKETING SERVICES IN DELHI --- */
#services {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-ledger-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 36px;
}

.arch-ledger-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 30px 28px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: var(--shadow-sm);
  text-decoration: none !important;
  color: inherit !important;
  transition: all var(--transition-smooth);
  position: relative;
  overflow: hidden;
}

.arch-ledger-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: var(--gradient-cyber);
  opacity: 0;
  transition: opacity var(--transition-fast);
}

.arch-ledger-card:hover {
  border-color: rgba(0, 240, 255, 0.45);
  box-shadow: var(--shadow-hover);
  transform: translateY(-4px);
}

.arch-ledger-card:hover::before {
  opacity: 1;
}

.arch-card-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 16px;
}

.arch-card-coord {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-cyan);
  background: rgba(0, 240, 255, 0.1);
  border: 1px solid rgba(0, 240, 255, 0.3);
  padding: 3px 8px;
  border-radius: var(--radius-pill);
  letter-spacing: 0.08em;
}

.arch-card-icon-glyph {
  width: 38px;
  height: 38px;
  border-radius: var(--radius-sm);
  background: rgba(139, 92, 246, 0.12);
  border: 1px solid rgba(139, 92, 246, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-cyan);
  transition: all var(--transition-fast);
}

.arch-ledger-card:hover .arch-card-icon-glyph {
  background: var(--gradient-cyber);
  color: #05070E;
  border-color: transparent;
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.5);
}

.arch-card-title {
  font-family: var(--font-heading);
  font-size: 1.15rem;
  font-weight: 750;
  color: #FFFFFF;
  line-height: 1.25;
  margin-bottom: 10px;
  transition: color var(--transition-fast);
}

.arch-ledger-card:hover .arch-card-title {
  color: var(--accent-cyan);
}

.arch-card-desc {
  font-size: 0.92rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* --- SECTION 3: WHO THIS IS FOR --- */
#who-for {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-archetype-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
  margin-top: 36px;
}

.arch-archetype-item {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 26px 24px;
  display: flex;
  align-items: flex-start;
  gap: 16px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.arch-archetype-item:hover {
  border-color: rgba(139, 92, 246, 0.4);
  transform: translateY(-2px);
  box-shadow: 0 0 20px rgba(139, 92, 246, 0.2);
}

.arch-archetype-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-cyan);
  background: rgba(0, 240, 255, 0.08);
  border: 1px solid rgba(0, 240, 255, 0.3);
  padding: 3px 8px;
  border-radius: var(--radius-pill);
  flex-shrink: 0;
  margin-top: 2px;
}

.arch-archetype-item span {
  font-size: 0.96rem;
  line-height: 1.65;
  color: var(--text-secondary);
}

/* --- SECTION 4: CHOOSING A DIGITAL MARKETING CONSULTANT IN DELHI --- */
#choosing-consultant {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-advisory-framework-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 44px 40px;
  box-shadow: var(--shadow-sm);
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.arch-advisory-framework-card p {
  font-size: 1.02rem;
  line-height: 1.74;
  color: var(--text-secondary);
  max-width: 100%;
}

.arch-advisory-framework-card p:first-child {
  font-size: 1.15rem;
  font-weight: 650;
  color: #FFFFFF;
  line-height: 1.62;
  border-bottom: 1px solid var(--border-color);
  padding-bottom: 18px;
}

/* --- SECTION 5: RESULTS-FOCUSED DIGITAL MARKETING --- */
#results-focused-marketing {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-kpi-matrix-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-top: 36px;
}

.arch-kpi-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 30px 24px;
  display: flex;
  flex-direction: column;
  border-top: 3px solid var(--accent-cyan);
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.arch-kpi-card:hover {
  border-top-color: var(--accent-pink);
  box-shadow: var(--shadow-hover);
  transform: translateY(-4px);
}

.arch-kpi-coord {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: var(--accent-cyan);
  margin-bottom: 12px;
}

.arch-kpi-title {
  font-family: var(--font-heading);
  font-size: 1.15rem;
  font-weight: 750;
  color: #FFFFFF;
  margin-bottom: 10px;
}

.arch-kpi-desc {
  font-size: 0.92rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* --- SECTION 6: TRUSTED BY BUSINESSES SEARCHING FOR --- */
#trusted-businesses-searching {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-authority-ledger {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 40px 36px;
  box-shadow: var(--shadow-sm);
}

.arch-authority-ledger p {
  font-size: 1.02rem;
  line-height: 1.72;
  color: var(--text-secondary);
  max-width: 100%;
}

.arch-searches-cloud {
  margin-top: 20px;
  padding-top: 18px;
  border-top: 1px solid var(--border-color);
  font-family: var(--font-mono);
  font-size: 0.84rem;
  color: #FFFFFF;
  line-height: 1.75;
  font-weight: 500;
}

/* --- SECTION 7: FREQUENTLY ASKED QUESTIONS --- */
#dm-faq {
  padding: 80px 0;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.arch-faq-list {
  max-width: 860px;
  margin: 36px auto 0;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.arch-faq-item {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-sm);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.arch-faq-item:hover,
.arch-faq-item.active {
  border-color: var(--accent-cyan);
  box-shadow: 0 0 18px rgba(0, 240, 255, 0.25);
}

.arch-faq-question {
  width: 100%;
  padding: 18px 22px;
  background: transparent;
  border: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  cursor: pointer;
  text-align: left;
  color: #FFFFFF;
  font-family: var(--font-heading);
  font-size: 1.02rem;
  font-weight: 650;
  line-height: 1.35;
}

.arch-faq-coord {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: var(--accent-cyan);
  margin-right: 8px;
}

.arch-faq-toggle-icon {
  font-size: 1.25rem;
  font-weight: 400;
  color: var(--accent-cyan);
  transition: transform var(--transition-fast);
  line-height: 1;
}

.arch-faq-item.active .arch-faq-toggle-icon {
  transform: rotate(45deg);
  color: #FFFFFF;
}

.arch-faq-answer {
  display: none;
  padding: 0 22px 20px;
  color: var(--text-secondary);
  font-size: 0.96rem;
  line-height: 1.7;
  border-top: 1px solid var(--border-subtle);
}

.arch-faq-item.active .arch-faq-answer {
  display: block !important;
}

/* --- SECTION 8: EXECUTIVE BRIEFING CTA (Boxed inside container) --- */
#cta-consultant-delhi {
  padding: 72px 0 88px;
  background-color: transparent;
}

.arch-cta-monolith {
  max-width: 100%;
  margin: 0 auto;
  text-align: center;
  background: linear-gradient(135deg, rgba(13, 18, 32, 0.95) 0%, rgba(5, 7, 14, 0.98) 100%);
  border-radius: var(--radius-lg);
  padding: 68px 40px;
  border: 1px solid rgba(0, 240, 255, 0.35);
  box-shadow: 0 0 45px rgba(0, 240, 255, 0.25), 0 20px 50px rgba(0, 0, 0, 0.8);
  position: relative;
  overflow: hidden;
}

.arch-cta-monolith::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle at center, rgba(139, 92, 246, 0.15) 0%, transparent 60%);
  pointer-events: none;
}

.arch-cta-kicker {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--accent-cyan);
  margin-bottom: 18px;
}

.arch-cta-title {
  font-family: var(--font-display);
  font-size: clamp(1.9rem, 3.4vw, 2.9rem);
  font-weight: 700;
  line-height: 1.15;
  letter-spacing: -0.025em;
  color: #FFFFFF;
  margin-bottom: 18px;
}

.arch-cta-text {
  font-size: 1.05rem;
  line-height: 1.72;
  color: #CBD0D5;
  max-width: 660px;
  margin: 0 auto 34px;
}

.arch-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 14px 34px;
  background: var(--gradient-cyber);
  color: #05070E !important;
  border-radius: var(--radius-pill);
  font-family: var(--font-heading);
  font-size: 0.96rem;
  font-weight: 800;
  text-decoration: none;
  box-shadow: 0 0 25px rgba(0, 240, 255, 0.5);
  transition: all var(--transition-fast);
}

.arch-cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 40px rgba(0, 240, 255, 0.8);
  color: #05070E !important;
}

@media (max-width: 992px) {
  .hp-hero-editorial-wrap { grid-template-columns: 1fr; gap: 36px; }
  .arch-spread-layout { grid-template-columns: 1fr; gap: 28px; }
  .arch-spread-header { position: static; }
  .arch-ledger-grid { grid-template-columns: 1fr; }
  .arch-archetype-grid { grid-template-columns: 1fr; }
  .arch-kpi-matrix-grid { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
  #hero, #what-consultant-does, #services, #who-for, #choosing-consultant,
  #results-focused-marketing, #trusted-businesses-searching, #dm-faq, #cta-consultant-delhi {
    padding: 56px 0;
  }
  .hp-hero-stats-ledger { grid-template-columns: 1fr; gap: 16px; }
  .arch-spread-body-wrap,
  .arch-advisory-framework-card,
  .arch-authority-ledger,
  .arch-cta-monolith { padding: 24px 18px; }
}
"""

with open('css/home-live.css', 'w', encoding='utf-8') as f:
    f.write(home_live_css)
print("css/home-live.css updated for futuristic layout")

# 4. css/services.css
services_css = """/* ==========================================================================
   SERVICES DIRECTORY & DETAIL STYLES - RITWIK SACHDEVA
   Cyber Marketing Services Architecture
   ========================================================================== */

.services-hero {
  padding-top: calc(var(--header-height) + 48px);
  padding-bottom: 48px;
  background-color: transparent;
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
  font-family: var(--font-display);
  font-size: clamp(2rem, 3vw, 2.6rem);
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.1;
  margin-bottom: 4px;
  background: var(--gradient-cyber);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
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
  background: rgba(5, 7, 14, 0.88);
  backdrop-filter: blur(20px);
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
  border-radius: var(--radius-pill);
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid var(--border-color);
  color: var(--text-secondary);
  text-decoration: none;
  transition: all var(--transition-fast);
}

.subnav-pill:hover,
.subnav-pill.active {
  background: rgba(0, 240, 255, 0.15);
  color: var(--accent-cyan);
  border-color: var(--accent-cyan);
  box-shadow: 0 0 12px rgba(0, 240, 255, 0.3);
}

.services-quick-select-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  padding: 20px 24px;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
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
  background: rgba(0, 240, 255, 0.1);
  border: 1px solid rgba(0, 240, 255, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-cyan);
}

.quick-select-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: #FFFFFF;
}

.quick-select-subtitle {
  font-size: 0.8rem;
  color: var(--text-muted);
}

.service-jump-select {
  padding: 10px 16px;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border-color);
  background: rgba(5, 7, 14, 0.8);
  color: #FFFFFF;
  font-size: 0.88rem;
  font-weight: 600;
  cursor: pointer;
}

.service-catalog-item {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  padding: 44px;
  margin-bottom: 40px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.service-catalog-item:hover {
  border-color: rgba(0, 240, 255, 0.4);
  box-shadow: 0 0 30px rgba(0, 240, 255, 0.2);
}

@media (max-width: 768px) {
  .services-metrics-strip { grid-template-columns: repeat(2, 1fr); }
  .service-catalog-item { padding: 28px 20px; }
}
"""

with open('css/services.css', 'w', encoding='utf-8') as f:
    f.write(services_css)
print("css/services.css updated")

# 5. css/blog.css
blog_css = """/* ==========================================================================
   BLOG CMS & EDITORIAL STYLES - RITWIK SACHDEVA
   Cyber Editorial Architecture
   ========================================================================== */

.blog-hero {
  padding-top: calc(var(--header-height) + 48px);
  padding-bottom: 40px;
  background-color: transparent;
  border-bottom: 1px solid var(--border-color);
}

.blog-filter-bar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  margin-top: 36px;
  padding: 16px 20px;
  background-color: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-sm);
}

.blog-category-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
}

.category-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  background: rgba(255, 255, 255, 0.04);
  color: var(--text-secondary);
  font-size: 0.84rem;
  font-weight: 600;
  text-decoration: none;
  transition: all var(--transition-fast);
  border: 1px solid var(--border-color);
}

.category-pill:hover,
.category-pill.active {
  background: var(--gradient-cyber);
  color: #05070E;
  font-weight: 750;
  border-color: transparent;
  box-shadow: 0 0 14px rgba(0, 240, 255, 0.4);
}

.category-pill-count {
  display: inline-block;
  padding: 1px 6px;
  border-radius: var(--radius-pill);
  background: rgba(255, 255, 255, 0.1);
  font-size: 0.72rem;
  font-weight: 600;
}

.category-pill.active .category-pill-count {
  background: #05070E;
  color: #FFFFFF;
}

.blog-search-box {
  position: relative;
  min-width: 240px;
  flex: 1 1 240px;
  max-width: 320px;
}

.blog-search-input {
  width: 100%;
  padding: 9px 14px 9px 36px;
  border-radius: var(--radius-pill);
  border: 1px solid var(--border-color);
  background: rgba(5, 7, 14, 0.8);
  color: #FFFFFF;
  font-size: 0.88rem;
  font-family: var(--font-body);
  transition: all var(--transition-fast);
}

.blog-search-input:focus {
  outline: none;
  border-color: var(--accent-cyan);
  box-shadow: 0 0 15px rgba(0, 240, 255, 0.3);
}

.blog-search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
  pointer-events: none;
}

/* Featured Blog */
.featured-blog-card {
  display: grid;
  grid-template-columns: 1.15fr 1fr;
  gap: 32px;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  margin-top: 36px;
  margin-bottom: 56px;
  transition: all var(--transition-fast);
}

.featured-blog-card:hover {
  border-color: rgba(0, 240, 255, 0.45);
  box-shadow: 0 0 30px rgba(0, 240, 255, 0.25);
  transform: translateY(-4px);
}

.featured-blog-img-wrap {
  position: relative;
  overflow: hidden;
  min-height: 320px;
}

.featured-blog-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.featured-blog-card:hover .featured-blog-img-wrap img {
  transform: scale(1.03);
}

.featured-blog-content {
  padding: 36px 36px 36px 8px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.blog-badge {
  display: inline-flex;
  align-items: center;
  padding: 3px 10px;
  border-radius: var(--radius-pill);
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  background: rgba(0, 240, 255, 0.1);
  color: var(--accent-cyan);
  border: 1px solid rgba(0, 240, 255, 0.3);
  margin-bottom: 12px;
  width: fit-content;
}

.featured-badge {
  background: var(--gradient-cyber);
  color: #05070E;
  border: none;
  font-weight: 800;
}

.blog-meta-row {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 0.82rem;
  color: var(--text-muted);
  margin-bottom: 12px;
}

.blog-meta-dot {
  width: 3px;
  height: 3px;
  border-radius: 50%;
  background-color: var(--accent-cyan);
}

.featured-blog-title {
  font-family: var(--font-display);
  font-size: clamp(1.45rem, 2.4vw, 2rem);
  font-weight: 700;
  line-height: 1.25;
  margin-bottom: 14px;
  color: #FFFFFF;
}

.featured-blog-title a {
  color: inherit;
  text-decoration: none;
  transition: color var(--transition-fast);
}

.featured-blog-title a:hover {
  color: var(--accent-cyan);
}

.featured-blog-excerpt {
  color: var(--text-secondary);
  font-size: 0.96rem;
  line-height: 1.68;
  margin-bottom: 22px;
}

/* Regular Blog Grid */
.blog-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 24px;
}

.blog-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  display: flex;
  flex-direction: column;
  transition: all var(--transition-fast);
}

.blog-card:hover {
  border-color: rgba(139, 92, 246, 0.45);
  box-shadow: 0 0 25px rgba(139, 92, 246, 0.25);
  transform: translateY(-4px);
}

.blog-card-media {
  position: relative;
  width: 100%;
  height: 200px;
  overflow: hidden;
}

.blog-card-media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.blog-card:hover .blog-card-media img {
  transform: scale(1.04);
}

.blog-card-body {
  padding: 22px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.blog-card-title {
  font-family: var(--font-display);
  font-size: 1.2rem;
  font-weight: 700;
  line-height: 1.3;
  margin-bottom: 10px;
  color: #FFFFFF;
}

.blog-card-title a {
  color: inherit;
  text-decoration: none;
  transition: color var(--transition-fast);
}

.blog-card-title a:hover {
  color: var(--accent-cyan);
}

.blog-card-excerpt {
  color: var(--text-secondary);
  font-size: 0.92rem;
  line-height: 1.65;
  margin-bottom: 18px;
}

.blog-card-footer {
  margin-top: auto;
  padding-top: 16px;
  border-top: 1px solid var(--border-subtle);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.author-chip {
  display: flex;
  align-items: center;
  gap: 10px;
}

.author-avatar {
  width: 32px;
  height: 32px;
  border-radius: var(--radius-pill);
  object-fit: cover;
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
}

.author-meta-name {
  font-size: 0.82rem;
  font-weight: 650;
  color: #FFFFFF;
  display: block;
}

.author-meta-date {
  font-size: 0.74rem;
  color: var(--text-muted);
  display: block;
}

.read-more-link {
  font-size: 0.84rem;
  font-weight: 700;
  color: var(--accent-cyan);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: all var(--transition-fast);
}

.read-more-link:hover {
  color: #FFFFFF;
  text-shadow: 0 0 10px rgba(0, 240, 255, 0.8);
}

@media (max-width: 992px) {
  .featured-blog-card { grid-template-columns: 1fr; }
  .blog-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
  .blog-grid { grid-template-columns: 1fr; }
}
"""

with open('css/blog.css', 'w', encoding='utf-8') as f:
    f.write(blog_css)
print("css/blog.css updated")

# 6. css/ecommerce-page.css
ecommerce_css = """/* ==========================================================================
   E-COMMERCE MANAGEMENT PAGE STYLES (ecommerce-page.css)
   Futuristic Cyber E-Commerce Architecture
   ========================================================================== */

.ecom-page-wrapper {
  width: 100%;
  max-width: var(--container-max, 1200px);
  margin: 0 auto;
  padding-left: clamp(20px, 3.5vw, 36px);
  padding-right: clamp(20px, 3.5vw, 36px);
  box-sizing: border-box;
}

.rs-ecom-container {
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
  padding: 0;
  box-sizing: border-box;
}

.rs-ecom-hero {
  width: 100%;
  padding: calc(var(--header-height, 80px) + 36px) 0 56px;
  background: transparent;
  font-family: var(--font-body);
  border-bottom: 1px solid var(--border-color);
}

.rs-ecom-hero,
.rs-ecom-hero * {
  box-sizing: border-box;
}

.rs-ecom-grid {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 32px;
  align-items: stretch;
  width: 100%;
}

.rs-ecom-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  backdrop-filter: blur(20px);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-sm);
}

.rs-ecom-text-card {
  padding: 40px 36px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.rs-ecom-title {
  margin: 0 0 16px;
  font-family: var(--font-display);
  font-size: clamp(2.1rem, 3.6vw, 2.9rem);
  font-weight: 750;
  line-height: 1.12;
  letter-spacing: -0.025em;
  color: #FFFFFF;
}

.rs-ecom-subtitle {
  margin: 0 0 16px;
  font-size: clamp(1rem, 1.8vw, 1.1rem);
  font-weight: 600;
  line-height: 1.6;
  color: var(--accent-cyan);
}

.rs-ecom-desc {
  margin: 0 0 24px;
  font-size: 0.96rem;
  line-height: 1.7;
  color: var(--text-secondary);
}

.rs-ecom-btn {
  display: inline-flex;
  gap: 10px;
  width: fit-content;
  padding: 13px 28px;
  background: var(--gradient-cyber);
  color: #05070E !important;
  font-size: 0.92rem;
  font-weight: 800;
  line-height: 1;
  border-radius: var(--radius-pill);
  text-decoration: none;
  box-shadow: 0 0 20px rgba(0, 240, 255, 0.4);
  transition: all var(--transition-fast);
}

.rs-cta-button:hover,
.rs-ecom-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 35px rgba(0, 240, 255, 0.7);
  color: #05070E !important;
}

.rs-ecom-visual-card {
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: var(--bg-surface);
}

.rs-ecom-visual-card img {
  width: 100%;
  height: auto;
  max-height: 460px;
  object-fit: contain;
  border-radius: var(--radius-sm);
  background: rgba(5, 7, 14, 0.6);
}

.ecom-page-wrapper section {
  box-sizing: border-box;
}

/* CTA Card */
.rs-cta-container {
  max-width: 100%;
  margin: 0 auto;
  padding: 72px 0 88px;
}

.rs-cta-card {
  background: linear-gradient(135deg, rgba(13, 18, 32, 0.95) 0%, rgba(5, 7, 14, 0.98) 100%);
  border: 1px solid rgba(0, 240, 255, 0.35);
  border-radius: var(--radius-lg);
  padding: 56px 44px;
  max-width: 860px;
  margin: 0 auto;
  text-align: center;
  box-shadow: 0 0 40px rgba(0, 240, 255, 0.25);
}

.rs-cta-card h2 {
  font-family: var(--font-display);
  font-size: clamp(1.9rem, 3.2vw, 2.6rem);
  font-weight: 750;
  color: #FFFFFF;
  margin-bottom: 16px;
}

.rs-cta-text {
  font-size: 1.02rem;
  line-height: 1.72;
  color: var(--text-secondary);
  max-width: 660px;
  margin: 0 auto 28px;
}

.rs-cta-button {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 13px 30px;
  background: var(--gradient-cyber);
  color: #05070E !important;
  font-size: 0.94rem;
  font-weight: 800;
  border-radius: var(--radius-pill);
  text-decoration: none;
  box-shadow: 0 0 20px rgba(0, 240, 255, 0.4);
  transition: all var(--transition-fast);
}

.rs-cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 0 35px rgba(0, 240, 255, 0.7);
}

@media (max-width: 900px) {
  .rs-ecom-grid { grid-template-columns: 1fr; }
}
"""

with open('css/ecommerce-page.css', 'w', encoding='utf-8') as f:
    f.write(ecommerce_css)
print("css/ecommerce-page.css updated")

# 7. js/interactions.js
interactions_js = """/**
 * ADVANCED CYBER INTERACTIONS & MICRO-EXPERIENCES
 * - Glowing circular desktop cursor with smooth lag follower & magnetic scaling
 * - 3D Card tilt tracking on mousemove
 * - Animated statistics counters
 * - Magnetic buttons
 * - FAQ accordion
 * - Form validation & prefill
 */

document.addEventListener('DOMContentLoaded', () => {
  initCustomCursor();
  initMagneticButtons();
  init3DCardTilt();
  initStatsCounters();
  initFaqAccordion();
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
 * 1. Advanced Custom Glowing Cursor
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

    cursorDot.style.left = `${mouseX}px`;
    cursorDot.style.top = `${mouseY}px`;

    if (!isMoving) {
      isMoving = true;
      cursorDot.style.opacity = '1';
      cursorRing.style.opacity = '1';
    }
  });

  function renderCursor() {
    ringX += (mouseX - ringX) * 0.16;
    ringY += (mouseY - ringY) * 0.16;

    cursorRing.style.left = `${ringX}px`;
    cursorRing.style.top = `${ringY}px`;

    requestAnimationFrame(renderCursor);
  }
  requestAnimationFrame(renderCursor);

  const hoverables = document.querySelectorAll('a, button, input, select, textarea, .card, .arch-ledger-card, .slider-btn');
  hoverables.forEach(el => {
    el.addEventListener('mouseenter', () => cursorRing.classList.add('cursor-active'));
    el.addEventListener('mouseleave', () => cursorRing.classList.remove('cursor-active'));
  });

  document.addEventListener('mouseleave', () => {
    cursorDot.style.opacity = '0';
    cursorRing.style.opacity = '0';
    isMoving = false;
  });
}

/**
 * 2. Magnetic Buttons Effect
 */
function initMagneticButtons() {
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const magneticElements = document.querySelectorAll('.btn-magnetic, .hp-btn-primary, .arch-cta-btn, .brand-monogram');

  magneticElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      el.style.transform = `translate(${x * 0.22}px, ${y * 0.22}px)`;
    });

    el.addEventListener('mouseleave', () => {
      el.style.transform = 'translate(0px, 0px)';
      el.style.transition = 'transform 0.4s ease';
    });

    el.addEventListener('mouseenter', () => {
      el.style.transition = 'none';
    });
  });
}

/**
 * 3. 3D Card Tilt Effect on Mousemove
 */
function init3DCardTilt() {
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const cards = document.querySelectorAll('.card, .arch-ledger-card, .arch-kpi-card');

  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = ((y - centerY) / centerY) * -5;
      const rotateY = ((x - centerX) / centerX) * 5;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0px)';
      card.style.transition = 'transform 0.4s ease';
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
        entry.target.classList.add('glow-pulse');
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });

  statNumbers.forEach(num => observer.observe(num));
}

/**
 * 5. FAQ Accordion
 */
function initFaqAccordion() {
  const faqItems = document.querySelectorAll('.faq-item, .arch-faq-item, .rs-faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question, .arch-faq-question, .rs-faq-question');
    if (!questionBtn) return;

    questionBtn.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('active');
          const otherBtn = otherItem.querySelector('.faq-question, .arch-faq-question, .rs-faq-question');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        }
      });

      if (isActive) {
        item.classList.remove('active');
        questionBtn.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('active');
        questionBtn.setAttribute('aria-expanded', 'true');
      }
    });
  });
}

/**
 * 6. Contact Form Validation
 */
function initContactForm() {
  const form = document.getElementById('consultation-form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        isValid = false;
        field.classList.add('is-invalid');
      } else {
        field.classList.remove('is-invalid');
      }
    });

    if (!isValid) {
      e.preventDefault();
    }
  });
}
"""

with open('js/interactions.js', 'w', encoding='utf-8') as f:
    f.write(interactions_js)
print("js/interactions.js updated with cyber interactions & 3D tilt")
