# -*- coding: utf-8 -*-
import os
import re

BASE_DIR = r"c:\Users\techs\OneDrive\Desktop\ritwik sachdeva"
os.chdir(BASE_DIR)

with open("css/style.css", "r", encoding="utf-8") as f:
    css = f.read()

# Replace the Navigation section with the complete robust Header styles
nav_replacement = """/* ==========================================================================
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
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}

.desktop-nav {
  display: flex;
  align-items: center;
  gap: 32px;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 28px;
  list-style: none;
  margin: 0;
  padding: 0;
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

.mobile-nav-toggle.active .hamburger-line:nth-child(1),
.mobile-toggle.active span:nth-child(1) {
  transform: translateY(8px) rotate(45deg);
}
.mobile-nav-toggle.active .hamburger-line:nth-child(2),
.mobile-toggle.active span:nth-child(2) {
  opacity: 0;
}
.mobile-nav-toggle.active .hamburger-line:nth-child(3),
.mobile-toggle.active span:nth-child(3) {
  transform: translateY(-8px) rotate(-45deg);
}"""

# Replace Section 5 in css
css = re.sub(
    r'/\* ==========================================================================\s*5\. NAVIGATION.*?(?=/\* ==========================================================================\s*6\. CREATIVE CTA BUTTONS)',
    nav_replacement + "\n\n",
    css,
    flags=re.DOTALL
)

# Now append Section 11: ABOUT PAGE — CREATIVE GROWTH LAB UI
about_css = """
/* ==========================================================================
   11. ABOUT PAGE — CREATIVE GROWTH LAB UI
   ========================================================================== */
.about-preview-grid {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: 56px;
  align-items: center;
}

.about-preview-image-wrap {
  position: relative;
  background: #FFFFFF;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 14px;
  box-shadow: 8px 8px 0px #171717;
  transition: all var(--transition-smooth);
}

.about-preview-image-wrap:hover {
  transform: translate(-3px, -3px);
  box-shadow: 12px 12px 0px var(--cobalt-blue);
}

.about-preview-portrait {
  overflow: hidden;
  border-radius: var(--radius-md);
  border: 1px solid var(--border-color);
  background: var(--bg-secondary);
}

.about-preview-img {
  width: 100%;
  height: auto;
  aspect-ratio: 4/5;
  object-fit: cover;
  display: block;
  transition: transform var(--transition-smooth);
}

.about-preview-image-wrap:hover .about-preview-img {
  transform: scale(1.02);
}

.about-badge-experience {
  position: absolute;
  bottom: -20px;
  right: -20px;
  background: var(--acid-lime);
  color: #171717;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-md);
  padding: 14px 20px;
  box-shadow: 4px 4px 0px #171717;
  display: flex;
  flex-direction: column;
  z-index: 2;
  transition: all var(--transition-fast);
}

.about-badge-experience:hover {
  transform: translate(-2px, -2px);
  box-shadow: 6px 6px 0px var(--cobalt-blue);
}

.about-badge-exp-num {
  font-family: var(--font-display);
  font-size: 2.2rem;
  font-weight: 700;
  line-height: 1;
  color: #171717;
  margin-bottom: 4px;
}

.about-badge-exp-text {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: #171717;
  max-width: 130px;
  line-height: 1.3;
}

/* Expertise Grid (3 & 4 Columns) */
.expertise-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 26px;
  margin-top: 36px;
}

.card-icon {
  width: 48px;
  height: 48px;
  border-radius: var(--radius-sm);
  background: var(--acid-lime);
  color: #171717;
  border: 1px solid var(--border-strong);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  box-shadow: 2px 2px 0px #171717;
  transition: all var(--transition-fast);
}

.card:hover .card-icon {
  transform: translate(-2px, -2px);
  box-shadow: 4px 4px 0px var(--cobalt-blue);
  background: var(--cobalt-blue);
  color: #FFFFFF;
  border-color: var(--cobalt-blue);
}

.step-phase {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--cobalt-blue);
  background: var(--cobalt-light);
  border: 1px solid rgba(36, 75, 255, 0.25);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  display: inline-block;
  margin-bottom: 12px;
}

.badge-tag {
  font-family: var(--font-mono);
  font-size: 0.76rem;
  font-weight: 700;
  background: var(--acid-lime);
  color: #171717;
  border: 1px solid var(--border-strong);
  padding: 4px 12px;
  border-radius: var(--radius-pill);
  box-shadow: 2px 2px 0px #171717;
}

.pillar-bullet {
  width: 40px;
  height: 40px;
  border-radius: var(--radius-sm);
  background: #171717;
  color: var(--acid-lime);
  border: 1px solid #171717;
  font-family: var(--font-display);
  font-weight: 700;
  font-size: 1.1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 2px 2px 0px var(--cobalt-blue);
}

/* About Page Final CTA Section */
.final-cta-section {
  padding: 88px 0 104px;
}

.cta-box {
  background: #FFFFFF;
  border: 2px solid var(--border-strong);
  border-radius: var(--radius-lg);
  padding: 68px 48px;
  text-align: center;
  box-shadow: 8px 8px 0px #171717;
  position: relative;
  overflow: hidden;
}

.cta-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 6px;
  background: linear-gradient(90deg, #244BFF, #D5FF45, #FF765C);
}

.cta-title {
  font-family: var(--font-display);
  font-size: clamp(2.2rem, 3.8vw, 3.2rem);
  font-weight: 700;
  line-height: 1.15;
  color: var(--text-primary);
  margin-bottom: 18px;
}

.cta-desc {
  font-size: 1.12rem;
  line-height: 1.72;
  color: var(--text-secondary);
  max-width: 680px;
  margin: 0 auto 36px auto;
}

.cta-btn-group {
  display: flex;
  gap: 18px;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}

/* Section Header & Subtitle Utilities */
.section-header {
  margin-bottom: 40px;
}

.section-header.text-center {
  text-align: center;
}

.section-subtitle {
  font-size: 1.08rem;
  line-height: 1.68;
  color: var(--text-secondary);
  max-width: 680px;
  margin-top: 10px;
}

.section-header.text-center .section-subtitle {
  margin-left: auto;
  margin-right: auto;
}
"""

if "11. ABOUT PAGE" not in css:
    css += "\n" + about_css

with open("css/style.css", "w", encoding="utf-8") as f:
    f.write(css)
print("Updated css/style.css with complete Header & About UI!")

# Now update about.html to use the portrait and enhanced blockquote styling
with open("about.html", "r", encoding="utf-8") as f:
    about_html = f.read()

# Replace svg with Best-Digital-Marketing-Consultant-in-Delhi.webp if present
if "assets/images/about-consultant.svg" in about_html:
    about_html = about_html.replace(
        'src="assets/images/about-consultant.svg"',
        'src="assets/images/Best-Digital-Marketing-Consultant-in-Delhi.webp"'
    )

# Enhance blockquote styling
about_html = re.sub(
    r'<blockquote style="[^"]*">',
    r'<blockquote style="border-left: 4px solid var(--cobalt-blue); padding: 18px 24px; font-style: italic; color: var(--text-primary); margin: 24px 0; font-size: 1.1rem; background: var(--bg-secondary); border-radius: 0 var(--radius-md) var(--radius-md) 0; box-shadow: 2px 2px 0px #171717; border: 1px solid var(--border-strong); border-left: 4px solid var(--cobalt-blue);">',
    about_html
)

with open("about.html", "w", encoding="utf-8") as f:
    f.write(about_html)
print("Updated about.html with portrait asset and enhanced blockquote!")
