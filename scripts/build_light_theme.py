# -*- coding: utf-8 -*-
"""
LIGHT THEME BUILDER SCRIPT - RITWIK SACHDEVA
Transforms entire website to:
- Strict Light Theme (#FFFFFF primary, #F3F6FF secondary, #171B2D primary text, #626B7D secondary text)
- Brand Colors: Electric Blue (#315EFA), Violet (#7654E8), Accent Orange (#FF9B54)
- Typography: Manrope (Headings), Inter (Body)
- High-energy micro-interactions: Cursor, Magnetic Buttons, 3D Tilt, Floating Widgets, Growth Sparklines
- 100% Content & Technology Lock
"""

import os
import re

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

# ==============================================================================
# 1. css/style.css (Core Light Theme Tokens, Navigation, Footer, Base)
# ==============================================================================
STYLE_CSS = """/* ==========================================================================
   RITWIK SACHDEVA — PREMIUM DIGITAL MARKETING EXPERT
   Visual Identity: Strict Light Theme (#FFFFFF & #F3F6FF), 
                    Electric Blue (#315EFA), Violet (#7654E8), Accent Orange (#FF9B54)
   Typography: Manrope (Headings) & Inter (Body)
   Aesthetic: High-Energy, Sophisticated, International Digital Strategy Consultancy
   ========================================================================== */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap');

/* ==========================================================================
   1. DESIGN TOKENS & LIGHT FOUNDATIONS
   ========================================================================== */
:root {
  /* Strict Light Theme Backgrounds */
  --bg-canvas: #FFFFFF;
  --bg-primary: #FFFFFF;
  --bg-surface: #FFFFFF;
  --bg-secondary: #F3F6FF;
  --bg-surface-elevated: #FFFFFF;
  --bg-subtle: #F8FAFC;
  --bg-glass: rgba(255, 255, 255, 0.88);
  --bg-card: #FFFFFF;
  --bg-card-alt: #F8FAFF;

  /* Typography Colors */
  --text-primary: #171B2D;
  --text-secondary: #626B7D;
  --text-muted: #8892A4;
  --text-subtle: #A0ABC0;
  --text-inverse: #FFFFFF;

  /* Vibrant Brand Accents */
  --electric-blue: #315EFA;
  --electric-blue-hover: #214BD9;
  --electric-blue-light: rgba(49, 94, 250, 0.08);
  --electric-blue-glow: rgba(49, 94, 250, 0.25);

  --violet: #7654E8;
  --violet-hover: #603ec9;
  --violet-light: rgba(118, 84, 232, 0.08);
  --violet-glow: rgba(118, 84, 232, 0.25);

  --accent-orange: #FF9B54;
  --accent-orange-light: rgba(255, 155, 84, 0.12);

  --accent-primary: #315EFA;
  --accent-secondary: #7654E8;
  --accent-hover: #214BD9;
  --accent-light: rgba(49, 94, 250, 0.08);

  /* Gradients */
  --gradient-primary: linear-gradient(135deg, #315EFA 0%, #7654E8 100%);
  --gradient-hero: linear-gradient(135deg, #315EFA 0%, #7654E8 60%, #FF9B54 100%);
  --gradient-subtle: linear-gradient(135deg, rgba(49, 94, 250, 0.05) 0%, rgba(118, 84, 232, 0.05) 100%);
  --gradient-card: linear-gradient(180deg, #FFFFFF 0%, #F8FAFF 100%);
  --gradient-accent: linear-gradient(135deg, #7654E8 0%, #FF9B54 100%);

  /* Borders & Dividers */
  --border-color: #E2E8F4;
  --border-subtle: #EDF2F9;
  --border-strong: #CBD5E1;
  --border-glow-blue: rgba(49, 94, 250, 0.3);
  --border-glow-violet: rgba(118, 84, 232, 0.3);

  /* Status Colors */
  --success: #10B981;
  --warning: #F59E0B;
  --error: #EF4444;

  /* Typography Families */
  --font-display: 'Manrope', 'Plus Jakarta Sans', sans-serif;
  --font-heading: 'Manrope', 'Plus Jakarta Sans', sans-serif;
  --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-mono: 'JetBrains Mono', Consolas, monospace;
  --font-serif: 'Manrope', sans-serif;

  /* Geometry & Radii */
  --radius-xs: 4px;
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-xl: 22px;
  --radius-pill: 9999px;
  --radius-full: 9999px;

  /* High-Performance Light Shadows */
  --shadow-sm: 0 2px 6px rgba(23, 27, 45, 0.04);
  --shadow-card: 0 10px 28px -4px rgba(23, 27, 45, 0.06), 0 0 1px 1px rgba(226, 232, 244, 0.8);
  --shadow-hover: 0 20px 40px -10px rgba(49, 94, 250, 0.15), 0 0 0 1px rgba(49, 94, 250, 0.2);
  --shadow-navbar: 0 4px 20px rgba(23, 27, 45, 0.05);
  --shadow-glow: 0 8px 30px rgba(49, 94, 250, 0.22);
  --shadow-elevated: 0 24px 48px -12px rgba(23, 27, 45, 0.1);

  /* Layout Containers */
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
  background-color: var(--bg-canvas);
  color: var(--text-primary);
  line-height: 1.65;
  overflow-x: hidden;
  position: relative;
  min-height: 100vh;
}

/* Selection highlight */
::selection {
  background-color: var(--electric-blue);
  color: #FFFFFF;
}

img, svg, video {
  max-width: 100%;
  height: auto;
  display: block;
}

a {
  color: var(--accent-primary);
  text-decoration: none;
  transition: color var(--transition-fast), border-color var(--transition-fast);
}

a:hover {
  color: var(--electric-blue-hover);
}

button {
  font-family: inherit;
  cursor: pointer;
  border: none;
  background: none;
}

/* ==========================================================================
   3. TYPOGRAPHY SYSTEM
   ========================================================================== */
h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-heading);
  color: var(--text-primary);
  font-weight: 750;
  line-height: 1.2;
  letter-spacing: -0.025em;
}

h1 {
  font-size: clamp(2.4rem, 4.2vw, 3.8rem);
  font-weight: 800;
  line-height: 1.12;
  letter-spacing: -0.035em;
}

h2 {
  font-size: clamp(1.85rem, 3.2vw, 2.75rem);
  font-weight: 750;
  line-height: 1.18;
  letter-spacing: -0.025em;
}

h3 {
  font-size: clamp(1.35rem, 2.2vw, 1.85rem);
  font-weight: 700;
  line-height: 1.25;
}

h4 {
  font-size: 1.2rem;
  font-weight: 650;
  line-height: 1.35;
}

p {
  color: var(--text-secondary);
  font-size: 1rem;
  line-height: 1.68;
}

.text-gradient,
.gradient-text {
  background: var(--gradient-primary);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

.text-muted {
  color: var(--text-muted);
}

.mono-tag {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--electric-blue);
  background: var(--electric-blue-light);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border: 1px solid rgba(49, 94, 250, 0.2);
}

/* ==========================================================================
   4. CONTAINER CONSTRAINTS & LIGHT AMBIENT CANVAS
   ========================================================================== */
.container,
.hp-container,
.services-container,
.blog-container,
.ecom-container {
  width: 100%;
  max-width: var(--container-max);
  margin-left: auto;
  margin-right: auto;
  padding-left: clamp(18px, 3.5vw, 32px);
  padding-right: clamp(18px, 3.5vw, 32px);
  box-sizing: border-box;
}

.container-narrow {
  max-width: var(--container-narrow);
}

.section {
  padding: var(--section-spacing) 0;
  position: relative;
  background-color: var(--bg-canvas);
}

.section-bg-alt {
  background-color: var(--bg-secondary);
}

/* Light Ambient Layer */
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
  filter: blur(120px);
  opacity: 0.07;
  pointer-events: none;
}

.ambient-glow-1 {
  width: 600px;
  height: 600px;
  background: radial-gradient(circle, var(--electric-blue) 0%, transparent 70%);
  top: -120px;
  right: -80px;
}

.ambient-glow-2 {
  width: 550px;
  height: 550px;
  background: radial-gradient(circle, var(--violet) 0%, transparent 70%);
  bottom: 10%;
  left: -100px;
}

.grid-pattern-overlay {
  position: absolute;
  inset: 0;
  background-image: 
    linear-gradient(to right, rgba(49, 94, 250, 0.03) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(49, 94, 250, 0.03) 1px, transparent 1px);
  background-size: 54px 54px;
  mask-image: radial-gradient(circle at center, black 50%, transparent 95%);
  -webkit-mask-image: radial-gradient(circle at center, black 50%, transparent 95%);
}

/* Scroll Progress Indicator Bar */
#scroll-progress {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  width: 0%;
  background: var(--gradient-hero);
  box-shadow: 0 0 10px rgba(49, 94, 250, 0.5);
  z-index: 9999;
  transition: width 0.1s linear;
}

/* ==========================================================================
   5. LIGHT THEME NAVIGATION (HEADER)
   ========================================================================== */
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: var(--header-height);
  z-index: 1000;
  background: rgba(255, 255, 255, 0.88);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border-color);
  transition: height var(--transition-fast), background-color var(--transition-fast), box-shadow var(--transition-fast);
}

.site-header.scrolled {
  height: 70px;
  background: rgba(255, 255, 255, 0.98);
  box-shadow: var(--shadow-navbar);
  border-bottom: 1px solid rgba(49, 94, 250, 0.15);
}

.nav-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}

/* Brand Logo */
.brand-logo {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  color: var(--text-primary);
}

.brand-monogram {
  width: 42px;
  height: 42px;
  background: var(--gradient-primary);
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  font-family: var(--font-display);
  font-weight: 800;
  font-size: 1rem;
  letter-spacing: -0.02em;
  box-shadow: 0 4px 14px rgba(49, 94, 250, 0.35);
  transition: all var(--transition-fast);
}

.brand-logo:hover .brand-monogram {
  transform: translateY(-2px) scale(1.04);
  box-shadow: 0 8px 20px rgba(49, 94, 250, 0.45);
}

.brand-info {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-family: var(--font-heading);
  line-height: 1.15;
  font-size: 1.12rem;
  font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -0.02em;
}

.brand-title {
  font-size: 0.72rem;
  font-family: var(--font-body);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--electric-blue);
  font-weight: 600;
}

/* Navigation Links */
.nav-links {
  display: flex;
  align-items: center;
  gap: 32px;
  list-style: none;
}

.nav-link {
  font-family: var(--font-body);
  font-size: 0.94rem;
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
  color: var(--electric-blue);
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0%;
  height: 2px;
  background: var(--gradient-primary);
  border-radius: 2px;
  transition: width var(--transition-fast);
}

.nav-link:hover::after,
.nav-link.active::after {
  width: 100%;
}

/* Dropdown Menu */
.nav-dropdown {
  position: relative;
}

.nav-dropdown-menu {
  position: absolute;
  top: 100%;
  left: -20px;
  width: 320px;
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 12px;
  box-shadow: var(--shadow-elevated);
  opacity: 0;
  visibility: hidden;
  transform: translateY(12px);
  transition: all var(--transition-fast);
  z-index: 1010;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-dropdown:hover .nav-dropdown-menu,
.nav-dropdown:focus-within .nav-dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.nav-dropdown-link {
  font-size: 0.88rem;
  color: var(--text-secondary);
  padding: 8px 12px;
  border-radius: var(--radius-sm);
  transition: all var(--transition-fast);
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.nav-dropdown-link:hover {
  background: var(--bg-secondary);
  color: var(--electric-blue);
  transform: translateX(4px);
}

/* Mobile Hamburger Toggle */
.mobile-toggle {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 6px;
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: var(--bg-secondary);
  border: 1px solid var(--border-color);
  padding: 10px;
  cursor: pointer;
  z-index: 1005;
}

.mobile-toggle span {
  display: block;
  width: 100%;
  height: 2px;
  background-color: var(--text-primary);
  border-radius: 2px;
  transition: all var(--transition-fast);
}

.mobile-toggle.active span:nth-child(1) {
  transform: translateY(8px) rotate(45deg);
}
.mobile-toggle.active span:nth-child(2) {
  opacity: 0;
}
.mobile-toggle.active span:nth-child(3) {
  transform: translateY(-8px) rotate(-45deg);
}

/* Mobile Drawer */
.mobile-drawer {
  position: fixed;
  inset: 0;
  background: #FFFFFF;
  z-index: 999;
  display: flex;
  flex-direction: column;
  padding: calc(var(--header-height) + 24px) 24px 36px;
  transform: translateX(100%);
  transition: transform var(--transition-smooth);
  overflow-y: auto;
}

.mobile-drawer.open {
  transform: translateX(0);
}

.mobile-nav-links {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 32px;
}

.mobile-link {
  font-family: var(--font-heading);
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--text-primary);
  text-decoration: none;
  padding: 8px 0;
  border-bottom: 1px solid var(--border-subtle);
}

.mobile-link:hover {
  color: var(--electric-blue);
}

.mobile-sublinks {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding-left: 16px;
  margin-top: 10px;
}

.mobile-sublink {
  font-size: 0.95rem;
  color: var(--text-secondary);
  text-decoration: none;
}

.mobile-sublink:hover {
  color: var(--electric-blue);
}

/* ==========================================================================
   6. HIGH-ENERGY BUTTONS (MAGNETIC & GRADIENTS)
   ========================================================================== */
.btn,
.hp-btn,
.rs-ecom-btn,
.arch-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  font-family: var(--font-body);
  font-size: 0.96rem;
  font-weight: 700;
  padding: 14px 28px;
  border-radius: var(--radius-sm);
  text-decoration: none;
  transition: all var(--transition-fast);
  cursor: pointer;
  position: relative;
  overflow: hidden;
  white-space: nowrap;
}

/* Primary Button */
.btn-primary,
.hp-btn-primary,
.rs-ecom-btn,
.arch-cta-btn {
  background: var(--gradient-primary);
  color: #FFFFFF !important;
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 6px 20px rgba(49, 94, 250, 0.35);
}

.btn-primary:hover,
.hp-btn-primary:hover,
.rs-ecom-btn:hover,
.arch-cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(49, 94, 250, 0.5);
  color: #FFFFFF !important;
}

/* Secondary / Outline Button */
.btn-secondary,
.btn-outline,
.hp-btn-secondary {
  background: #FFFFFF;
  color: var(--text-primary) !important;
  border: 1px solid var(--border-color);
  box-shadow: var(--shadow-sm);
}

.btn-secondary:hover,
.btn-outline:hover,
.hp-btn-secondary:hover {
  background: var(--bg-secondary);
  border-color: var(--electric-blue);
  color: var(--electric-blue) !important;
  transform: translateY(-2px);
}

.btn-lg {
  padding: 16px 34px;
  font-size: 1.05rem;
}

.btn-sm {
  padding: 8px 18px;
  font-size: 0.85rem;
}

/* Button Icon Animation */
.btn-icon-right {
  display: inline-flex;
  transition: transform var(--transition-fast);
}

.btn:hover .btn-icon-right,
.hp-btn:hover .btn-icon-right {
  transform: translateX(4px);
}

/* ==========================================================================
   7. STRICT LIGHT THEME FOOTER
   ========================================================================== */
.site-footer {
  background-color: var(--bg-secondary);
  color: var(--text-secondary);
  border-top: 1px solid var(--border-color);
  padding: 80px 0 32px 0;
  position: relative;
  overflow: hidden;
}

.site-footer::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: var(--gradient-primary);
}

.site-footer a {
  color: var(--text-secondary);
  text-decoration: none;
  transition: color var(--transition-fast);
}

.site-footer a:hover {
  color: var(--electric-blue);
}

.footer-grid {
  display: grid;
  grid-template-columns: 1.4fr 0.9fr 1.3fr 1fr;
  gap: 48px;
  margin-bottom: 56px;
}

.footer-brand-statement {
  font-size: 0.92rem;
  color: var(--text-secondary);
  line-height: 1.7;
  margin-top: 18px;
  max-width: 360px;
}

.site-footer .brand-name {
  color: var(--text-primary);
}

.footer-heading {
  font-family: var(--font-heading);
  font-size: 0.95rem;
  font-weight: 750;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text-primary);
  margin-bottom: 20px;
}

.footer-links {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer-links li a {
  font-size: 0.92rem;
  display: inline-flex;
  align-items: center;
  transition: all var(--transition-fast);
}

.footer-links li a:hover {
  color: var(--electric-blue);
  transform: translateX(4px);
}

.footer-bottom {
  border-top: 1px solid var(--border-color);
  padding-top: 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.88rem;
  color: var(--text-muted);
}

.back-to-top-btn {
  font-size: 0.85rem;
  font-weight: 600;
  color: var(--electric-blue);
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.back-to-top-btn:hover {
  background: var(--electric-blue);
  color: #FFFFFF;
  border-color: var(--electric-blue);
  transform: translateY(-2px);
}

/* ==========================================================================
   8. FORMS & INPUT ARCHITECTURE
   ========================================================================== */
.form-group {
  margin-bottom: 22px;
}

.form-label {
  display: block;
  font-family: var(--font-body);
  font-size: 0.88rem;
  font-weight: 650;
  color: var(--text-primary);
  margin-bottom: 8px;
}

.form-control,
input[type="text"],
input[type="email"],
input[type="tel"],
input[type="url"],
select,
textarea {
  width: 100%;
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 13px 16px;
  font-family: var(--font-body);
  font-size: 0.95rem;
  color: var(--text-primary);
  transition: all var(--transition-fast);
  box-shadow: var(--shadow-sm);
}

.form-control:focus,
input:focus,
select:focus,
textarea:focus {
  outline: none;
  border-color: var(--electric-blue);
  box-shadow: 0 0 0 3px rgba(49, 94, 250, 0.15);
}

textarea {
  resize: vertical;
  min-height: 120px;
}

/* ==========================================================================
   9. CUSTOM ANIMATED CURSOR (LIGHT THEME)
   ========================================================================== */
.custom-cursor-dot {
  position: fixed;
  top: 0;
  left: 0;
  width: 8px;
  height: 8px;
  background-color: var(--electric-blue);
  border-radius: 50%;
  pointer-events: none;
  z-index: 99999;
  transform: translate(-50%, -50%);
  transition: opacity 0.2s ease;
}

.custom-cursor-ring {
  position: fixed;
  top: 0;
  left: 0;
  width: 36px;
  height: 36px;
  border: 2px solid rgba(49, 94, 250, 0.5);
  background-color: rgba(49, 94, 250, 0.04);
  border-radius: 50%;
  pointer-events: none;
  z-index: 99998;
  transform: translate(-50%, -50%);
  transition: width 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
              height 0.25s cubic-bezier(0.16, 1, 0.3, 1), 
              background-color 0.25s ease, 
              border-color 0.25s ease;
  box-shadow: 0 0 14px rgba(49, 94, 250, 0.2);
}

.custom-cursor-ring.cursor-active {
  width: 56px;
  height: 56px;
  border-color: var(--violet);
  background-color: rgba(118, 84, 232, 0.1);
  box-shadow: 0 0 20px rgba(118, 84, 232, 0.3);
}

/* ==========================================================================
   10. COMMON EDITORIAL & INTERACTIVE COMPONENTS
   ========================================================================== */
.card,
.arch-card,
.arch-ledger-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 32px;
  box-shadow: var(--shadow-card);
  transition: transform var(--transition-fast), box-shadow var(--transition-fast), border-color var(--transition-fast);
}

.card:hover,
.arch-card:hover,
.arch-ledger-card:hover {
  transform: translateY(-4px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-hover);
}

.section-tag {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: var(--electric-blue);
  background: var(--electric-blue-light);
  border: 1px solid rgba(49, 94, 250, 0.25);
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 16px;
}

.section-title {
  margin-bottom: 20px;
}
"""

