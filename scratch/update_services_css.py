new_css = """

/* ==========================================================================
   NEO-BRUTALIST SERVICE DETAIL PAGE STYLES
   Colors: White #FFFFFF, Off-white #F8FAFC, Royal Blue #1D4ED8 / #2563EB,
   Acid Lime #D4F542 / #D9F99D, Dark #0F172A, Body text #475569
   Borders: 1.5px solid #0F172A, Hard Shadows: 3px 3px 0 #0F172A / 4px 4px 0 #0F172A
   ========================================================================== */

/* Main Container on Service Pages */
.service-page-main {
  width: 100%;
  max-width: 1320px;
  margin: 0 auto;
  padding: 0 clamp(18px, 3.5vw, 40px);
  box-sizing: border-box;
}

/* Service Detail Hero */
.service-detail-hero {
  padding-top: calc(var(--header-height, 84px) + 36px);
  padding-bottom: 56px;
  background: transparent;
  border-bottom: 2px solid #0F172A;
  position: relative;
}

.service-breadcrumbs {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 24px;
  font-size: 0.88rem;
  font-weight: 600;
}

.service-breadcrumbs a {
  color: #475569;
  text-decoration: none;
  transition: color 0.15s ease;
}

.service-breadcrumbs a:hover {
  color: #1D4ED8;
  text-decoration: underline;
}

.service-breadcrumbs .sep {
  color: #94A3B8;
  font-size: 0.82rem;
}

.service-breadcrumbs .current {
  color: #0F172A;
  font-weight: 700;
  background: #EFF6FF;
  padding: 3px 10px;
  border-radius: 999px;
  border: 1px solid #BFDBFE;
}

.service-eyebrow-row {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 20px;
}

.badge-accent {
  background: #D4F542;
  color: #0F172A;
  border: 1.5px solid #0F172A;
  box-shadow: 2px 2px 0 #0F172A;
  font-weight: 700;
  font-size: 0.78rem;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  padding: 5px 14px;
  border-radius: 999px;
}

.badge-outline {
  background: #FFFFFF;
  color: #1D4ED8;
  border: 1.5px solid #1D4ED8;
  box-shadow: 2px 2px 0 #1D4ED8;
  font-weight: 700;
  font-size: 0.78rem;
  padding: 5px 14px;
  border-radius: 999px;
}

.service-detail-title {
  font-family: var(--font-display, inherit);
  font-size: clamp(2.1rem, 3.8vw, 3.4rem);
  font-weight: 800;
  line-height: 1.18;
  letter-spacing: -0.025em;
  color: #0F172A;
  margin: 0 0 20px;
  max-width: 1040px;
}

.service-detail-lead {
  font-size: clamp(1.05rem, 1.4vw, 1.2rem);
  line-height: 1.72;
  color: #475569;
  max-width: 860px;
  margin: 0 0 32px;
}

.service-hero-actions {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 48px;
}

/* Key Stats Highlight Row */
.service-key-stats-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: clamp(14px, 1.8vw, 22px);
  padding-top: 36px;
  border-top: 1.5px solid rgba(15, 23, 42, 0.12);
}

.stat-item-block {
  background: #FFFFFF;
  border: 1.5px solid #0F172A;
  border-radius: 12px;
  padding: 22px 20px;
  box-shadow: 3px 3px 0 #0F172A;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-item-block:hover {
  transform: translate(-2px, -2px);
  box-shadow: 5px 5px 0 #0F172A;
}

.stat-item-val {
  font-family: var(--font-display, inherit);
  font-size: clamp(1.8rem, 2.6vw, 2.3rem);
  font-weight: 800;
  color: #1D4ED8;
  line-height: 1.1;
  margin-bottom: 6px;
}

.stat-item-lbl {
  font-size: 0.88rem;
  font-weight: 600;
  color: #475569;
  line-height: 1.4;
}

/* Service Content Sections */
.service-content-section {
  padding: clamp(52px, 7vw, 76px) 0;
  border-bottom: 1.5px solid rgba(15, 23, 42, 0.1);
  position: relative;
}

.section-header-compact {
  margin-bottom: 36px;
  max-width: 820px;
}

.section-header-compact.text-center {
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}

.section-eyebrow {
  display: inline-block;
  font-family: var(--font-mono, monospace);
  font-size: 0.76rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #0F172A;
  background: #D4F542;
  border: 1.5px solid #0F172A;
  padding: 3px 12px;
  border-radius: 999px;
  margin-bottom: 14px;
}

.section-title {
  font-family: var(--font-display, inherit);
  font-size: clamp(1.75rem, 2.8vw, 2.4rem);
  font-weight: 800;
  line-height: 1.24;
  letter-spacing: -0.02em;
  color: #0F172A;
  margin: 0 0 16px;
}

.section-subtitle {
  font-size: 1.05rem;
  line-height: 1.7;
  color: #475569;
  margin: 0;
}

/* Comparison Grids */
.comparison-grid-2col {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-top: 28px;
}

.comparison-box {
  background: #FFFFFF;
  border: 1.5px solid #0F172A;
  border-radius: 14px;
  padding: 32px 28px;
  box-shadow: 4px 4px 0 #0F172A;
  position: relative;
  display: flex;
  flex-direction: column;
}

.comparison-box.highlight {
  border-color: #1D4ED8;
  box-shadow: 4px 4px 0 #1D4ED8;
}

.comparison-tag {
  display: inline-block;
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 4px 10px;
  border-radius: 6px;
  margin-bottom: 14px;
  width: fit-content;
}

.comparison-tag.standard {
  background: #F1F5F9;
  color: #475569;
  border: 1px solid #CBD5E1;
}

.comparison-tag.consultant {
  background: #D4F542;
  color: #0F172A;
  border: 1.5px solid #0F172A;
}

.comparison-title {
  font-size: 1.35rem;
  font-weight: 800;
  color: #0F172A;
  margin: 0 0 14px;
  line-height: 1.3;
}

.comparison-desc {
  font-size: 1rem;
  line-height: 1.7;
  color: #475569;
  margin: 0;
}

/* Deliverables Grid */
.deliverables-grid-3col {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 24px;
  margin-top: 32px;
}

.deliverables-grid-2col {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
  gap: 24px;
  margin-top: 32px;
}

.deliverable-card {
  background: #FFFFFF;
  border: 1.5px solid #0F172A;
  border-radius: 12px;
  padding: 30px 26px;
  box-shadow: 4px 4px 0 #0F172A;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  display: flex;
  flex-direction: column;
}

.deliverable-card:hover {
  transform: translate(-2px, -2px);
  box-shadow: 6px 6px 0 #0F172A;
  border-color: #1D4ED8;
}

.deliverable-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.deliverable-num {
  font-family: var(--font-mono, monospace);
  font-size: 0.84rem;
  font-weight: 800;
  color: #0F172A;
  background: #D4F542;
  border: 1.5px solid #0F172A;
  padding: 3px 10px;
  border-radius: 999px;
}

.deliverable-tag {
  font-size: 0.75rem;
  font-weight: 700;
  color: #1D4ED8;
  background: #EFF6FF;
  padding: 3px 8px;
  border-radius: 6px;
  border: 1px solid #DBEAFE;
}

.deliverable-title {
  font-size: 1.22rem;
  font-weight: 700;
  color: #0F172A;
  line-height: 1.35;
  margin: 0 0 12px;
}

.deliverable-text {
  font-size: 0.98rem;
  line-height: 1.68;
  color: #475569;
  margin: 0;
}

/* Audience Grid / Who This Is For */
.audience-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  margin-top: 28px;
}

.audience-card {
  background: #FFFFFF;
  border: 1.5px solid #0F172A;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 3px 3px 0 #0F172A;
  display: flex;
  align-items: flex-start;
  gap: 16px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.audience-card:hover {
  transform: translate(-2px, -2px);
  box-shadow: 5px 5px 0 #0F172A;
}

.audience-icon-wrap {
  width: 36px;
  height: 36px;
  flex-shrink: 0;
  border-radius: 8px;
  background: #D4F542;
  border: 1.5px solid #0F172A;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #0F172A;
}

.audience-body-title {
  font-size: 1.05rem;
  font-weight: 700;
  color: #0F172A;
  margin: 0 0 6px;
  line-height: 1.35;
}

.audience-body-text {
  font-size: 0.94rem;
  color: #475569;
  line-height: 1.6;
  margin: 0;
}

/* Narrative / Insight Cards */
.insight-card {
  background: #FFFFFF;
  border: 1.5px solid #0F172A;
  border-left: 5px solid #1D4ED8;
  border-radius: 12px;
  padding: 28px 32px;
  box-shadow: 3px 3px 0 #0F172A;
  margin-bottom: 24px;
}

.insight-card h3 {
  font-size: 1.25rem;
  font-weight: 700;
  color: #0F172A;
  margin: 0 0 12px;
}

.insight-card p {
  font-size: 1.02rem;
  color: #475569;
  line-height: 1.7;
  margin: 0;
}

/* FAQs Section */
.service-faq-container {
  max-width: 860px;
  margin: 0 auto;
}

.faq-accordion-list {
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin-top: 32px;
}

.faq-item {
  background: #FFFFFF;
  border: 1.5px solid #0F172A;
  border-radius: 12px;
  box-shadow: 3px 3px 0 #0F172A;
  overflow: hidden;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.faq-item.active,
.faq-item.is-active {
  border-color: #1D4ED8;
  box-shadow: 4px 4px 0 #1D4ED8;
}

.faq-question {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  padding: 22px 26px;
  background: none;
  border: none;
  text-align: left;
  font-family: inherit;
  font-size: 1.05rem;
  font-weight: 700;
  color: #0F172A;
  cursor: pointer;
  transition: color 0.15s ease;
}

.faq-question:hover {
  color: #1D4ED8;
}

.faq-icon {
  flex-shrink: 0;
  color: #0F172A;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), color 0.15s ease;
}

.faq-item.active .faq-icon,
.faq-item.is-active .faq-icon {
  transform: rotate(45deg);
  color: #1D4ED8;
}

.faq-answer {
  display: none;
  padding: 0 26px 22px;
  border-top: 1px solid rgba(15, 23, 42, 0.08);
  padding-top: 16px;
  color: #475569;
  font-size: 1rem;
  line-height: 1.7;
}

.faq-item.active .faq-answer,
.faq-item.is-active .faq-answer {
  display: block;
}

/* Service CTA Banner */
.service-cta-banner {
  background: #0F172A;
  border: 2px solid #0F172A;
  border-radius: 16px;
  padding: clamp(36px, 5vw, 60px) clamp(24px, 4vw, 56px);
  box-shadow: 6px 6px 0 #1D4ED8;
  color: #FFFFFF;
  margin: 64px 0 80px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 32px;
}

.service-cta-text {
  max-width: 680px;
}

.service-cta-title {
  font-size: clamp(1.8rem, 2.8vw, 2.5rem);
  font-weight: 800;
  color: #FFFFFF;
  line-height: 1.22;
  margin: 0 0 16px;
  letter-spacing: -0.02em;
}

.service-cta-desc {
  font-size: 1.05rem;
  line-height: 1.68;
  color: #CBD5E1;
  margin: 0;
}

.service-cta-btn {
  background: #D4F542;
  color: #0F172A;
  font-family: inherit;
  font-size: 1.05rem;
  font-weight: 800;
  border: 1.5px solid #0F172A;
  border-radius: 10px;
  padding: 16px 32px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  box-shadow: 4px 4px 0 #FFFFFF;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
  cursor: pointer;
}

.service-cta-btn:hover {
  transform: translate(-2px, -2px);
  box-shadow: 6px 6px 0 #FFFFFF;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .service-key-stats-row {
    grid-template-columns: repeat(2, 1fr);
  }
  .comparison-grid-2col {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .service-key-stats-row {
    grid-template-columns: 1fr;
  }
  .deliverables-grid-3col,
  .deliverables-grid-2col {
    grid-template-columns: 1fr;
  }
  .service-cta-banner {
    padding: 32px 20px;
  }
}
"""

with open('css/services.css', 'r', encoding='utf-8') as f:
    orig = f.read()

# Only append if not already present
if 'NEO-BRUTALIST SERVICE DETAIL PAGE STYLES' not in orig:
    with open('css/services.css', 'w', encoding='utf-8') as f:
        f.write(orig + new_css)
    print("Successfully appended neo-brutalist service detail styles to css/services.css")
else:
    print("Styles already present in css/services.css")
