# -*- coding: utf-8 -*-
"""
CREATIVE GROWTH LAB BUILDER SCRIPT - RITWIK SACHDEVA
Award-Winning Quality Creative Studio & Growth Lab Aesthetic
Palette:
- White: #FFFFFF
- Cobalt Blue: #244BFF
- Acid Lime: #D5FF45
- Coral: #FF765C
- Ink: #171717
Typography: Space Grotesk (Display), Manrope (Headings), Inter (Body)
"""

import os
import re

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

# ==============================================================================
# 1. css/style.css (Core Design Tokens, Swiss Editorial Grid, Navigation, Footer)
# ==============================================================================
STYLE_CSS = """/* ==========================================================================
   RITWIK SACHDEVA — CREATIVE GROWTH LAB
   Award-Winning Digital Creative Strategy Consultancy
   Visual Identity: White (#FFFFFF), Cobalt Blue (#244BFF), Acid Lime (#D5FF45), 
                    Coral (#FF765C), Ink (#171717)
   Typography: Space Grotesk (Display), Manrope (Headings), Inter (Body)
   Aesthetic: Avant-Garde Swiss Editorial & High-Energy Creative Technology Studio
   ========================================================================== */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@500;700&display=swap');

/* ==========================================================================
   1. DESIGN TOKENS & CREATIVE GROWTH LAB PALETTE
   ========================================================================== */
:root {
  /* Predominantly White Canvas & Surfaces */
  --bg-canvas: #FFFFFF;
  --bg-primary: #FFFFFF;
  --bg-surface: #FFFFFF;
  --bg-secondary: #F8F9FA;
  --bg-surface-elevated: #FFFFFF;
  --bg-subtle: #F2F4F7;
  --bg-card: #FFFFFF;
  --bg-card-alt: #F4F6FB;

  /* Typography Colors */
  --text-primary: #171717;  /* Ink */
  --text-secondary: #525252;
  --text-muted: #828282;
  --text-subtle: #A3A3A3;
  --text-inverse: #FFFFFF;

  /* Vibrant Creative Studio Colors */
  --cobalt-blue: #244BFF;
  --cobalt-hover: #1838CC;
  --cobalt-light: rgba(36, 75, 255, 0.08);
  --cobalt-glow: rgba(36, 75, 255, 0.3);

  --acid-lime: #D5FF45;
  --acid-lime-hover: #C2EB38;
  --acid-lime-light: rgba(213, 255, 69, 0.25);
  --acid-lime-glow: rgba(213, 255, 69, 0.5);

  --coral: #FF765C;
  --coral-hover: #E85E44;
  --coral-light: rgba(255, 118, 92, 0.12);

  --ink: #171717;

  /* Semantic Aliases */
  --accent-primary: #244BFF;
  --accent-secondary: #D5FF45;
  --accent-tertiary: #FF765C;
  --accent-hover: #1838CC;
  --accent-light: rgba(36, 75, 255, 0.08);

  /* Swiss Architectural Borders & Dividers */
  --border-color: #E6E6E6;
  --border-subtle: #F0F0F0;
  --border-strong: #171717;
  --border-cobalt: rgba(36, 75, 255, 0.35);
  --border-lime: rgba(213, 255, 69, 0.8);

  /* Gradients */
  --gradient-cobalt-lime: linear-gradient(135deg, #244BFF 0%, #D5FF45 100%);
  --gradient-cobalt-coral: linear-gradient(135deg, #244BFF 0%, #FF765C 100%);
  --gradient-hero: linear-gradient(135deg, #244BFF 0%, #171717 100%);
  --gradient-card: linear-gradient(180deg, #FFFFFF 0%, #F8F9FA 100%);

  /* Typography Families */
  --font-display: 'Space Grotesk', -apple-system, sans-serif;
  --font-heading: 'Manrope', 'Space Grotesk', sans-serif;
  --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-mono: 'JetBrains Mono', 'Space Grotesk', monospace;
  --font-serif: 'Space Grotesk', sans-serif;

  /* Geometry & Radii */
  --radius-xs: 4px;
  --radius-sm: 8px;
  --radius-md: 14px;
  --radius-lg: 20px;
  --radius-xl: 28px;
  --radius-pill: 9999px;
  --radius-full: 9999px;

  /* Swiss Studio Shadows */
  --shadow-sm: 0 2px 6px rgba(23, 23, 23, 0.04);
  --shadow-card: 0 12px 32px -6px rgba(23, 23, 23, 0.07), 0 0 0 1px rgba(230, 230, 230, 0.9);
  --shadow-hover: 0 24px 48px -10px rgba(36, 75, 255, 0.16), 0 0 0 2px var(--cobalt-blue);
  --shadow-navbar: 0 4px 20px rgba(23, 23, 23, 0.04);
  --shadow-pop: 0 8px 0px #171717;

  /* Spatial Grid System */
  --container-max: 1240px;
  --container-narrow: 900px;
  --header-height: 84px;
  --section-spacing: 104px;
  --section-spacing-sm: 68px;

  /* Transitions */
  --transition-fast: 0.18s cubic-bezier(0.16, 1, 0.3, 1);
  --transition-smooth: 0.32s cubic-bezier(0.16, 1, 0.3, 1);
  --transition-spring: 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
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

/* Selection highlight in Acid Lime */
::selection {
  background-color: var(--acid-lime);
  color: #171717;
}

img, svg, video {
  max-width: 100%;
  height: auto;
  display: block;
}

a {
  color: var(--cobalt-blue);
  text-decoration: none;
  transition: color var(--transition-fast), transform var(--transition-fast);
}

a:hover {
  color: var(--cobalt-hover);
}

button {
  font-family: inherit;
  cursor: pointer;
  border: none;
  background: none;
}

/* ==========================================================================
   3. SWISS & AVANT-GARDE TYPOGRAPHY SYSTEM
   ========================================================================== */
h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-heading);
  color: var(--text-primary);
  font-weight: 750;
  line-height: 1.16;
  letter-spacing: -0.03em;
}

h1 {
  font-family: var(--font-display);
  font-size: clamp(2.6rem, 4.8vw, 4.4rem);
  font-weight: 700;
  line-height: 1.08;
  letter-spacing: -0.04em;
}

h2 {
  font-family: var(--font-display);
  font-size: clamp(2rem, 3.5vw, 3rem);
  font-weight: 700;
  line-height: 1.15;
  letter-spacing: -0.03em;
}

h3 {
  font-family: var(--font-heading);
  font-size: clamp(1.35rem, 2.3vw, 1.95rem);
  font-weight: 700;
  line-height: 1.24;
}

h4 {
  font-size: 1.2rem;
  font-weight: 700;
  line-height: 1.35;
}

p {
  color: var(--text-secondary);
  font-size: 1.02rem;
  line-height: 1.7;
}

.text-gradient,
.gradient-text {
  background: var(--gradient-cobalt-coral);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

.text-cobalt {
  color: var(--cobalt-blue);
}

.text-ink {
  color: var(--ink);
}

/* Acid Lime Badge Pill */
.lime-pill,
.badge-lime,
.mono-tag {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: #171717;
  background: var(--acid-lime);
  border: 1px solid #171717;
  padding: 5px 14px;
  border-radius: var(--radius-pill);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 2px 2px 0px #171717;
  transition: all var(--transition-fast);
}

.lime-pill:hover,
.badge-lime:hover {
  transform: translate(-1px, -1px);
  box-shadow: 3px 3px 0px #171717;
}

/* Coral Indicator Pill */
.coral-pill,
.badge-coral {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: #FFFFFF;
  background: var(--coral);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

/* ==========================================================================
   4. CONTAINER ARCHITECTURE & AMBIENT CANVAS
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
  padding-left: clamp(20px, 3.8vw, 36px);
  padding-right: clamp(20px, 3.8vw, 36px);
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
  border-top: 1px solid var(--border-color);
  border-bottom: 1px solid var(--border-color);
}

/* Subtle Geometric Canvas Elements */
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
  opacity: 0.08;
  pointer-events: none;
}

.ambient-glow-1 {
  width: 580px;
  height: 580px;
  background: radial-gradient(circle, var(--cobalt-blue) 0%, transparent 70%);
  top: -100px;
  right: -60px;
}

.ambient-glow-2 {
  width: 520px;
  height: 520px;
  background: radial-gradient(circle, var(--acid-lime) 0%, transparent 70%);
  bottom: 8%;
  left: -80px;
  opacity: 0.14;
}

.grid-pattern-overlay {
  position: absolute;
  inset: 0;
  background-image: 
    linear-gradient(to right, rgba(23, 23, 23, 0.035) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(23, 23, 23, 0.035) 1px, transparent 1px);
  background-size: 56px 56px;
  mask-image: radial-gradient(circle at center, black 45%, transparent 95%);
  -webkit-mask-image: radial-gradient(circle at center, black 45%, transparent 95%);
}

/* High-Voltage Scroll Progress Bar */
#scroll-progress {
  position: fixed;
  top: 0;
  left: 0;
  height: 4px;
  width: 0%;
  background: linear-gradient(90deg, #244BFF, #D5FF45, #FF765C);
  z-index: 99999;
  transition: width 0.08s linear;
}

/* ==========================================================================
   5. NAVIGATION (CREATIVE GROWTH LAB HEADER)
   ========================================================================== */
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: var(--header-height);
  z-index: 1000;
  background: rgba(255, 255, 255, 0.92);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border-color);
  transition: height var(--transition-fast), background-color var(--transition-fast), box-shadow var(--transition-fast);
}

.site-header.scrolled {
  height: 72px;
  background: rgba(255, 255, 255, 0.98);
  box-shadow: var(--shadow-navbar);
  border-bottom: 1px solid var(--border-strong);
}

.nav-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}

/* Brand Monogram & Typography */
.brand-logo {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  color: var(--text-primary);
}

.brand-monogram {
  width: 44px;
  height: 44px;
  background: #171717;
  color: var(--acid-lime);
  border: 1px solid #171717;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-display);
  font-weight: 700;
  font-size: 1.05rem;
  letter-spacing: -0.02em;
  box-shadow: 2px 2px 0px var(--cobalt-blue);
  transition: all var(--transition-fast);
}

.brand-logo:hover .brand-monogram {
  background: var(--cobalt-blue);
  color: #FFFFFF;
  box-shadow: 3px 3px 0px var(--acid-lime);
  transform: translate(-1px, -1px);
}

.brand-info {
  display: flex;
  flex-direction: column;
}

.brand-name {
  font-family: var(--font-display);
  line-height: 1.15;
  font-size: 1.18rem;
  font-weight: 700;
  color: var(--text-primary);
  letter-spacing: -0.03em;
}

.brand-title {
  font-size: 0.72rem;
  font-family: var(--font-mono);
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--cobalt-blue);
  font-weight: 700;
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
  color: var(--cobalt-blue);
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
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

/* Dropdown Menu */
.nav-dropdown {
  position: relative;
}

.nav-dropdown-menu {
  position: absolute;
  top: 100%;
  left: -20px;
  width: 330px;
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 14px;
  box-shadow: 4px 6px 0px #171717;
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
  font-weight: 600;
  color: var(--text-secondary);
  padding: 9px 12px;
  border-radius: var(--radius-sm);
  transition: all var(--transition-fast);
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.nav-dropdown-link:hover {
  background: var(--acid-lime-light);
  color: #171717;
  transform: translateX(4px);
}

/* Mobile Toggle */
.mobile-toggle {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 6px;
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  padding: 10px;
  cursor: pointer;
  z-index: 1005;
}

.mobile-toggle span {
  display: block;
  width: 100%;
  height: 2px;
  background-color: var(--text-primary);
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
  font-family: var(--font-display);
  font-size: 1.45rem;
  font-weight: 700;
  color: var(--text-primary);
  text-decoration: none;
  padding: 8px 0;
  border-bottom: 1px solid var(--border-color);
}

.mobile-link:hover {
  color: var(--cobalt-blue);
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
  color: var(--cobalt-blue);
}

/* ==========================================================================
   6. CREATIVE CTA BUTTONS (MAGNETIC & SOLID POP)
   ========================================================================== */
.btn,
.hp-btn,
.rs-ecom-btn,
.arch-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-family: var(--font-display);
  font-size: 0.98rem;
  font-weight: 700;
  letter-spacing: -0.01em;
  padding: 14px 32px;
  border-radius: var(--radius-pill);
  text-decoration: none;
  transition: all var(--transition-fast);
  cursor: pointer;
  position: relative;
  overflow: hidden;
  white-space: nowrap;
}

/* Creative Primary Button: Cobalt Blue with Acid Lime hover */
.btn-primary,
.hp-btn-primary,
.rs-ecom-btn,
.arch-cta-btn {
  background: var(--cobalt-blue);
  color: #FFFFFF !important;
  border: 1px solid var(--cobalt-blue);
  box-shadow: 3px 3px 0px #171717;
}

.btn-primary:hover,
.hp-btn-primary:hover,
.rs-ecom-btn:hover,
.arch-cta-btn:hover {
  background: var(--acid-lime);
  color: #171717 !important;
  border-color: #171717;
  box-shadow: 4px 4px 0px var(--cobalt-blue);
  transform: translate(-2px, -2px);
}

/* Secondary Button */
.btn-secondary,
.btn-outline,
.hp-btn-secondary {
  background: #FFFFFF;
  color: #171717 !important;
  border: 1px solid var(--border-strong);
  box-shadow: 2px 2px 0px #171717;
}

.btn-secondary:hover,
.btn-outline:hover,
.hp-btn-secondary:hover {
  background: var(--bg-secondary);
  border-color: var(--cobalt-blue);
  color: var(--cobalt-blue) !important;
  box-shadow: 3px 3px 0px var(--cobalt-blue);
  transform: translate(-1px, -1px);
}

.btn-lg {
  padding: 18px 38px;
  font-size: 1.08rem;
}

.btn-sm {
  padding: 8px 20px;
  font-size: 0.86rem;
}

.btn-icon-right {
  display: inline-flex;
  transition: transform var(--transition-fast);
}

.btn:hover .btn-icon-right,
.hp-btn:hover .btn-icon-right {
  transform: translateX(5px);
}

/* ==========================================================================
   7. EDITORIAL LIGHT FOOTER
   ========================================================================== */
.site-footer {
  background-color: #F8F9FA;
  color: var(--text-secondary);
  border-top: 2px solid var(--border-strong);
  padding: 88px 0 36px 0;
  position: relative;
}

.site-footer a {
  color: var(--text-secondary);
  text-decoration: none;
  transition: color var(--transition-fast);
}

.site-footer a:hover {
  color: var(--cobalt-blue);
}

.footer-grid {
  display: grid;
  grid-template-columns: 1.4fr 0.9fr 1.3fr 1fr;
  gap: 48px;
  margin-bottom: 60px;
}

.footer-brand-statement {
  font-size: 0.94rem;
  color: var(--text-secondary);
  line-height: 1.7;
  margin-top: 18px;
  max-width: 360px;
}

.site-footer .brand-name {
  color: var(--text-primary);
}

.footer-heading {
  font-family: var(--font-display);
  font-size: 1rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text-primary);
  margin-bottom: 22px;
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
  color: var(--cobalt-blue);
  transform: translateX(4px);
}

.footer-bottom {
  border-top: 1px solid var(--border-color);
  padding-top: 30px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.88rem;
  color: var(--text-muted);
}

.back-to-top-btn {
  font-family: var(--font-display);
  font-size: 0.86rem;
  font-weight: 700;
  color: #171717;
  background: var(--acid-lime);
  border: 1px solid #171717;
  padding: 8px 16px;
  border-radius: var(--radius-pill);
  box-shadow: 2px 2px 0px #171717;
  transition: all var(--transition-fast);
}

.back-to-top-btn:hover {
  background: var(--cobalt-blue);
  color: #FFFFFF;
  border-color: var(--cobalt-blue);
  box-shadow: 3px 3px 0px #171717;
  transform: translate(-1px, -1px);
}

/* ==========================================================================
   8. FORMS & INPUT ARCHITECTURE
   ========================================================================== */
.form-group {
  margin-bottom: 22px;
}

.form-label {
  display: block;
  font-family: var(--font-display);
  font-size: 0.9rem;
  font-weight: 700;
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
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-sm);
  padding: 14px 18px;
  font-family: var(--font-body);
  font-size: 0.96rem;
  color: var(--text-primary);
  transition: all var(--transition-fast);
  box-shadow: 2px 2px 0px rgba(23, 23, 23, 0.05);
}

.form-control:focus,
input:focus,
select:focus,
textarea:focus {
  outline: none;
  border-color: var(--cobalt-blue);
  box-shadow: 3px 3px 0px var(--cobalt-blue);
}

textarea {
  resize: vertical;
  min-height: 120px;
}

/* ==========================================================================
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
  transition: width 0.26s cubic-bezier(0.16, 1, 0.3, 1), 
              height 0.26s cubic-bezier(0.16, 1, 0.3, 1), 
              background-color 0.2s ease, 
              border-color 0.2s ease;
}

.custom-cursor-ring.cursor-active {
  width: 64px;
  height: 64px;
  border-color: #171717;
  background-color: var(--acid-lime-light);
  box-shadow: 0 0 24px rgba(213, 255, 69, 0.45);
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
  padding: 34px;
  box-shadow: var(--shadow-card);
  transition: transform var(--transition-fast), box-shadow var(--transition-fast), border-color var(--transition-fast);
}

.card:hover,
.arch-card:hover,
.arch-ledger-card:hover {
  transform: translateY(-4px);
  border-color: var(--cobalt-blue);
  box-shadow: var(--shadow-hover);
}

.section-tag {
  font-family: var(--font-mono);
  font-size: 0.78rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: #171717;
  background: var(--acid-lime);
  border: 1px solid #171717;
  padding: 6px 16px;
  border-radius: var(--radius-pill);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 2px 2px 0px #171717;
  margin-bottom: 18px;
}

.section-title {
  margin-bottom: 22px;
}
"""