with open("css/style.css", "w", encoding="utf-8") as f:
    f.write(STYLE_CSS)
print("Updated css/style.css (Strict Light Theme)")

# ==============================================================================
# 2. css/animations.css (Light Theme Keyframes, Shimmer, Floats, Progress)
# ==============================================================================
ANIMATIONS_CSS = """/* ==========================================================================
   HIGH-ENERGY ANIMATION & INTERACTION ENGINE (LIGHT THEME)
   GPU-accelerated transforms, vibrant gradient shimmers, and light glows
   ========================================================================== */

/* Ambient Pulse for Light Meshes */
@keyframes light-ambient-pulse {
  0%, 100% {
    transform: scale(1) translate(0, 0);
    opacity: 0.07;
  }
  50% {
    transform: scale(1.12) translate(15px, -15px);
    opacity: 0.12;
  }
}

.ambient-glow-1 {
  animation: light-ambient-pulse 14s ease-in-out infinite alternate;
}

.ambient-glow-2 {
  animation: light-ambient-pulse 18s ease-in-out infinite alternate-reverse;
}

/* Vibrant Light-Theme Gradient Shimmer */
@keyframes gradient-shimmer {
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
  background: linear-gradient(90deg, #315EFA, #7654E8, #FF9B54, #315EFA);
  background-size: 300% 300%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: gradient-shimmer 7s ease infinite;
  display: inline-block;
}

/* Floating Marketing Analytics Widgets */
@keyframes widget-float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-8px);
  }
}

.floating-widget-1 {
  animation: widget-float 5s ease-in-out infinite;
}

.floating-widget-2 {
  animation: widget-float 6.5s ease-in-out infinite 1s;
}

/* Growth Chart Sparkline Dash Animation */
@keyframes sparkline-draw {
  0% {
    stroke-dashoffset: 200;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

.animated-sparkline {
  stroke-dasharray: 200;
  stroke-dashoffset: 200;
  animation: sparkline-draw 2.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Scroll-Triggered Reveals */
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

/* Mouse-following ambient lighting overlay */
.mouse-gradient-light {
  position: absolute;
  inset: 0;
  pointer-events: none;
  background: radial-gradient(600px circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(49, 94, 250, 0.06), transparent 70%);
  z-index: 1;
}

/* Reduced motion preference */
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
"""

