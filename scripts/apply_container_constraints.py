# 1. Update css/home-live.css with container-constrained layout
home_live_css = """/* ==========================================================================
   HOMEPAGE ARCHITECTURAL STYLESHEET (home-live.css)
   Swiss Editorial Management Consultancy Architecture - Container Constrained
   Palette: Warm off-white (#F7F7F4), Pure white (#FFFFFF),
            Deep charcoal (#171A1D), Secondary grey (#777C80),
            Muted bronze accent (#B28A55)
   ========================================================================== */

/* Main Container Constraint */
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

/* --- HERO EDITORIAL MONOLITH --- */
#hero {
  padding: calc(var(--header-height, 80px) + 36px) 0 72px;
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
  font-size: clamp(2.3rem, 4vw, 3.6rem);
  font-weight: 600;
  line-height: 1.1;
  letter-spacing: -0.025em;
  color: var(--text-primary);
  margin: 0 0 22px;
}

#hero .hp-body {
  font-size: 1.05rem;
  line-height: 1.74;
  color: var(--text-secondary);
  margin-bottom: 28px;
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
  padding: 13px 28px;
  border-radius: var(--radius-sm);
  font-family: var(--font-heading);
  font-size: 0.94rem;
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
  padding-top: 28px;
  border-top: 1px solid var(--border-color);
}

.hp-stat-ledger-item {
  display: flex;
  flex-direction: column;
}

.hp-stat-number {
  font-family: var(--font-serif);
  font-size: clamp(1.85rem, 2.6vw, 2.3rem);
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

/* Hero Visual Frame */
.hp-hero-visual-column {
  position: relative;
}

.hp-visual-composition-frame {
  position: relative;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border-color);
  background: var(--bg-surface);
  box-shadow: var(--shadow-sm);
  padding: 18px;
}

.hp-visual-composition-frame img {
  width: 100%;
  height: auto;
  max-height: 460px;
  object-fit: contain;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
}

.hp-floating-meta-chip {
  position: absolute;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 8px 14px;
  box-shadow: var(--shadow-sm);
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
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--accent-bronze);
  margin-bottom: 2px;
}

.hp-chip-val {
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: 0.86rem;
  color: var(--text-primary);
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
  color: var(--accent-bronze);
  margin-bottom: 12px;
  display: block;
  letter-spacing: 0.12em;
}

.arch-spread-title {
  font-family: var(--font-serif);
  font-size: clamp(1.85rem, 3vw, 2.5rem);
  font-weight: 600;
  line-height: 1.15;
  letter-spacing: -0.02em;
  color: var(--text-primary);
  margin-bottom: 16px;
}

.arch-spread-body-wrap {
  display: flex;
  flex-direction: column;
  gap: 22px;
  padding: 38px 36px;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  border-left: 3px solid var(--accent-bronze);
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
  color: var(--text-primary);
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
  border-radius: var(--radius-sm);
  padding: 30px 28px;
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
  margin-bottom: 16px;
}

.arch-card-coord {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-bronze);
  background: var(--accent-bronze-light);
  border: 1px solid var(--accent-bronze-subtle);
  padding: 3px 8px;
  border-radius: var(--radius-sm);
  letter-spacing: 0.08em;
}

.arch-card-icon-glyph {
  width: 36px;
  height: 36px;
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
  font-size: 1.15rem;
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
  border-radius: var(--radius-sm);
  padding: 26px 24px;
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
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  padding: 3px 8px;
  border-radius: var(--radius-sm);
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
  border-radius: var(--radius-sm);
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
  color: var(--text-primary);
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
  border-radius: var(--radius-sm);
  padding: 30px 24px;
  display: flex;
  flex-direction: column;
  border-top: 3px solid var(--text-primary);
  box-shadow: var(--shadow-sm);
  transition: border-color var(--transition-fast);
}

.arch-kpi-card:hover {
  border-top-color: var(--accent-bronze);
}

.arch-kpi-coord {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  color: var(--accent-bronze);
  margin-bottom: 12px;
}

.arch-kpi-title {
  font-family: var(--font-heading);
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--text-primary);
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
  border-radius: var(--radius-sm);
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
  color: var(--text-primary);
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
  border-radius: var(--radius-sm);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: border-color var(--transition-fast);
}

.arch-faq-item:hover,
.arch-faq-item.active {
  border-color: var(--accent-bronze);
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
  color: var(--text-primary);
  font-family: var(--font-heading);
  font-size: 1.02rem;
  font-weight: 650;
  line-height: 1.35;
}

.arch-faq-coord {
  font-family: var(--font-mono);
  font-size: 0.74rem;
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
  background-color: var(--bg-noir);
  border-radius: var(--radius-md);
  padding: 64px 40px;
  border: 1px solid var(--border-dark);
  box-shadow: var(--shadow-card);
}

.arch-cta-kicker {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.16em;
  color: var(--accent-bronze);
  margin-bottom: 18px;
}

.arch-cta-title {
  font-family: var(--font-serif);
  font-size: clamp(1.9rem, 3.4vw, 2.9rem);
  font-weight: 600;
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
  background: var(--accent-bronze);
  color: #FFFFFF !important;
  border-radius: var(--radius-sm);
  font-family: var(--font-heading);
  font-size: 0.96rem;
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
    gap: 36px;
  }
  .arch-spread-layout {
    grid-template-columns: 1fr;
    gap: 28px;
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
    padding: 56px 0;
  }
  .hp-hero-stats-ledger {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .arch-spread-body-wrap,
  .arch-advisory-framework-card,
  .arch-authority-ledger,
  .arch-cta-monolith {
    padding: 24px 18px;
  }
}
"""

