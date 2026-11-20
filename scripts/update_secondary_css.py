# Update css/ecommerce-page.css to pure Swiss editorial
ecommerce_css = """/* ==========================================================================
   E-COMMERCE MANAGEMENT PAGE STYLES (ecommerce-page.css)
   Swiss Editorial Management Consultancy Architecture
   Palette: Warm off-white (#F7F7F4), Pure white (#FFFFFF),
            Deep charcoal (#171A1D), Secondary grey (#777C80),
            Muted bronze accent (#B28A55)
   ========================================================================== */

.rs-ecom-hero {
  width: 100%;
  padding: calc(var(--header-height, 80px) + 40px) 24px 64px;
  background: var(--bg-canvas);
  font-family: var(--font-body);
  border-bottom: 1px solid var(--border-color);
}

.rs-ecom-hero,
.rs-ecom-hero * {
  box-sizing: border-box;
}

.rs-ecom-container {
  max-width: var(--container-max, 1240px);
  margin: 0 auto;
}

.rs-ecom-grid {
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 36px;
  align-items: stretch;
  width: 100%;
}

.rs-ecom-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-sm);
}

.rs-ecom-text-card {
  padding: 44px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.rs-ecom-title {
  margin: 0 0 16px;
  font-family: var(--font-serif);
  font-size: clamp(2.2rem, 3.8vw, 3.1rem);
  font-weight: 600;
  line-height: 1.12;
  letter-spacing: -0.025em;
  color: var(--text-primary);
}

.rs-ecom-subtitle {
  margin: 0 0 16px;
  font-size: clamp(1.02rem, 1.8vw, 1.12rem);
  font-weight: 600;
  line-height: 1.6;
  color: var(--accent-bronze);
}

.rs-ecom-desc {
  margin: 0 0 28px;
  font-size: 0.98rem;
  line-height: 1.7;
  color: var(--text-secondary);
}

.rs-ecom-btn,
.rs-ecom-visual-card {
  align-items: center;
  justify-content: center;
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
  padding: 24px;
  display: flex;
  overflow: hidden;
  background: var(--bg-surface);
}

.rs-ecom-visual-card img {
  width: 100%;
  height: auto;
  max-height: 480px;
  object-fit: contain;
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
}

/* --- Content Sections --- */
.rs-ecom-section {
  padding: 80px 24px;
  border-bottom: 1px solid var(--border-color);
  background: var(--bg-canvas);
}

.rs-ecom-section.rs-bg-alt {
  background: var(--bg-surface);
}

.rs-section-title {
  font-family: var(--font-serif);
  font-size: clamp(1.85rem, 3vw, 2.4rem);
  font-weight: 600;
  line-height: 1.2;
  letter-spacing: -0.02em;
  color: var(--text-primary);
  margin-bottom: 24px;
}

.rs-editorial-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 36px 32px;
  box-shadow: var(--shadow-sm);
}

.rs-ecom-section.rs-bg-alt .rs-editorial-card {
  background: var(--bg-canvas);
}

.rs-editorial-card p {
  font-size: 1.02rem;
  line-height: 1.74;
  color: var(--text-secondary);
  max-width: 100%;
  margin-bottom: 16px;
}

.rs-editorial-card p:last-child {
  margin-bottom: 0;
}

/* Services 2-col Grid */
.rs-services-2col {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-top: 24px;
}

.rs-service-feature-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  padding: 28px 24px;
  box-shadow: var(--shadow-sm);
  transition: border-color var(--transition-fast);
}

.rs-service-feature-card:hover {
  border-color: var(--accent-bronze);
}

.rs-service-feature-title {
  font-family: var(--font-heading);
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 8px;
}

.rs-service-feature-desc {
  font-size: 0.92rem;
  line-height: 1.65;
  color: var(--text-secondary);
  margin: 0;
}

/* FAQ Minimal Accordion */
.rs-faq-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
  max-width: 860px;
  margin: 24px auto 0;
}

.rs-faq-item {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
  overflow: hidden;
  transition: border-color var(--transition-fast);
}

.rs-faq-item:hover,
.rs-faq-item.active {
  border-color: var(--accent-bronze);
}

.rs-faq-question {
  width: 100%;
  padding: 20px 24px;
  background: transparent;
  border: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  cursor: pointer;
  text-align: left;
  font-family: var(--font-heading);
  font-size: 1.02rem;
  font-weight: 650;
  color: var(--text-primary);
}

.rs-faq-icon {
  font-size: 1.25rem;
  font-weight: 400;
  color: var(--accent-bronze);
  transition: transform var(--transition-fast);
}

.rs-faq-item.active .rs-faq-icon {
  transform: rotate(45deg);
  color: var(--text-primary);
}

.rs-faq-answer {
  display: none;
  padding: 0 24px 20px;
  font-size: 0.96rem;
  line-height: 1.7;
  color: var(--text-secondary);
  border-top: 1px solid var(--border-subtle);
}

.rs-faq-item.active .rs-faq-answer {
  display: block;
}

/* Monolith CTA */
.rs-cta-monolith {
  padding: 88px 24px;
  background: var(--bg-noir);
  color: #FFFFFF;
  text-align: center;
}

.rs-cta-title {
  font-family: var(--font-serif);
  font-size: clamp(2rem, 3.6vw, 2.9rem);
  font-weight: 600;
  color: #FFFFFF;
  margin-bottom: 18px;
}

.rs-cta-desc {
  font-size: 1.05rem;
  line-height: 1.72;
  color: #CBD0D5;
  max-width: 660px;
  margin: 0 auto 32px;
}

.rs-cta-button {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 34px;
  background: var(--accent-bronze);
  color: #FFFFFF !important;
  font-size: 0.96rem;
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
  .rs-services-2col {
    grid-template-columns: 1fr;
  }
}
"""