with open("css/animations.css", "w", encoding="utf-8") as f:
    f.write(ANIMATIONS_CSS)
print("Updated css/animations.css (High-Energy Light Theme Animations)")

# ==============================================================================
# 3. css/home-live.css (Complete Homepage Sections in Strict Light Theme)
# ==============================================================================
HOME_LIVE_CSS = """/* ==========================================================================
   HOMEPAGE ARCHITECTURAL STYLESHEET (home-live.css)
   Strict Light Theme: Modern International Digital Strategy Consultancy
   Primary Background: #FFFFFF | Secondary: #F3F6FF
   Primary Text: #171B2D | Secondary Text: #626B7D
   Accents: Electric Blue (#315EFA) & Violet (#7654E8) & Orange (#FF9B54)
   ========================================================================== */

#main-content {
  width: 100%;
  max-width: var(--container-max, 1200px);
  margin: 0 auto;
  padding-left: clamp(18px, 3.5vw, 32px);
  padding-right: clamp(18px, 3.5vw, 32px);
  box-sizing: border-box;
}

.hp-container {
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
  padding: 0;
  box-sizing: border-box;
}

/* ==========================================================================
   HERO SECTION (STRIKING LIGHT THEME)
   ========================================================================== */
#hero {
  padding: calc(var(--header-height, 80px) + 40px) 0 76px;
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
  margin-bottom: 20px;
}

.hp-hero-kicker {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: var(--electric-blue);
  background: var(--electric-blue-light);
  border: 1px solid rgba(49, 94, 250, 0.25);
  padding: 6px 16px;
  border-radius: var(--radius-pill);
  box-shadow: 0 2px 8px rgba(49, 94, 250, 0.12);
}

#hero .hp-h1 {
  font-family: var(--font-display);
  font-size: clamp(2.4rem, 4.2vw, 3.8rem);
  font-weight: 800;
  line-height: 1.12;
  letter-spacing: -0.035em;
  color: var(--text-primary);
  margin-bottom: 20px;
}

.hero-description {
  font-size: 1.12rem;
  line-height: 1.7;
  color: var(--text-secondary);
  margin-bottom: 32px;
  max-width: 620px;
}

.hp-hero-actions-row {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 40px;
}

/* Stats Ledger Cards */
.hp-hero-stats-ledger {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  padding-top: 32px;
  border-top: 1px solid var(--border-color);
}

.hp-stat-ledger-item {
  display: flex;
  flex-direction: column;
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  padding: 16px 20px;
  border-radius: var(--radius-sm);
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.hp-stat-ledger-item:hover {
  transform: translateY(-3px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-card);
}

.hp-stat-number {
  font-family: var(--font-display);
  font-size: 1.95rem;
  font-weight: 800;
  line-height: 1.1;
  background: var(--gradient-primary);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
  margin-bottom: 4px;
}

.hp-stat-label {
  font-family: var(--font-body);
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--text-secondary);
  line-height: 1.35;
}

/* Hero Visual Composition Frame */
.hp-hero-visual-column {
  position: relative;
}

.hp-visual-composition-frame {
  position: relative;
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-lg);
  padding: 14px;
  box-shadow: var(--shadow-card);
  transition: all var(--transition-smooth);
}

.hp-visual-composition-frame:hover {
  box-shadow: var(--shadow-hover);
  border-color: rgba(49, 94, 250, 0.25);
}

.hp-visual-composition-frame img {
  width: 100%;
  height: auto;
  aspect-ratio: 1/1;
  object-fit: cover;
  border-radius: var(--radius-md);
  display: block;
}

/* Floating Marketing Dashboard Meta Chips */
.hp-floating-meta-chip {
  position: absolute;
  background: #FFFFFF;
  border: 1px solid rgba(49, 94, 250, 0.2);
  border-radius: var(--radius-sm);
  padding: 12px 18px;
  box-shadow: 0 12px 32px rgba(49, 94, 250, 0.15);
  z-index: 2;
}

.hp-chip-top {
  top: 18px;
  right: -12px;
}

.hp-chip-bottom {
  bottom: 18px;
  left: -12px;
}

.hp-chip-title {
  font-family: var(--font-mono);
  font-size: 0.68rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--electric-blue);
  margin-bottom: 4px;
}

.hp-chip-val {
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: 0.95rem;
  color: var(--text-primary);
}

/* ==========================================================================
   SECTION 1: WHAT A DIGITAL MARKETING CONSULTANT DOES
   ========================================================================== */
#what-consultant-does {
  padding: 88px 0;
  background-color: var(--bg-canvas);
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
  top: calc(var(--header-height) + 24px);
}

.arch-spread-index {
  font-family: var(--font-mono);
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  color: var(--electric-blue);
  background: var(--electric-blue-light);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  display: inline-block;
  margin-bottom: 16px;
  border: 1px solid rgba(49, 94, 250, 0.2);
}

.arch-spread-title {
  font-size: clamp(2rem, 3.2vw, 2.7rem);
  font-weight: 800;
  line-height: 1.18;
  color: var(--text-primary);
}

.arch-spread-body-wrap p {
  font-size: 1.05rem;
  line-height: 1.75;
  color: var(--text-secondary);
  margin-bottom: 24px;
}

/* Comparison Ledger Grid */
.arch-ledger-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-top: 36px;
}

.arch-ledger-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 28px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.arch-ledger-card:hover {
  transform: translateY(-4px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-card);
}

.arch-ledger-tag {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--violet);
  margin-bottom: 12px;
}

.arch-ledger-card h3 {
  font-size: 1.25rem;
  font-weight: 750;
  margin-bottom: 12px;
  color: var(--text-primary);
}

.arch-ledger-card p {
  font-size: 0.95rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin-bottom: 0;
}

/* ==========================================================================
   SECTION 2: DIGITAL MARKETING SERVICES IN DELHI
   ========================================================================== */
#services {
  padding: 88px 0;
  background-color: var(--bg-secondary);
  border-bottom: 1px solid var(--border-color);
}

.hp-services-deck {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 40px;
}

.hp-service-slab {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 28px 32px;
  display: grid;
  grid-template-columns: 0.8fr 1.6fr 0.6fr;
  align-items: center;
  gap: 32px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.hp-service-slab:hover {
  transform: translateY(-3px);
  border-color: rgba(49, 94, 250, 0.35);
  box-shadow: var(--shadow-hover);
}

.hp-slab-left h3 {
  font-size: 1.25rem;
  font-weight: 750;
  color: var(--text-primary);
  margin-bottom: 6px;
}

.hp-slab-left a {
  color: var(--text-primary);
  text-decoration: none;
}

.hp-slab-left a:hover {
  color: var(--electric-blue);
}

.hp-slab-desc {
  font-size: 0.96rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

.hp-slab-action {
  display: flex;
  justify-content: flex-end;
}

.hp-slab-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--electric-blue);
  text-decoration: none;
  padding: 8px 18px;
  border: 1px solid rgba(49, 94, 250, 0.25);
  border-radius: var(--radius-pill);
  background: var(--electric-blue-light);
  transition: all var(--transition-fast);
}

.hp-slab-link:hover {
  background: var(--electric-blue);
  color: #FFFFFF;
  border-color: var(--electric-blue);
  transform: translateX(4px);
}

/* ==========================================================================
   SECTION 3: WHO THIS IS FOR
   ========================================================================== */
#who-for {
  padding: 88px 0;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.arch-kpi-quad {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-top: 36px;
}

.arch-kpi-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 32px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.arch-kpi-card:hover {
  transform: translateY(-4px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-card);
}

.arch-kpi-index {
  font-family: var(--font-mono);
  font-size: 0.8rem;
  font-weight: 700;
  color: var(--electric-blue);
  margin-bottom: 14px;
}

.arch-kpi-card h3 {
  font-size: 1.3rem;
  font-weight: 750;
  color: var(--text-primary);
  margin-bottom: 12px;
}

.arch-kpi-card p {
  font-size: 0.96rem;
  color: var(--text-secondary);
  line-height: 1.68;
  margin: 0;
}

/* ==========================================================================
   SECTION 4: CHOOSING A DIGITAL MARKETING CONSULTANT
   ========================================================================== */
#choosing-consultant {
  padding: 88px 0;
  background-color: var(--bg-secondary);
  border-bottom: 1px solid var(--border-color);
}

/* ==========================================================================
   SECTION 5: RESULTS-FOCUSED DIGITAL MARKETING
   ========================================================================== */
#results-focused-marketing {
  padding: 88px 0;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.hp-framework-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 36px;
}

.hp-framework-col {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 28px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.hp-framework-col:hover {
  transform: translateY(-4px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-card);
}

.hp-col-num {
  font-family: var(--font-mono);
  font-size: 0.8rem;
  font-weight: 700;
  color: var(--violet);
  margin-bottom: 14px;
}

.hp-framework-col h3 {
  font-size: 1.25rem;
  font-weight: 750;
  color: var(--text-primary);
  margin-bottom: 12px;
}

.hp-framework-col p {
  font-size: 0.95rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* ==========================================================================
   SECTION 6: TRUSTED BY BUSINESSES SEARCHING FOR
   ========================================================================== */
#trusted-businesses-searching {
  padding: 88px 0;
  background-color: var(--bg-secondary);
  border-bottom: 1px solid var(--border-color);
}

.hp-queries-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 36px;
}

.hp-query-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 24px;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.hp-query-card:hover {
  transform: translateY(-3px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-card);
}

.hp-query-card h3 {
  font-size: 1.15rem;
  font-weight: 750;
  color: var(--text-primary);
  margin-bottom: 8px;
}

.hp-query-card p {
  font-size: 0.94rem;
  color: var(--text-secondary);
  line-height: 1.62;
  margin: 0;
}

/* ==========================================================================
   SECTION 7: FREQUENTLY ASKED QUESTIONS (ACCORDION)
   ========================================================================== */
#dm-faq {
  padding: 88px 0;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.hp-faq-accordion {
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin-top: 36px;
  max-width: 900px;
}

.faq-item {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.faq-item:hover {
  border-color: rgba(49, 94, 250, 0.3);
}

.faq-item.active {
  border-color: var(--electric-blue);
  box-shadow: 0 4px 18px rgba(49, 94, 250, 0.1);
}

.faq-question {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px;
  text-align: left;
  background: none;
  border: none;
  font-family: var(--font-heading);
  font-size: 1.08rem;
  font-weight: 750;
  color: var(--text-primary);
  cursor: pointer;
  gap: 16px;
  transition: color var(--transition-fast);
}

.faq-question:hover {
  color: var(--electric-blue);
}

.faq-icon {
  font-size: 1.3rem;
  font-weight: 400;
  color: var(--electric-blue);
  transition: transform var(--transition-fast);
  line-height: 1;
}

.faq-item.active .faq-icon {
  transform: rotate(45deg);
}

.faq-answer {
  display: none;
  padding: 0 24px 22px 24px;
  font-size: 0.98rem;
  line-height: 1.7;
  color: var(--text-secondary);
}

.faq-item.active .faq-answer {
  display: block;
}

/* ==========================================================================
   SECTION 8: EXECUTIVE BRIEFING CTA (LIGHT HIGH-ENERGY BOX)
   ========================================================================== */
#cta-consultant-delhi {
  padding: 80px 0 96px;
  background-color: var(--bg-canvas);
}

.hp-cta-editorial-box {
  background: linear-gradient(135deg, rgba(49, 94, 250, 0.05) 0%, rgba(118, 84, 232, 0.05) 100%), #FFFFFF;
  border: 1px solid rgba(49, 94, 250, 0.25);
  border-radius: var(--radius-lg);
  padding: 60px 48px;
  text-align: center;
  box-shadow: var(--shadow-card);
  position: relative;
  overflow: hidden;
}

.hp-cta-editorial-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: var(--gradient-primary);
}

.hp-cta-kicker {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: var(--electric-blue);
  background: var(--electric-blue-light);
  padding: 6px 16px;
  border-radius: var(--radius-pill);
  display: inline-block;
  margin-bottom: 18px;
  border: 1px solid rgba(49, 94, 250, 0.25);
}

.hp-cta-title {
  font-size: clamp(2rem, 3.4vw, 2.85rem);
  font-weight: 800;
  line-height: 1.18;
  color: var(--text-primary);
  margin-bottom: 18px;
}

.hp-cta-desc {
  font-size: 1.1rem;
  line-height: 1.7;
  color: var(--text-secondary);
  max-width: 680px;
  margin: 0 auto 36px auto;
}
"""