with open("css/style.css", "w", encoding="utf-8") as f:
    f.write(STYLE_CSS)
print("Updated css/style.css (Creative Growth Lab)")

# ==============================================================================
# 2. css/animations.css (Motion Design Engine: Sparklines, Ticker, Floats, Cursor)
# ==============================================================================
ANIMATIONS_CSS = """/* ==========================================================================
   CREATIVE GROWTH LAB — MOTION DESIGN ENGINE
   Awwwards / FWA Inspired Fluid Motion, Marquee, Floating Cards, SVG Dynamics
   ========================================================================== */

/* Ambient Graphic Breathing */
@keyframes studio-ambient-breathe {
  0%, 100% {
    transform: scale(1) rotate(0deg);
    opacity: 0.08;
  }
  50% {
    transform: scale(1.15) rotate(4deg);
    opacity: 0.15;
  }
}

.ambient-glow-1 {
  animation: studio-ambient-breathe 16s ease-in-out infinite alternate;
}

.ambient-glow-2 {
  animation: studio-ambient-breathe 20s ease-in-out infinite alternate-reverse;
}

/* Kinetic Gradient Typography */
@keyframes studio-kinetic-shimmer {
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
  background: linear-gradient(90deg, #244BFF, #171717, #FF765C, #244BFF);
  background-size: 300% 300%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: studio-kinetic-shimmer 8s ease infinite;
  display: inline-block;
}

/* Floating Analytics Dashboard Widgets */
@keyframes studio-float-1 {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-10px) rotate(0.8deg);
  }
}

@keyframes studio-float-2 {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-8px) rotate(-1deg);
  }
}

.floating-widget-1 {
  animation: studio-float-1 6s ease-in-out infinite;
}

.floating-widget-2 {
  animation: studio-float-2 7.5s ease-in-out infinite 1s;
}

/* Marquee / Infinite Ticker Ribbon */
@keyframes marquee-scroll {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-50%);
  }
}

.ticker-track {
  display: flex;
  width: max-content;
  animation: marquee-scroll 24s linear infinite;
}

.ticker-track:hover {
  animation-play-state: paused;
}

/* Growth Chart Sparkline SVG Draw */
@keyframes sparkline-draw {
  0% {
    stroke-dashoffset: 240;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

.animated-sparkline {
  stroke-dasharray: 240;
  stroke-dashoffset: 240;
  animation: sparkline-draw 2.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Live Status Pulse Dot */
@keyframes pulse-live {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.4);
    opacity: 0.6;
  }
}

.status-dot-live {
  width: 8px;
  height: 8px;
  background-color: #10B981;
  border-radius: 50%;
  display: inline-block;
  animation: pulse-live 1.8s ease-in-out infinite;
}

/* Scroll-Triggered Reveals */
.reveal-on-scroll {
  opacity: 0;
  transform: translateY(28px);
  transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
  will-change: opacity, transform;
}

.reveal-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.reveal-from-left {
  opacity: 0;
  transform: translateX(-36px);
  transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal-from-left.is-visible {
  opacity: 1;
  transform: translateX(0);
}

.reveal-from-right {
  opacity: 0;
  transform: translateX(36px);
  transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}
.reveal-from-right.is-visible {
  opacity: 1;
  transform: translateX(0);
}

/* Respect motion settings */
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
print("Updated css/animations.css (Motion Design Engine)")

# ==============================================================================
# 3. css/home-live.css (Homepage Asymmetric Swiss Editorial & Growth Lab)
# ==============================================================================
HOME_LIVE_CSS = """/* ==========================================================================
   HOMEPAGE CREATIVE GROWTH LAB ARCHITECTURE (home-live.css)
   Predominantly White Canvas (#FFFFFF), Cobalt Blue (#244BFF), Acid Lime (#D5FF45)
   Coral (#FF765C) & Ink (#171717)
   Oversized Space Grotesk Typography, Asymmetric Layouts & Interactive Visuals
   ========================================================================== */