with open('css/ecommerce-page.css', 'w', encoding='utf-8') as f:
    f.write(ecommerce_css)
print("css/ecommerce-page.css updated")

# Update css/blog.css to pure Swiss editorial
blog_css = """/* ==========================================================================
   BLOG CMS & EDITORIAL STYLES - RITWIK SACHDEVA
   Swiss Editorial Management Consultancy Architecture
   ========================================================================== */

.blog-hero {
  padding-top: calc(var(--header-height) + 48px);
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
  background-color: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: var(--radius-sm);
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
  border-radius: var(--radius-sm);
  background: var(--bg-canvas);
  color: var(--text-secondary);
  font-size: 0.84rem;
  font-weight: 600;
  text-decoration: none;
  transition: all var(--transition-fast);
  border: 1px solid var(--border-color);
}

.category-pill:hover,
.category-pill.active {
  background: var(--text-primary);
  color: #FFFFFF;
  border-color: var(--text-primary);
}

.category-pill-count {
  display: inline-block;
  padding: 1px 6px;
  border-radius: var(--radius-sm);
  background: rgba(23, 26, 29, 0.08);
  font-size: 0.72rem;
  font-weight: 600;
}

.category-pill.active .category-pill-count {
  background: var(--accent-bronze);
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
  border-radius: var(--radius-sm);
  border: 1px solid var(--border-color);
  background: var(--bg-canvas);
  color: var(--text-primary);
  font-size: 0.88rem;
  font-family: var(--font-body);
  transition: border-color var(--transition-fast);
}

.blog-search-input:focus {
  outline: none;
  background: #FFFFFF;
  border-color: var(--accent-bronze);
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
  border-radius: var(--radius-sm);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  margin-top: 36px;
  margin-bottom: 56px;
  transition: border-color var(--transition-fast);
}

.featured-blog-card:hover {
  border-color: var(--accent-bronze);
}

.featured-blog-img-wrap {
  position: relative;
  overflow: hidden;
  min-height: 320px;
  background: var(--bg-canvas);
}

.featured-blog-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
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
  border-radius: var(--radius-sm);
  font-family: var(--font-mono);
  font-size: 0.72rem;
  font-weight: 600;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  background: var(--accent-bronze-light);
  color: var(--accent-bronze);
  border: 1px solid var(--accent-bronze-subtle);
  margin-bottom: 12px;
  width: fit-content;
}

.featured-badge {
  background: var(--accent-bronze);
  color: #FFFFFF;
  border: 1px solid var(--accent-bronze);
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
  background-color: var(--border-strong);
}

.featured-blog-title {
  font-family: var(--font-serif);
  font-size: clamp(1.45rem, 2.4vw, 2rem);
  font-weight: 600;
  line-height: 1.25;
  margin-bottom: 14px;
  color: var(--text-primary);
}

.featured-blog-title a {
  color: inherit;
  text-decoration: none;
  transition: color var(--transition-fast);
}

.featured-blog-title a:hover {
  color: var(--accent-bronze);
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
  border-radius: var(--radius-sm);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  display: flex;
  flex-direction: column;
  transition: border-color var(--transition-fast);
}

.blog-card:hover {
  border-color: var(--accent-bronze);
}

.blog-card-media {
  position: relative;
  width: 100%;
  height: 200px;
  overflow: hidden;
  background-color: var(--bg-canvas);
}

.blog-card-media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.blog-card-body {
  padding: 22px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.blog-card-title {
  font-family: var(--font-serif);
  font-size: 1.25rem;
  font-weight: 600;
  line-height: 1.3;
  margin-bottom: 10px;
  color: var(--text-primary);
}

.blog-card-title a {
  color: inherit;
  text-decoration: none;
  transition: color var(--transition-fast);
}

.blog-card-title a:hover {
  color: var(--accent-bronze);
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
  border-radius: var(--radius-sm);
  object-fit: cover;
  background: var(--bg-canvas);
  border: 1px solid var(--border-color);
}

.author-meta-name {
  font-size: 0.82rem;
  font-weight: 650;
  color: var(--text-primary);
  display: block;
}

.author-meta-date {
  font-size: 0.74rem;
  color: var(--text-muted);
  display: block;
}

.read-more-link {
  font-size: 0.84rem;
  font-weight: 650;
  color: var(--text-primary);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: color var(--transition-fast);
}

.read-more-link:hover {
  color: var(--accent-bronze);
}

@media (max-width: 992px) {
  .featured-blog-card {
    grid-template-columns: 1fr;
  }
  .blog-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 640px) {
  .blog-grid {
    grid-template-columns: 1fr;
  }
}
"""

with open('css/blog.css', 'w', encoding='utf-8') as f:
    f.write(blog_css)
print("css/blog.css updated")