with open("css/home-live.css", "w", encoding="utf-8") as f:
    f.write(HOME_LIVE_CSS)
print("Updated css/home-live.css (Strict Light Theme Homepage)")

# ==============================================================================
# 4. css/services.css (Services Catalog & Details in Strict Light Theme)
# ==============================================================================
SERVICES_CSS = """/* ==========================================================================
   SERVICES DIRECTORY & DETAIL STYLES (Strict Light Theme)
   Primary Background: #FFFFFF | Secondary: #F3F6FF
   Primary Text: #171B2D | Secondary Text: #626B7D | Electric Blue: #315EFA
   ========================================================================== */

.services-hero {
  padding-top: calc(var(--header-height) + 40px);
  padding-bottom: 48px;
  background-color: var(--bg-canvas);
  border-bottom: 1px solid var(--border-color);
}

.services-metrics-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 40px;
  padding-top: 32px;
  border-top: 1px solid var(--border-color);
}

.metric-strip-item {
  display: flex;
  flex-direction: column;
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  padding: 18px 20px;
  border-radius: var(--radius-sm);
  box-shadow: var(--shadow-sm);
  transition: all var(--transition-fast);
}

.metric-strip-item:hover {
  transform: translateY(-3px);
  border-color: rgba(49, 94, 250, 0.3);
  box-shadow: var(--shadow-card);
}

.metric-strip-val {
  font-family: var(--font-display);
  font-size: clamp(2rem, 3vw, 2.6rem);
  font-weight: 800;
  line-height: 1.1;
  margin-bottom: 4px;
  background: var(--gradient-primary);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

.metric-strip-label {
  font-family: var(--font-body);
  font-size: 0.82rem;
  font-weight: 600;
  color: var(--text-secondary);
}

/* Services Directory Grid */
.services-catalog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap: 28px;
  margin-top: 48px;
}

.service-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 32px;
  box-shadow: var(--shadow-card);
  transition: all var(--transition-fast);
  display: flex;
  flex-direction: column;
}

.service-card:hover {
  transform: translateY(-4px);
  border-color: rgba(49, 94, 250, 0.35);
  box-shadow: var(--shadow-hover);
}

.service-card-tag {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--electric-blue);
  margin-bottom: 12px;
}

.service-card-title {
  font-size: 1.35rem;
  font-weight: 750;
  color: var(--text-primary);
  margin-bottom: 12px;
}

.service-card-desc {
  font-size: 0.96rem;
  color: var(--text-secondary);
  line-height: 1.68;
  margin-bottom: 24px;
  flex-grow: 1;
}

.service-card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 18px;
  border-top: 1px solid var(--border-subtle);
}

.service-card-link {
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--electric-blue);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: transform var(--transition-fast);
}

.service-card-link:hover {
  transform: translateX(4px);
  color: var(--electric-blue-hover);
}
"""