#main-content {
  width: 100%;
  max-width: var(--container-max, 1240px);
  margin: 0 auto;
  padding-left: clamp(20px, 3.8vw, 36px);
  padding-right: clamp(20px, 3.8vw, 36px);
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
   UNCONVENTIONAL CREATIVE HERO SECTION
   ========================================================================== */
#hero {
  padding: calc(var(--header-height, 84px) + 36px) 0 80px;
  background-color: transparent;
  border-bottom: 2px solid var(--border-strong);
  position: relative;
}

.hp-hero-editorial-wrap {
  display: grid;
  grid-template-columns: 1.2fr 0.8fr;
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
  margin-bottom: 22px;
}

.hp-hero-kicker {
  font-family: var(--font-mono);
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: #171717;
  background: var(--acid-lime);
  border: 1px solid #171717;
  padding: 6px 18px;
  border-radius: var(--radius-pill);
  box-shadow: 2px 2px 0px #171717;
}

#hero .hp-h1 {
  font-family: var(--font-display);
  font-size: clamp(2.6rem, 4.6vw, 4.2rem);
  font-weight: 700;
  line-height: 1.08;
  letter-spacing: -0.04em;
  color: var(--text-primary);
  margin-bottom: 22px;
}

.hero-description {
  font-size: 1.15rem;
  line-height: 1.72;
  color: var(--text-secondary);
  margin-bottom: 36px;
  max-width: 640px;
}

