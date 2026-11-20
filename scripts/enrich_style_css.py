with open('css/style.css', 'r', encoding='utf-8') as f:
    content = f.read()

additional_components = """
/* ==========================================================================
   10. EDITORIAL COMPONENTS (ABOUT, METHODOLOGY, EXPERTISE, TESTIMONIALS)
   ========================================================================== */
.text-gradient {
  color: var(--accent-bronze);
  font-family: inherit;
  background: none !important;
  -webkit-text-fill-color: initial !important;
}

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
  font-family: var(--font-serif);
  font-size: clamp(1.9rem, 3.2vw, 2.7rem);
  font-weight: 600;
  line-height: 1.15;
  letter-spacing: -0.02em;
  color: var(--text-primary);
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
  border-radius: var(--radius-sm);
  padding: 34px 30px;
  box-shadow: var(--shadow-sm);
  transition: border-color var(--transition-fast);
  position: relative;
}

.card:hover {
  border-color: var(--accent-bronze);
}

.card-icon {
  width: 42px;
  height: 42px;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--accent-bronze);
  margin-bottom: 18px;
}

.step-phase {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 700;
  color: var(--accent-bronze);
  text-transform: uppercase;
  letter-spacing: 0.12em;
  margin-bottom: 8px;
}

.badge-tag {
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
  color: var(--text-primary);
  display: inline-block;
}

/* About Preview Layout */
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
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  overflow: hidden;
  background: var(--bg-surface);
  padding: 16px;
  box-shadow: var(--shadow-sm);
}

.about-preview-img {
  width: 100%;
  height: auto;
  max-height: 480px;
  object-fit: cover;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
}

.about-badge-experience {
  position: absolute;
  bottom: 24px;
  right: -14px;
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 14px 20px;
  box-shadow: var(--shadow-card);
}

.about-badge-exp-num {
  font-family: var(--font-serif);
  font-size: 2.2rem;
  font-weight: 600;
  color: var(--text-primary);
  line-height: 1;
}

.about-badge-exp-text {
  font-family: var(--font-mono);
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--accent-bronze);
  font-weight: 600;
  margin-top: 4px;
}

/* Methodology Timeline */
.methodology-timeline {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 40px;
}

.methodology-step {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 28px 24px;
  box-shadow: var(--shadow-sm);
  border-top: 3px solid var(--text-primary);
  transition: border-color var(--transition-fast);
}

.methodology-step:hover {
  border-top-color: var(--accent-bronze);
}

/* Testimonial Editorial Presentation */
.testimonial-track-container {
  overflow: hidden;
  position: relative;
}

.testimonial-track {
  display: flex;
  transition: transform 0.4s ease;
}

.testimonial-slide {
  min-width: 100%;
  box-sizing: border-box;
}

.testimonial-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 44px;
  box-shadow: var(--shadow-sm);
  border-left: 3px solid var(--accent-bronze);
}

.testimonial-quote {
  font-family: var(--font-serif);
  font-size: clamp(1.2rem, 2vw, 1.45rem);
  line-height: 1.6;
  color: var(--text-primary);
  font-style: italic;
  margin-bottom: 24px;
}

.testimonial-client {
  display: flex;
  align-items: center;
  gap: 14px;
}

.testimonial-avatar {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
}

.testimonial-name {
  font-family: var(--font-heading);
  font-size: 0.96rem;
  font-weight: 700;
  color: var(--text-primary);
}

.testimonial-role {
  font-family: var(--font-mono);
  font-size: 0.74rem;
  color: var(--text-muted);
}

.slider-controls {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  margin-top: 28px;
}

.slider-btn {
  width: 40px;
  height: 40px;
  border-radius: var(--radius-sm);
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text-primary);
  cursor: pointer;
  transition: all var(--transition-fast);
}

.slider-btn:hover {
  background: var(--text-primary);
  color: #FFFFFF;
  border-color: var(--text-primary);
}

.slider-dots {
  display: flex;
  gap: 8px;
}

.slider-dot {
  width: 24px;
  height: 2px;
  background: var(--border-strong);
  cursor: pointer;
  border: 0;
  transition: background-color var(--transition-fast);
}

.slider-dot.active {
  background: var(--accent-bronze);
}

@media (max-width: 992px) {
  .expertise-grid {
    grid-template-columns: 1fr;
  }
  .about-preview-grid {
    grid-template-columns: 1fr;
  }
  .methodology-timeline {
    grid-template-columns: repeat(2, 1fr);
  }
  .footer-grid {
    grid-template-columns: 1fr 1fr;
    gap: 36px;
  }
}

@media (max-width: 640px) {
  .methodology-timeline {
    grid-template-columns: 1fr;
  }
  .footer-grid {
    grid-template-columns: 1fr;
    gap: 32px;
  }
}
"""

with open('css/style.css', 'w', encoding='utf-8') as f:
    f.write(content + additional_components)

print("css/style.css enriched with editorial components")