with open("css/services.css", "w", encoding="utf-8") as f:
    f.write(SERVICES_CSS)
print("Updated css/services.css (Strict Light Theme Services)")

# ==============================================================================
# 5. css/ecommerce-page.css (E-Commerce Page in Strict Light Theme)
# ==============================================================================
ECOM_CSS = """/* ==========================================================================
   E-COMMERCE MANAGEMENT PAGE STYLES (ecommerce-page.css)
   Strict Light Theme: Clean White & Soft Blue (#F3F6FF)
   ========================================================================== */

.ecom-page-wrapper {
  width: 100%;
  max-width: var(--container-max, 1200px);
  margin: 0 auto;
  padding-left: clamp(18px, 3.5vw, 32px);
  padding-right: clamp(18px, 3.5vw, 32px);
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
  border-bottom: 1px solid var(--border-color);
}

.rs-ecom-grid {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: 40px;
  align-items: center;
}

.rs-ecom-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  padding: 36px;
  box-shadow: var(--shadow-card);
}

.rs-ecom-title {
  font-family: var(--font-display);
  font-size: clamp(2rem, 3.5vw, 2.75rem);
  font-weight: 800;
  line-height: 1.18;
  color: var(--text-primary);
  margin-bottom: 18px;
}

.rs-ecom-subtitle {
  font-size: 1.08rem;
  line-height: 1.7;
  color: var(--text-secondary);
  margin-bottom: 16px;
}

.rs-ecom-desc {
  font-size: 1.02rem;
  line-height: 1.68;
  color: var(--text-secondary);
  margin-bottom: 28px;
}

.rs-ecom-img {
  width: 100%;
  height: auto;
  border-radius: var(--radius-sm);
  display: block;
}

.rs-ecom-section {
  padding: 64px 0;
  background: transparent;
  border-bottom: 1px solid var(--border-color);
}
"""