.hp-hero-actions-row {
  display: flex;
  align-items: center;
  gap: 18px;
  margin-bottom: 44px;
}

/* Stats Ledger Cards (Asymmetric Swiss Cards with Pop Shadow) */
.hp-hero-stats-ledger {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
  padding-top: 36px;
  border-top: 1px solid var(--border-color);
}

.hp-stat-ledger-item {
  display: flex;
  flex-direction: column;
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  padding: 18px 22px;
  border-radius: var(--radius-sm);
  box-shadow: 3px 3px 0px #171717;
  transition: all var(--transition-fast);
}

.hp-stat-ledger-item:hover {
  transform: translate(-2px, -2px);
  box-shadow: 5px 5px 0px var(--cobalt-blue);
  border-color: var(--cobalt-blue);
}

.hp-stat-number {
  font-family: var(--font-display);
  font-size: 2.1rem;
  font-weight: 700;
  line-height: 1.1;
  color: var(--cobalt-blue);
  margin-bottom: 4px;
}

.hp-stat-label {
  font-family: var(--font-body);
  font-size: 0.84rem;
  font-weight: 600;
  color: var(--text-secondary);
  line-height: 1.35;
}

/* Hero Visual Composition Frame (Asymmetric Studio Art Direction) */
.hp-hero-visual-column {
  position: relative;
}

.hp-visual-composition-frame {
  position: relative;
  background: #FFFFFF;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 14px;
  box-shadow: 8px 8px 0px #171717;
  transition: all var(--transition-smooth);
}

.hp-visual-composition-frame:hover {
  transform: translate(-3px, -3px);
  box-shadow: 12px 12px 0px var(--cobalt-blue);
}

.hp-visual-composition-frame img {
  width: 100%;
  height: auto;
  aspect-ratio: 1/1;
  object-fit: cover;
  border-radius: var(--radius-md);
  display: block;
}

/* Floating Marketing Analytics Widgets (Creative Studio Style) */
.hp-floating-meta-chip {
  position: absolute;
  background: #FFFFFF;
  border: 2px solid #171717;
  border-radius: var(--radius-md);
  padding: 14px 20px;
  box-shadow: 4px 4px 0px #171717;
  z-index: 2;
}

.hp-chip-top {
  top: -16px;
  right: -16px;
  background: #FFFFFF;
}

.hp-chip-bottom {
  bottom: -16px;
  left: -16px;
  background: #FFFFFF;
}

.hp-chip-title {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--cobalt-blue);
  margin-bottom: 4px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.hp-chip-val {
  font-family: var(--font-display);
  font-weight: 700;
  font-size: 1.02rem;
  color: var(--text-primary);
}

/* ==========================================================================
   HORIZONTAL MARQUEE STRIP (CREATIVE GROWTH TICKER)
   ========================================================================== */
.studio-ticker-ribbon {
  background: #171717;
  color: var(--acid-lime);
  overflow: hidden;
  padding: 16px 0;
  border-bottom: 2px solid #171717;
}