with open('css/home-live.css', 'w', encoding='utf-8') as f:
    f.write(home_live_css)
print("css/home-live.css updated with container constraint")

# 2. Update css/ecommerce-page.css with container constraint
ecommerce_css = """/* ==========================================================================
   E-COMMERCE MANAGEMENT PAGE STYLES (ecommerce-page.css)
   Swiss Editorial Architecture - Container Constrained
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
  border-radius: var(--radius-sm);
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
  font-family: var(--font-serif);
  font-size: clamp(2.1rem, 3.6vw, 2.9rem);
  font-weight: 600;
  line-height: 1.12;
  letter-spacing: -0.025em;
  color: var(--text-primary);
}

.rs-ecom-subtitle {
  margin: 0 0 16px;
  font-size: clamp(1rem, 1.8vw, 1.1rem);
  font-weight: 600;
  line-height: 1.6;
  color: var(--accent-bronze);
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
  background: var(--text-primary);
  color: #FFFFFF !important;
  font-size: 0.92rem;
  font-weight: 650;
  line-height: 1;
  border-radius: var(--radius-sm);
  text-decoration: none;
  border: 1px solid var(--text-primary);
  transition: background-color var(--transition-fast), border-color var(--transition-fast);
}

.rs-cta-button:hover,
.rs-ecom-btn:hover {
  background: var(--accent-bronze);
  border-color: var(--accent-bronze);
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
  background: var(--bg-canvas);
}

/* Sections inside ecom wrapper */
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
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 56px 44px;
  max-width: 860px;
  margin: 0 auto;
  text-align: center;
  box-shadow: var(--shadow-sm);
  border-top: 3px solid var(--accent-bronze);
}

.rs-cta-card h2 {
  font-family: var(--font-serif);
  font-size: clamp(1.9rem, 3.2vw, 2.6rem);
  font-weight: 600;
  color: var(--text-primary);
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
  background: var(--accent-bronze);
  color: #FFFFFF !important;
  font-size: 0.94rem;
  font-weight: 650;
  border-radius: var(--radius-sm);
  text-decoration: none;
  border: 1px solid var(--accent-bronze);
  transition: background-color var(--transition-fast), border-color var(--transition-fast);
}

.rs-cta-button:hover {
  background: var(--accent-bronze-hover);
  border-color: var(--accent-bronze-hover);
}

@media (max-width: 900px) {
  .rs-ecom-grid {
    grid-template-columns: 1fr;
  }
}
"""

with open('css/ecommerce-page.css', 'w', encoding='utf-8') as f:
    f.write(ecommerce_css)
print("css/ecommerce-page.css updated with container constraint")