with open("css/ecommerce-page.css", "w", encoding="utf-8") as f:
    f.write(ECOM_CSS)
print("Updated css/ecommerce-page.css (Strict Light Theme E-Commerce)")

# ==============================================================================
# 6. css/blog.css (Blog Publication & Details in Strict Light Theme)
# ==============================================================================
BLOG_CSS = """/* ==========================================================================
   BLOG CMS & EDITORIAL STYLES (Strict Light Theme)
   Primary Background: #FFFFFF | Secondary: #F3F6FF
   Primary Text: #171B2D | Secondary Text: #626B7D | Electric Blue: #315EFA
   ========================================================================== */

.blog-hero {
  padding-top: calc(var(--header-height) + 40px);
  padding-bottom: 40px;
  background-color: var(--bg-canvas);
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
  background-color: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-sm);
}

.blog-category-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.blog-pill {
  font-size: 0.85rem;
  font-weight: 600;
  color: var(--text-secondary);
  background: var(--bg-secondary);
  border: 1px solid var(--border-color);
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  text-decoration: none;
  transition: all var(--transition-fast);
}

.blog-pill:hover,
.blog-pill.active {
  background: var(--gradient-primary);
  color: #FFFFFF;
  border-color: transparent;
  box-shadow: 0 4px 12px rgba(49, 94, 250, 0.25);
}

.blog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 32px;
  margin-top: 48px;
}

.blog-card {
  background: #FFFFFF;
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-card);
  transition: all var(--transition-fast);
  display: flex;
  flex-direction: column;
}

.blog-card:hover {
  transform: translateY(-4px);
  border-color: rgba(49, 94, 250, 0.35);
  box-shadow: var(--shadow-hover);
}

.blog-card-media img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.blog-card-content {
  padding: 24px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.blog-card-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--electric-blue);
  background: var(--electric-blue-light);
  padding: 4px 10px;
  border-radius: var(--radius-pill);
  align-self: flex-start;
  margin-bottom: 12px;
}

.blog-card-title {
  font-size: 1.25rem;
  font-weight: 750;
  color: var(--text-primary);
  line-height: 1.35;
  margin-bottom: 12px;
}

.blog-card-title a {
  color: var(--text-primary);
  text-decoration: none;
}

.blog-card-title a:hover {
  color: var(--electric-blue);
}

.blog-card-excerpt {
  font-size: 0.94rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin-bottom: 20px;
  flex-grow: 1;
}

.blog-card-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.82rem;
  color: var(--text-muted);
  padding-top: 14px;
  border-top: 1px solid var(--border-subtle);
}
"""