.ticker-item {
  font-family: var(--font-display);
  font-size: 1.15rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 24px;
  padding: 0 24px;
}

.ticker-item-dot {
  width: 8px;
  height: 8px;
  background-color: var(--coral);
  border-radius: 50%;
  display: inline-block;
}

/* ==========================================================================
   SECTION 1: WHAT A DIGITAL MARKETING CONSULTANT DOES
   ========================================================================== */
#what-consultant-does {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 2px solid var(--border-strong);
}

.arch-spread-layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: 56px;
  align-items: start;
}

.arch-spread-header {
  position: sticky;
  top: calc(var(--header-height) + 24px);
}

.arch-spread-index {
  font-family: var(--font-mono);
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.14em;
  color: #171717;
  background: var(--acid-lime);
  padding: 6px 16px;
  border-radius: var(--radius-pill);
  display: inline-block;
  margin-bottom: 18px;
  border: 1px solid #171717;
  box-shadow: 2px 2px 0px #171717;
}

.arch-spread-title {
  font-family: var(--font-display);
  font-size: clamp(2.2rem, 3.4vw, 2.9rem);
  font-weight: 700;
  line-height: 1.16;
  color: var(--text-primary);
}

.arch-spread-body-wrap p {
  font-size: 1.08rem;
  line-height: 1.76;
  color: var(--text-secondary);
  margin-bottom: 26px;
}

/* Comparison Ledger Grid */
.arch-ledger-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-top: 40px;
}

.arch-ledger-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 32px;
  box-shadow: 4px 4px 0px #171717;
  transition: all var(--transition-fast);
}

.arch-ledger-card:hover {
  transform: translate(-2px, -2px);
  box-shadow: 6px 6px 0px var(--cobalt-blue);
  border-color: var(--cobalt-blue);
}

.arch-ledger-tag {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--cobalt-blue);
  margin-bottom: 14px;
}

.arch-ledger-card h3 {
  font-family: var(--font-display);
  font-size: 1.35rem;
  font-weight: 700;
  margin-bottom: 12px;
  color: var(--text-primary);
}

.arch-ledger-card p {
  font-size: 0.98rem;
  color: var(--text-secondary);
  line-height: 1.68;
  margin-bottom: 0;
}

/* ==========================================================================
   SECTION 2: DIGITAL MARKETING SERVICES IN DELHI
   ========================================================================== */
#services {
  padding: 96px 0;
  background-color: var(--bg-secondary);
  border-bottom: 2px solid var(--border-strong);
}

.hp-services-deck {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 44px;
}

.hp-service-slab {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 32px 36px;
  display: grid;
  grid-template-columns: 0.85fr 1.55fr 0.6fr;
  align-items: center;
  gap: 32px;
  box-shadow: 3px 3px 0px #171717;
  transition: all var(--transition-fast);
}

.hp-service-slab:hover {
  transform: translate(-2px, -2px);
  border-color: var(--cobalt-blue);
  box-shadow: 5px 5px 0px var(--cobalt-blue);
}

.hp-slab-left h3 {
  font-family: var(--font-display);
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 6px;
}

.hp-slab-left a {
  color: var(--text-primary);
  text-decoration: none;
}

.hp-slab-left a:hover {
  color: var(--cobalt-blue);
}

.hp-slab-desc {
  font-size: 0.98rem;
  color: var(--text-secondary);
  line-height: 1.68;
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
  font-family: var(--font-display);
  font-size: 0.92rem;
  font-weight: 700;
  color: #171717;
  text-decoration: none;
  padding: 9px 20px;
  border: 1px solid #171717;
  border-radius: var(--radius-pill);
  background: var(--acid-lime);
  box-shadow: 2px 2px 0px #171717;
  transition: all var(--transition-fast);
}

.hp-slab-link:hover {
  background: var(--cobalt-blue);
  color: #FFFFFF;
  border-color: var(--cobalt-blue);
  transform: translate(-1px, -1px);
  box-shadow: 3px 3px 0px #171717;
}

/* ==========================================================================
   SECTION 3: WHO THIS IS FOR
   ========================================================================== */
#who-for {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 2px solid var(--border-strong);
}

.arch-kpi-quad {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 28px;
  margin-top: 40px;
}

.arch-kpi-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 36px;
  box-shadow: 4px 4px 0px #171717;
  transition: all var(--transition-fast);
}

.arch-kpi-card:hover {
  transform: translate(-2px, -2px);
  border-color: var(--cobalt-blue);
  box-shadow: 6px 6px 0px var(--cobalt-blue);
}

.arch-kpi-index {
  font-family: var(--font-mono);
  font-size: 0.85rem;
  font-weight: 700;
  color: var(--cobalt-blue);
  margin-bottom: 16px;
}

.arch-kpi-card h3 {
  font-family: var(--font-display);
  font-size: 1.38rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 12px;
}

.arch-kpi-card p {
  font-size: 0.98rem;
  color: var(--text-secondary);
  line-height: 1.7;
  margin: 0;
}

/* ==========================================================================
   SECTION 4: CHOOSING A DIGITAL MARKETING CONSULTANT
   ========================================================================== */
#choosing-consultant {
  padding: 96px 0;
  background-color: var(--bg-secondary);
  border-bottom: 2px solid var(--border-strong);
}

/* ==========================================================================
   SECTION 5: RESULTS-FOCUSED DIGITAL MARKETING
   ========================================================================== */
#results-focused-marketing {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 2px solid var(--border-strong);
}

.hp-framework-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 26px;
  margin-top: 40px;
}

.hp-framework-col {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 32px;
  box-shadow: 4px 4px 0px #171717;
  transition: all var(--transition-fast);
}

.hp-framework-col:hover {
  transform: translate(-2px, -2px);
  border-color: var(--coral);
  box-shadow: 6px 6px 0px var(--coral);
}

.hp-col-num {
  font-family: var(--font-display);
  font-size: 1.6rem;
  font-weight: 700;
  color: var(--cobalt-blue);
  margin-bottom: 12px;
}

.hp-framework-col h3 {
  font-family: var(--font-display);
  font-size: 1.3rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 12px;
}

.hp-framework-col p {
  font-size: 0.96rem;
  color: var(--text-secondary);
  line-height: 1.68;
  margin: 0;
}

/* ==========================================================================
   SECTION 6: TRUSTED BY BUSINESSES SEARCHING FOR
   ========================================================================== */
#trusted-businesses-searching {
  padding: 96px 0;
  background-color: var(--bg-secondary);
  border-bottom: 2px solid var(--border-strong);
}