with open("css/blog.css", "w", encoding="utf-8") as f:
    f.write(BLOG_CSS)
print("Updated css/blog.css (Strict Light Theme Blog)")

# ==============================================================================
# 7. css/responsive.css (Light Theme Responsive Adjustments)
# ==============================================================================
RESPONSIVE_CSS = """/* ==========================================================================
   RESPONSIVE DESIGN & MOBILE OPTIMIZATIONS (Strict Light Theme)
   ========================================================================== */

@media (max-width: 1024px) {
  :root {
    --header-height: 72px;
    --section-spacing: 72px;
  }

  .hp-hero-editorial-wrap,
  .arch-spread-layout,
  .rs-ecom-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .hp-service-slab {
    grid-template-columns: 1fr;
    gap: 20px;
  }

  .hp-slab-action {
    justify-content: flex-start;
  }

  .footer-grid {
    grid-template-columns: 1fr 1fr;
    gap: 36px;
  }

  .services-metrics-strip {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  :root {
    --header-height: 64px;
    --section-spacing: 56px;
  }

  .nav-links,
  .nav-actions {
    display: none;
  }

  .mobile-toggle {
    display: flex;
  }

  .hp-hero-stats-ledger,
  .arch-ledger-grid,
  .arch-kpi-quad,
  .hp-framework-grid,
  .hp-queries-grid,
  .footer-grid,
  .services-metrics-strip {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .hp-floating-meta-chip {
    position: static;
    margin-top: 12px;
  }

  .hp-cta-editorial-box {
    padding: 36px 20px;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 16px;
    text-align: center;
  }
}
"""