.hp-queries-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-top: 40px;
}

.hp-query-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 28px;
  box-shadow: 3px 3px 0px #171717;
  transition: all var(--transition-fast);
}

.hp-query-card:hover {
  transform: translate(-2px, -2px);
  border-color: var(--cobalt-blue);
  box-shadow: 5px 5px 0px var(--cobalt-blue);
}

.hp-query-card h3 {
  font-family: var(--font-display);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 8px;
}

.hp-query-card p {
  font-size: 0.96rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* ==========================================================================
   SECTION 7: FREQUENTLY ASKED QUESTIONS (ACCORDION)
   ========================================================================== */
#dm-faq {
  padding: 96px 0;
  background-color: var(--bg-canvas);
  border-bottom: 2px solid var(--border-strong);
}

.hp-faq-accordion {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-top: 40px;
  max-width: 920px;
}

.faq-item {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: 3px 3px 0px #171717;
  transition: all var(--transition-fast);
}

.faq-item:hover {
  border-color: var(--cobalt-blue);
}

.faq-item.active {
  border-color: var(--cobalt-blue);
  box-shadow: 5px 5px 0px var(--cobalt-blue);
}

.faq-question {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 22px 28px;
  text-align: left;
  background: none;
  border: none;
  font-family: var(--font-display);
  font-size: 1.12rem;
  font-weight: 700;
  color: var(--text-primary);
  cursor: pointer;
  gap: 16px;
  transition: color var(--transition-fast);
}

.faq-question:hover {
  color: var(--cobalt-blue);
}

.faq-icon {
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--cobalt-blue);
  transition: transform var(--transition-fast);
  line-height: 1;
}

.faq-item.active .faq-icon {
  transform: rotate(45deg);
  color: var(--coral);
}

.faq-answer {
  display: none;
  padding: 0 28px 24px 28px;
  font-size: 1rem;
  line-height: 1.72;
  color: var(--text-secondary);
}

.faq-item.active .faq-answer {
  display: block;
}

/* ==========================================================================
   SECTION 8: EXECUTIVE BRIEFING CTA (SWISS HIGH-IMPACT BOX)
   ========================================================================== */
#cta-consultant-delhi {
  padding: 88px 0 104px;
  background-color: var(--bg-canvas);
}

.hp-cta-editorial-box {
  background: #FFFFFF;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 68px 52px;
  text-align: center;
  box-shadow: 8px 8px 0px #171717;
  position: relative;
  overflow: hidden;
}

.hp-cta-editorial-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 6px;
  background: linear-gradient(90deg, #244BFF, #D5FF45, #FF765C);
}

.hp-cta-kicker {
  font-family: var(--font-mono);
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  color: #171717;
  background: var(--acid-lime);
  padding: 6px 18px;
  border-radius: var(--radius-pill);
  display: inline-block;
  margin-bottom: 20px;
  border: 1px solid #171717;
  box-shadow: 2px 2px 0px #171717;
}

.hp-cta-title {
  font-family: var(--font-display);
  font-size: clamp(2.2rem, 3.6vw, 3.1rem);
  font-weight: 700;
  line-height: 1.15;
  color: var(--text-primary);
  margin-bottom: 20px;
}

.hp-cta-desc {
  font-size: 1.12rem;
  line-height: 1.72;
  color: var(--text-secondary);
  max-width: 680px;
  margin: 0 auto 38px auto;
}
"""

with open("css/home-live.css", "w", encoding="utf-8") as f:
    f.write(HOME_LIVE_CSS)
print("Updated css/home-live.css (Creative Growth Lab Homepage)")

# ==============================================================================
# 4. css/services.css (Services Catalog & In-Depth Details in Growth Lab Style)
# ==============================================================================
SERVICES_CSS = """/* ==========================================================================
   SERVICES DIRECTORY & DETAIL STYLES (Creative Growth Lab)
   Predominantly White Canvas (#FFFFFF), Cobalt Blue (#244BFF), Acid Lime (#D5FF45)
   Coral (#FF765C) & Ink (#171717)
   ========================================================================== */

.services-hero {
  padding-top: calc(var(--header-height) + 40px);
  padding-bottom: 52px;
  background-color: var(--bg-canvas);
  border-bottom: 2px solid var(--border-strong);
}

.services-metrics-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 44px;
  padding-top: 36px;
  border-top: 1px solid var(--border-color);
}

.metric-strip-item {
  display: flex;
  flex-direction: column;
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  padding: 20px 22px;
  border-radius: var(--radius-sm);
  box-shadow: 3px 3px 0px #171717;
  transition: all var(--transition-fast);
}

.metric-strip-item:hover {
  transform: translate(-2px, -2px);
  border-color: var(--cobalt-blue);
  box-shadow: 4px 4px 0px var(--cobalt-blue);
}

.metric-strip-val {
  font-family: var(--font-display);
  font-size: clamp(2rem, 3.2vw, 2.75rem);
  font-weight: 700;
  line-height: 1.1;
  margin-bottom: 4px;
  color: var(--cobalt-blue);
}

.metric-strip-label {
  font-family: var(--font-body);
  font-size: 0.84rem;
  font-weight: 600;
  color: var(--text-secondary);
}

/* Sticky Practice Navigation Bar (Creative Studio Track) */
.services-subnav-sticky {
  position: sticky;
  top: var(--header-height);
  background: rgba(255, 255, 255, 0.96);
  backdrop-filter: blur(16px);
  border-bottom: 2px solid var(--border-strong);
  padding: 14px 0;
  z-index: 100;
}

.services-subnav-track {
  display: flex;
  gap: 12px;
  overflow-x: auto;
  white-space: nowrap;
  padding-bottom: 4px;
  scrollbar-width: thin;
}

.subnav-pill {
  font-family: var(--font-display);
  font-size: 0.86rem;
  font-weight: 700;
  color: var(--text-primary);
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  padding: 7px 16px;
  border-radius: var(--radius-pill);
  text-decoration: none;
  box-shadow: 2px 2px 0px #171717;
  transition: all var(--transition-fast);
  display: inline-flex;
  align-items: center;
}

.subnav-pill:hover,
.subnav-pill.active {
  background: var(--acid-lime);
  color: #171717;
  box-shadow: 3px 3px 0px var(--cobalt-blue);
  transform: translate(-1px, -1px);
}

/* Quick Select Dropdown Bar */
.services-quick-select-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 20px 26px;
  margin-top: 40px;
  margin-bottom: 44px;
  box-shadow: 4px 4px 0px #171717;
}

.quick-select-label-wrap {
  display: flex;
  align-items: center;
  gap: 16px;
}

.quick-select-icon {
  width: 40px;
  height: 40px;
  border-radius: var(--radius-sm);
  background: var(--acid-lime);
  color: #171717;
  border: 1px solid #171717;
  display: flex;
  align-items: center;
  justify-content: center;
}

.quick-select-title {
  font-family: var(--font-display);
  font-weight: 700;
  font-size: 1.05rem;
  color: var(--text-primary);
}

.quick-select-subtitle {
  font-size: 0.86rem;
  color: var(--text-secondary);
}

.quick-select-control-wrap {
  position: relative;
  min-width: 360px;
}

.service-jump-select {
  width: 100%;
  appearance: none;
  background: var(--bg-secondary);
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-sm);
  padding: 12px 38px 12px 16px;
  font-family: var(--font-display);
  font-size: 0.92rem;
  font-weight: 600;
  color: var(--text-primary);
  cursor: pointer;
}

.quick-select-arrow {
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
  color: var(--cobalt-blue);
}

/* 11 Services Catalog Cards */
.services-catalog-wrap {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.service-premium-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 40px;
  box-shadow: 5px 5px 0px #171717;
  transition: all var(--transition-fast);
  position: relative;
}

.service-premium-card:hover {
  transform: translate(-3px, -3px);
  border-color: var(--cobalt-blue);
  box-shadow: 8px 8px 0px var(--cobalt-blue);
}

.service-card-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 22px;
}

.service-number-tag {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  letter-spacing: 0.14em;
  color: #171717;
  background: var(--acid-lime);
  border: 1px solid #171717;
  padding: 5px 12px;
  border-radius: var(--radius-pill);
  display: inline-block;
  margin-bottom: 10px;
}

.service-heading {
  font-family: var(--font-display);
  font-size: clamp(1.5rem, 2.5vw, 2rem);
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.2;
}

.badge-status {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: #FFFFFF;
  background: var(--cobalt-blue);
  border: 1px solid var(--cobalt-blue);
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  white-space: nowrap;
}

.service-lead-desc {
  font-size: 1.08rem;
  line-height: 1.72;
  color: var(--text-secondary);
  margin-bottom: 30px;
}

.service-breakdown-grid {
  display: grid;
  grid-template-columns: 1fr 1.3fr 0.9fr;
  gap: 28px;
  padding: 28px;
  background: var(--bg-secondary);
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  margin-bottom: 26px;
}

.breakdown-col-header {
  font-family: var(--font-display);
  font-size: 0.92rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text-primary);
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 14px;
}

.breakdown-col-header.problem {
  color: var(--coral);
}

.breakdown-col-header.deliverables {
  color: var(--cobalt-blue);
}

.breakdown-col-header.roi {
  color: #059669;
}

.breakdown-text {
  font-size: 0.96rem;
  line-height: 1.68;
  color: var(--text-secondary);
}

.breakdown-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.breakdown-list-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  font-size: 0.94rem;
  line-height: 1.5;
  color: var(--text-primary);
}

.breakdown-list-item svg {
  color: var(--cobalt-blue);
  flex-shrink: 0;
  margin-top: 3px;
}

.roi-metric-highlight {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-sm);
  padding: 18px;
  box-shadow: 2px 2px 0px #171717;
}

.service-tools-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  padding-top: 22px;
  border-top: 1px solid var(--border-color);
}

/* 4-Phase Consulting Methodology */
.process-timeline-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  margin-top: 44px;
}

.process-step-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 30px;
  box-shadow: 4px 4px 0px #171717;
  transition: all var(--transition-fast);
}

.process-step-card:hover {
  transform: translate(-2px, -2px);
  border-color: var(--cobalt-blue);
  box-shadow: 6px 6px 0px var(--cobalt-blue);
}

.process-step-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.process-num {
  font-family: var(--font-display);
  font-size: 2rem;
  font-weight: 700;
  color: var(--cobalt-blue);
}

.process-phase {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: #171717;
  background: var(--acid-lime);
  padding: 3px 10px;
  border-radius: var(--radius-pill);
  border: 1px solid #171717;
}

.process-step-title {
  font-family: var(--font-display);
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 10px;
}

.process-step-text {
  font-size: 0.94rem;
  color: var(--text-secondary);
  line-height: 1.65;
  margin: 0;
}

/* Partnership Matrix Cards */
.matrix-card-wrap {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
  margin-top: 44px;
}

.matrix-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 38px;
  box-shadow: 5px 5px 0px #171717;
  display: flex;
  flex-direction: column;
  position: relative;
  transition: all var(--transition-fast);
}

.matrix-card:hover {
  transform: translate(-3px, -3px);
  border-color: var(--cobalt-blue);
  box-shadow: 8px 8px 0px var(--cobalt-blue);
}

.badge {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  padding: 5px 14px;
  border-radius: var(--radius-pill);
  display: inline-block;
}

.badge-accent {
  background: var(--acid-lime);
  color: #171717;
  border: 1px solid #171717;
}

.badge-outline {
  background: var(--bg-secondary);
  color: var(--text-primary);
  border: 1px solid var(--border-strong);
}
"""

with open("css/services.css", "w", encoding="utf-8") as f:
    f.write(SERVICES_CSS)
print("Updated css/services.css (Creative Growth Lab Services)")

# ==============================================================================
# 5. css/ecommerce-page.css (Creative Growth Lab E-Commerce Page)
# ==============================================================================
ECOM_CSS = """/* ==========================================================================
   E-COMMERCE MANAGEMENT PAGE STYLES (Creative Growth Lab)
   Predominantly White Canvas (#FFFFFF), Cobalt Blue (#244BFF), Acid Lime (#D5FF45)
   ========================================================================== */

.ecom-page-wrapper {
  width: 100%;
  max-width: var(--container-max, 1240px);
  margin: 0 auto;
  padding-left: clamp(20px, 3.8vw, 36px);
  padding-right: clamp(20px, 3.8vw, 36px);
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
  padding: calc(var(--header-height, 84px) + 36px) 0 60px;
  background: transparent;
  border-bottom: 2px solid var(--border-strong);
}

.rs-ecom-grid {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: 48px;
  align-items: center;
}

.rs-ecom-card {
  background: #FFFFFF;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 40px;
  box-shadow: 6px 6px 0px #171717;
}

.rs-ecom-title {
  font-family: var(--font-display);
  font-size: clamp(2.1rem, 3.6vw, 2.85rem);
  font-weight: 700;
  line-height: 1.16;
  color: var(--text-primary);
  margin-bottom: 20px;
}

.rs-ecom-subtitle {
  font-size: 1.1rem;
  line-height: 1.72;
  color: var(--text-secondary);
  margin-bottom: 18px;
}