with open("css/responsive.css", "w", encoding="utf-8") as f:
    f.write(RESPONSIVE_CSS)
print("Updated css/responsive.css (Strict Light Theme Responsive)")

# ==============================================================================
# 8. js/interactions.js (Light-Theme Custom Cursor, Mouse Light, Magnetic Buttons, 3D Tilt)
# ==============================================================================
INTERACTIONS_JS = """/**
 * HIGH-ENERGY INTERACTIONS & MICRO-EXPERIENCES (LIGHT THEME)
 * - Custom animated cursor (electric blue dot & violet follower with hover scaling)
 * - Mouse-following gradient lighting
 * - Magnetic buttons
 * - 3D Card tilt tracking on mousemove
 * - Animated statistics counters
 * - FAQ accordion
 * - Scroll progress indicator
 * - Contact form validation & prefill
 */

document.addEventListener('DOMContentLoaded', () => {
  initCustomCursor();
  initMouseGradientLight();
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
 * 1. Custom Animated Cursor (Optimized for Strict Light Theme)
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
      requestAnimationFrame(renderCursor);
    }
  });

  function renderCursor() {
    ringX += (mouseX - ringX) * 0.16;
    ringY += (mouseY - ringY) * 0.16;

    cursorRing.style.left = `${ringX}px`;
    cursorRing.style.top = `${ringY}px`;

    if (Math.abs(mouseX - ringX) > 0.1 || Math.abs(mouseY - ringY) > 0.1) {
      requestAnimationFrame(renderCursor);
    } else {
      isMoving = false;
    }
  }

  // Hover expansion on interactive elements
  const hoverables = document.querySelectorAll('a, button, input, select, textarea, .card, .arch-ledger-card, .service-card, .hp-service-slab, .faq-question');
  hoverables.forEach(el => {
    el.addEventListener('mouseenter', () => cursorRing.classList.add('cursor-active'));
    el.addEventListener('mouseleave', () => cursorRing.classList.remove('cursor-active'));
  });
}

/**
 * 2. Mouse-Following Gradient Lighting
 */
function initMouseGradientLight() {
  const sections = document.querySelectorAll('section, .hp-cta-editorial-box, .hp-visual-composition-frame');
  sections.forEach(sec => {
    sec.addEventListener('mousemove', (e) => {
      const rect = sec.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      sec.style.setProperty('--mouse-x', `${x}px`);
      sec.style.setProperty('--mouse-y', `${y}px`);
    });
  });
}

/**
 * 3. Magnetic Buttons Physics
 */
function initMagneticButtons() {
  const magneticElements = document.querySelectorAll('.btn-primary, .hp-btn-primary, .rs-ecom-btn, .arch-cta-btn, .brand-monogram');

  magneticElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      el.style.transform = `translate(${x * 0.22}px, ${y * 0.22}px)`;
    });

    el.addEventListener('mouseleave', () => {
      el.style.transform = 'translate(0px, 0px)';
      el.style.transition = 'transform 0.35s cubic-bezier(0.16, 1, 0.3, 1)';
    });

    el.addEventListener('mouseenter', () => {
      el.style.transition = 'none';
    });
  });
}

/**
 * 4. 3D Card Tilt Tracking on Mousemove
 */
function init3DCardTilt() {
  const cards = document.querySelectorAll('.card, .arch-ledger-card, .arch-kpi-card, .service-card, .hp-stat-ledger-item, .metric-strip-item');

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
      card.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
    });

    card.addEventListener('mouseenter', () => {
      card.style.transition = 'none';
    });
  });
}

/**
 * 5. Animated Statistics Counters
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
    const duration = 1400;
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
 * 6. FAQ Accordion Interaction
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
 * 7. Scroll Progress Indicator Bar
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
 * 8. Contact Form Validation & State
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
        field.style.borderColor = 'var(--error)';
      } else {
        field.style.borderColor = 'var(--border-color)';
      }
    });

    if (!isValid) {
      e.preventDefault();
      alert('Please fill out all required fields before submitting.');
    }
  });
}
"""

with open("js/interactions.js", "w", encoding="utf-8") as f:
    f.write(INTERACTIONS_JS)
print("Updated js/interactions.js (Light Theme Custom Cursor & Interactions)")

print("\nAll Light Theme stylesheets and scripts written successfully!")