.rs-ecom-desc {
  font-size: 1.04rem;
  line-height: 1.7;
  color: var(--text-secondary);
  margin-bottom: 30px;
}

.rs-ecom-img {
  width: 100%;
  height: auto;
  border-radius: var(--radius-sm);
  display: block;
}

.rs-ecom-section {
  padding: 68px 0;
  background: transparent;
  border-bottom: 1px solid var(--border-color);
}
"""

with open("css/ecommerce-page.css", "w", encoding="utf-8") as f:
    f.write(ECOM_CSS)
print("Updated css/ecommerce-page.css (Creative Growth Lab E-Commerce)")

# ==============================================================================
# 6. css/blog.css (Creative Publication & Articles)
# ==============================================================================
BLOG_CSS = """/* ==========================================================================
   BLOG CMS & EDITORIAL STYLES (Creative Growth Lab)
   Predominantly White Canvas (#FFFFFF), Cobalt Blue (#244BFF), Acid Lime (#D5FF45)
   ========================================================================== */

.blog-hero {
  padding-top: calc(var(--header-height) + 40px);
  padding-bottom: 44px;
  background-color: var(--bg-canvas);
  border-bottom: 2px solid var(--border-strong);
}

.blog-filter-bar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  margin-top: 36px;
  padding: 18px 24px;
  background-color: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  box-shadow: 4px 4px 0px #171717;
}

.blog-category-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.blog-pill {
  font-family: var(--font-display);
  font-size: 0.86rem;
  font-weight: 700;
  color: var(--text-primary);
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  padding: 6px 16px;
  border-radius: var(--radius-pill);
  text-decoration: none;
  box-shadow: 2px 2px 0px #171717;
  transition: all var(--transition-fast);
}

.blog-pill:hover,
.blog-pill.active {
  background: var(--acid-lime);
  color: #171717;
  box-shadow: 3px 3px 0px var(--cobalt-blue);
  transform: translate(-1px, -1px);
}

.blog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  gap: 36px;
  margin-top: 52px;
}

.blog-card {
  background: #FFFFFF;
  border: 1px solid var(--border-strong);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: 4px 4px 0px #171717;
  transition: all var(--transition-fast);
  display: flex;
  flex-direction: column;
}

.blog-card:hover {
  transform: translate(-3px, -3px);
  border-color: var(--cobalt-blue);
  box-shadow: 7px 7px 0px var(--cobalt-blue);
}

.blog-card-media img {
  width: 100%;
  height: 230px;
  object-fit: cover;
}

.blog-card-content {
  padding: 28px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.blog-card-tag {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: #171717;
  background: var(--acid-lime);
  border: 1px solid #171717;
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  align-self: flex-start;
  margin-bottom: 14px;
}

.blog-card-title {
  font-family: var(--font-display);
  font-size: 1.3rem;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.32;
  margin-bottom: 14px;
}

.blog-card-title a {
  color: var(--text-primary);
  text-decoration: none;
}

.blog-card-title a:hover {
  color: var(--cobalt-blue);
}

.blog-card-excerpt {
  font-size: 0.96rem;
  color: var(--text-secondary);
  line-height: 1.68;
  margin-bottom: 22px;
  flex-grow: 1;
}

.blog-card-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.84rem;
  color: var(--text-muted);
  padding-top: 16px;
  border-top: 1px solid var(--border-subtle);
}
"""

with open("css/blog.css", "w", encoding="utf-8") as f:
    f.write(BLOG_CSS)
print("Updated css/blog.css (Creative Growth Lab Blog)")

# ==============================================================================
# 7. css/responsive.css (Mobile & Tablet Layouts)
# ==============================================================================
RESPONSIVE_CSS = """/* ==========================================================================
   RESPONSIVE DESIGN & MOBILE OPTIMIZATIONS (Creative Growth Lab)
   ========================================================================== */

@media (max-width: 1024px) {
  :root {
    --header-height: 72px;
    --section-spacing: 76px;
  }

  .hp-hero-editorial-wrap,
  .arch-spread-layout,
  .rs-ecom-grid {
    grid-template-columns: 1fr;
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
    gap: 18px;
  }

  .hp-floating-meta-chip {
    position: static;
    margin-top: 14px;
  }

  .hp-cta-editorial-box {
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
    f.write(RESPONSIVE_CSS)
print("Updated css/responsive.css (Creative Growth Lab Responsive)")

# ==============================================================================
# 8. js/interactions.js (Custom Cursor, Magnetic Physics, 3D Tilt, Marquee, Counters)
# ==============================================================================
INTERACTIONS_JS = """/**
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
 * 1. Custom Trailing Animated Cursor
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
    ringX += (mouseX - ringX) * 0.18;
    ringY += (mouseY - ringY) * 0.18;

    cursorRing.style.left = `${ringX}px`;
    cursorRing.style.top = `${ringY}px`;

    if (Math.abs(mouseX - ringX) > 0.1 || Math.abs(mouseY - ringY) > 0.1) {
      requestAnimationFrame(renderCursor);
    } else {
      isMoving = false;
    }
  }

  // Interactive Hover Targets
  const hoverables = document.querySelectorAll('a, button, input, select, textarea, .card, .arch-ledger-card, .service-premium-card, .hp-service-slab, .faq-question, .hp-visual-composition-frame');
  hoverables.forEach(el => {
    el.addEventListener('mouseenter', () => cursorRing.classList.add('cursor-active'));
    el.addEventListener('mouseleave', () => cursorRing.classList.remove('cursor-active'));
  });
}

/**
 * 2. Magnetic Buttons with Spring Physics
 */
function initMagneticButtons() {
  const magneticElements = document.querySelectorAll('.btn-primary, .hp-btn-primary, .rs-ecom-btn, .arch-cta-btn, .brand-monogram, .back-to-top-btn');

  magneticElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      el.style.transform = `translate(${x * 0.28}px, ${y * 0.28}px)`;
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
 * 3. 3D Perspective Card Tilt
 */
function init3DCardTilt() {
  const cards = document.querySelectorAll('.card, .arch-ledger-card, .arch-kpi-card, .service-premium-card, .hp-stat-ledger-item, .metric-strip-item, .hp-visual-composition-frame');

  cards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -6;
      const rotateY = ((x - centerX) / centerX) * 6;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translate(-2px, -2px)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translate(0px, 0px)';
      card.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1)';
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
"""

with open("js/interactions.js", "w", encoding="utf-8") as f:
    f.write(INTERACTIONS_JS)
print("Updated js/interactions.js (Creative Growth Lab Interactions)")

print("\nAll Creative Growth Lab stylesheets and scripts compiled successfully!")
