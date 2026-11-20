import re

new_main_content = """  <main id="main-content">
    <!-- HERO SECTION -->
    <section id="hero" class="hp-section hp-section-hero">
      <div class="hp-container">
        <div class="hp-hero-editorial-wrap">
          <div class="hp-hero-copy-column">
            <div class="hp-hero-kicker-bar">
              <span class="hp-hero-kicker">Strategic Digital Marketing Consultancy</span>
            </div>
            <h1 class="hp-h1">Best Digital Marketing Consultant in Delhi - Ritwik Sachdeva</h1>
            <p class="hp-body hero-description">Ritwik Sachdeva is a digital marketing consultant in Delhi working with startups, D2C brands, SMEs, and B2B companies across Delhi to plan and run digital marketing that's built around measurable results - not just channel activity. If you're comparing options for a digital marketing strategist in Delhi, here's a direct look at what the work actually involves.</p>
            <div class="hp-hero-actions-row">
              <a class="hp-btn hp-btn-primary" href="contact.html">Book a Consultation</a>
            </div>
            <div class="hp-hero-stats-ledger">
              <div class="hp-stat-ledger-item">
                <span class="hp-stat-number">10+</span>
                <span class="hp-stat-label">Years of Experience</span>
              </div>
              <div class="hp-stat-ledger-item">
                <span class="hp-stat-number">50+</span>
                <span class="hp-stat-label">Projects Delivered</span>
              </div>
              <div class="hp-stat-ledger-item">
                <span class="hp-stat-number">5.0</span>
                <span class="hp-stat-label">Client Rating</span>
              </div>
            </div>
          </div>
          <div class="hp-hero-visual-column">
            <div class="hp-visual-composition-frame">
              <img fetchpriority="high" decoding="async" src="assets/images/Best-Digital-Marketing-Consultant-in-Delhi.webp" alt="Best Digital Marketing Consultant in Delhi - Ritwik Sachdeva" width="1000" height="1000">
              <div class="hp-floating-meta-chip hp-chip-top">
                <div class="hp-chip-title">Consultancy Practice</div>
                <div class="hp-chip-val">Full-Funnel Growth</div>
              </div>
              <div class="hp-floating-meta-chip hp-chip-bottom">
                <div class="hp-chip-title">Accountability</div>
                <div class="hp-chip-val">Direct ROI &amp; Revenue</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 1: WHAT A DIGITAL MARKETING CONSULTANT DOES -->
    <section id="what-consultant-does">
      <div class="hp-container">
        <div class="arch-spread-layout">
          <div class="arch-spread-header">
            <span class="arch-spread-index">01 / DISCOVERY</span>
            <h2 class="arch-spread-title">What a Digital Marketing Consultant Actually Does</h2>
          </div>
          <div class="arch-spread-body-wrap">
            <p>A lot of businesses hire "digital marketing help" and end up with someone running ads or posting content in isolation, with no connective strategy behind either. A digital marketing consultant's job is different: full-funnel digital marketing advisory that connects digital media planning &amp; buying, inbound and outbound marketing strategy, and execution into one plan that's accountable to a number - leads, sales, or revenue - rather than impressions.</p>
            <p>As a digital marketing strategist in Delhi, Ritwik works across strategy and execution together, which matters because a channel plan that ignores strategy usually burns budget, and a strategy that never gets executed properly never shows results either.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2: DIGITAL MARKETING SERVICES IN DELHI -->
    <section id="services">
      <div class="hp-container">
        <span class="arch-spread-index">02 / PRACTICE CAPABILITIES</span>
        <h2 class="hp-h2" style="font-family: var(--font-display); font-size: clamp(2rem, 3.4vw, 2.85rem); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 16px;">Digital Marketing Services in Delhi</h2>
        <div class="arch-ledger-grid">
          <a href="service-seo-expert.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 01</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">SEO &amp; PPC Consultant Delhi</h3>
            </div>
            <p class="arch-card-desc">Search engine optimization (technical SEO, content structure, on-page fixes) combined with pay-per-click (PPC) and Google Ads management, so organic and paid channels are working from the same keyword and intent strategy instead of competing with each other.</p>
          </a>

          <a href="service-performance-marketing.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 02</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">Performance Marketing Consultant Delhi</h3>
            </div>
            <p class="arch-card-desc">Search engine marketing (SEM) and paid social campaigns built around customer acquisition cost (CAC) and ROAS optimization - tracked and adjusted against actual numbers, not just spend.</p>
          </a>

          <a href="service-social-media-marketing.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 03</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">Social Media Marketing Consultant Delhi</h3>
            </div>
            <p class="arch-card-desc">Social media marketing (SMM) and Meta Ads strategy focused on the platforms your actual customers use, with messaging tied back to the brand's positioning rather than generic content calendars.</p>
          </a>

          <a href="service-best-marketing-consultant.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 04</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect><path d="M9 3v18M3 9h18"></path>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">Growth Marketing Consultant in Delhi</h3>
            </div>
            <p class="arch-card-desc">Conversion rate optimization (CRO) and A/B testing and performance tracking analytics applied across landing pages and funnels, so traffic that's already being paid for converts at a higher rate before spend increases further.</p>
          </a>

          <a href="service-best-marketing-consultant.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 05</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><path d="M2 10h20"></path>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">B2B Digital Marketing Consultant Delhi</h3>
            </div>
            <p class="arch-card-desc">Lead generation &amp; sales funnel optimization for longer B2B buying cycles, including marketing automation &amp; CRM integration so leads don't fall through the cracks between marketing and sales.</p>
          </a>

          <a href="service-ecommerce-management.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 06</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path><line x1="2" y1="12" x2="22" y2="12"></line>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">E-commerce Digital Marketing Consultant Delhi</h3>
            </div>
            <p class="arch-card-desc">Full-funnel digital campaigns for D2C and e-commerce brands - SEO, paid acquisition, and CRO working together to move CAC down and repeat purchase rate up.</p>
          </a>

          <a href="service-best-marketing-consultant.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 07</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">Digital Marketing Advisory Services Delhi</h3>
            </div>
            <p class="arch-card-desc">For businesses that need a strategist to guide an in-house team or existing agency rather than run every channel personally - content marketing &amp; semantic strategy, channel prioritization, and campaign review.</p>
          </a>

          <a href="service-ppc-expert.html" class="arch-ledger-card">
            <div>
              <div class="arch-card-top">
                <span class="arch-card-coord">PRACTICE / 08</span>
                <div class="arch-card-icon-glyph">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line>
                  </svg>
                </div>
              </div>
              <h3 class="arch-card-title">Lead Generation Strategist Delhi</h3>
            </div>
            <p class="arch-card-desc">Structured lead generation systems where funnel design, ad targeting, and automation work together instead of leads landing in a spreadsheet nobody follows up on.</p>
          </a>
        </div>
      </div>
    </section>

    <!-- SECTION 3: WHO THIS IS FOR -->
    <section id="who-for">
      <div class="hp-container">
        <span class="arch-spread-index">03 / TARGET AUDIENCE</span>
        <h2 class="hp-h2" style="font-family: var(--font-display); font-size: clamp(2rem, 3.4vw, 2.85rem); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 16px;">Who This Is For</h2>
        <div class="arch-archetype-grid">
          <div class="arch-archetype-item">
            <span class="arch-archetype-tag">ARCHETYPE 01</span>
            <span>Startups, D2C brands &amp; e-commerce stores looking for a repeatable, trackable acquisition channel</span>
          </div>
          <div class="arch-archetype-item">
            <span class="arch-archetype-tag">ARCHETYPE 02</span>
            <span>Small and medium enterprises (SMEs/MSMEs in Delhi) that need strategic direction without hiring a full in-house digital team</span>
          </div>
          <div class="arch-archetype-item">
            <span class="arch-archetype-tag">ARCHETYPE 03</span>
            <span>B2B companies &amp; corporate enterprises running longer sales cycles that need structured lead generation, not just top-of-funnel awareness</span>
          </div>
          <div class="arch-archetype-item">
            <span class="arch-archetype-tag">ARCHETYPE 04</span>
            <span>Businesses based in South Delhi, West Delhi, Gurgaon, Noida, and Faridabad - digital marketing strategy doesn't change much across Delhi, but local market context does, and that's factored into the plan</span>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 4: CHOOSING A DIGITAL MARKETING CONSULTANT IN DELHI -->
    <section id="choosing-consultant">
      <div class="hp-container">
        <span class="arch-spread-index">04 / SELECTION CRITERIA</span>
        <h2 class="hp-h2" style="font-family: var(--font-display); font-size: clamp(2rem, 3.4vw, 2.85rem); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 16px;">Choosing a Digital Marketing Consultant in Delhi</h2>
        <div class="arch-advisory-framework-card">
          <p>For small businesses and startups, the right digital marketing consultant in Delhi is usually the one willing to start with your numbers - current CAC, conversion rate, average order value - rather than a generic package. A freelance digital marketing consultant working directly with you (as opposed to being routed through account managers at a large agency) tends to move faster on strategy changes, since there's no internal hand-off between the person deciding the strategy and the person adjusting the campaign.</p>
          <p>On cost: digital marketing consultancy pricing in Delhi varies a lot depending on scope - a one-time strategy audit is priced very differently from ongoing full-funnel management across SEO, PPC, and social. Rather than quote a number that wouldn't apply to your specific situation, the more useful first step is usually a conversation about what you actually need done.</p>
          <p>For startups specifically looking for an affordable digital marketing consultant, the practical approach is often to start with a focused engagement - one channel or one funnel stage - and expand once that's showing results, instead of committing to a full retainer upfront.</p>
        </div>
      </div>
    </section>

    <!-- SECTION 5: RESULTS-FOCUSED DIGITAL MARKETING -->
    <section id="results-focused-marketing">
      <div class="hp-container">
        <span class="arch-spread-index">05 / ACCOUNTABILITY MATRIX</span>
        <h2 class="hp-h2" style="font-family: var(--font-display); font-size: clamp(2rem, 3.4vw, 2.85rem); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 16px;">Results-Focused Digital Marketing</h2>
        <p class="hp-body" style="font-size: 1.15rem; color: var(--text-secondary); max-width: 820px; margin: 0 0 32px; line-height: 1.7;">An ROI-driven digital marketing consultant in Delhi should be able to explain, for any recommendation, what number it's meant to move and how that'll be tracked. That applies whether the goal is:</p>
        <div class="arch-kpi-matrix-grid">
          <div class="arch-kpi-card">
            <span class="arch-kpi-coord">PILLAR 01</span>
            <div style="margin-bottom: 12px; color: var(--accent-primary);">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line>
              </svg>
            </div>
            <h3 class="arch-kpi-title">Lead generation and sales</h3>
            <p class="arch-kpi-desc">where the metric that matters is qualified leads and close rate, not just form fills</p>
          </div>
          <div class="arch-kpi-card">
            <span class="arch-kpi-coord">PILLAR 02</span>
            <div style="margin-bottom: 12px; color: var(--accent-primary);">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
              </svg>
            </div>
            <h3 class="arch-kpi-title">Brand visibility for a D2C launch</h3>
            <p class="arch-kpi-desc">where early-stage tracking looks more like engagement and repeat traffic before it becomes hard sales numbers</p>
          </div>
          <div class="arch-kpi-card">
            <span class="arch-kpi-coord">PILLAR 03</span>
            <div style="margin-bottom: 12px; color: var(--accent-primary);">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 17 9 11 13 15 21 7"></polyline><polyline points="14 7 21 7 21 14"></polyline>
              </svg>
            </div>
            <h3 class="arch-kpi-title">Performance-based scaling</h3>
            <p class="arch-kpi-desc">where an existing channel already works and the job is optimizing CAC and ROAS at higher spend without breaking what's working</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 6: TRUSTED BY BUSINESSES SEARCHING FOR -->
    <section id="trusted-businesses-searching">
      <div class="hp-container">
        <span class="arch-spread-index">06 / AUTHORITY &amp; DEMAND</span>
        <h2 class="hp-h2" style="font-family: var(--font-display); font-size: clamp(2rem, 3.4vw, 2.85rem); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 16px;">Trusted by Businesses Searching For</h2>
        <div class="arch-authority-ledger">
          <p>People evaluating a digital marketing consultant in Delhi are often comparing across a few different searches - best digital marketing consultant in Delhi for small business, freelance digital marketing consultant in Delhi, B2B digital marketing consultant in Delhi, digital marketing consultant in South Delhi, top performance marketing consultant in Delhi, and startup digital marketing consultant Delhi. The common thread across all of them is the same: someone who understands both the strategy and the execution well enough to be accountable for the outcome, not just the activity.</p>
          <div class="arch-searches-cloud">
            <span style="color: var(--accent-primary); font-weight: 700; margin-right: 8px;">Related searches:</span>
            Top digital marketing consultants in Delhi &middot; SEO and PPC consultant in Delhi &middot; Growth marketing consultant Delhi &middot; Social media marketing expert in Delhi &middot; Digital marketing advisory services Delhi &middot; E-commerce digital marketing consultant Delhi &middot; Lead generation consultant Delhi
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 7: FREQUENTLY ASKED QUESTIONS -->
    <section id="dm-faq">
      <div class="hp-container">
        <div style="text-align: center; max-width: 780px; margin: 0 auto 36px;">
          <span class="arch-spread-index">07 / FAQ DOSSIER</span>
          <h2 class="faq-title" style="font-family: var(--font-display); font-size: clamp(2rem, 3.4vw, 2.85rem); font-weight: 800; letter-spacing: -0.03em; margin: 0 0 16px;">Frequently Asked Questions</h2>
        </div>
        <div class="arch-faq-list">
          <div class="arch-faq-item">
            <button class="arch-faq-question faq-question" type="button" aria-expanded="false">
              <span><span class="arch-faq-coord">01</span> Who is the best digital marketing consultant in Delhi?</span>
              <span class="arch-faq-toggle-icon">+</span>
            </button>
            <div class="arch-faq-answer">
              If you're looking for a digital marketing consultant focused on measurable business results, Ritwik Sachdeva works across strategy, SEO, PPC, social media, performance marketing, and lead generation.
            </div>
          </div>

          <div class="arch-faq-item">
            <button class="arch-faq-question faq-question" type="button" aria-expanded="false">
              <span><span class="arch-faq-coord">02</span> How much does a digital marketing consultant charge in Delhi / India?</span>
              <span class="arch-faq-toggle-icon">+</span>
            </button>
            <div class="arch-faq-answer">
              Pricing depends on the scope of work, channels involved, campaign complexity, and whether the engagement is strategy-only or ongoing execution.
            </div>
          </div>

          <div class="arch-faq-item">
            <button class="arch-faq-question faq-question" type="button" aria-expanded="false">
              <span><span class="arch-faq-coord">03</span> What is the difference between a digital marketing consultant and a digital agency?</span>
              <span class="arch-faq-toggle-icon">+</span>
            </button>
            <div class="arch-faq-answer">
              A consultant focuses on strategy, direction, and performance while an agency typically provides a broader team and execution across multiple marketing channels.
            </div>
          </div>

          <div class="arch-faq-item">
            <button class="arch-faq-question faq-question" type="button" aria-expanded="false">
              <span><span class="arch-faq-coord">04</span> How can a digital marketing consultant help grow my business in Delhi?</span>
              <span class="arch-faq-toggle-icon">+</span>
            </button>
            <div class="arch-faq-answer">
              By connecting digital strategy with execution across SEO, paid acquisition, social media, conversion optimization, and lead generation around measurable business goals.
            </div>
          </div>

          <div class="arch-faq-item">
            <button class="arch-faq-question faq-question" type="button" aria-expanded="false">
              <span><span class="arch-faq-coord">05</span> What services do digital marketing consultants in Delhi provide?</span>
              <span class="arch-faq-toggle-icon">+</span>
            </button>
            <div class="arch-faq-answer">
              Services can include SEO, PPC, performance marketing, social media marketing, growth marketing, B2B lead generation, e-commerce marketing, and digital marketing advisory.
            </div>
          </div>

          <div class="arch-faq-item">
            <button class="arch-faq-question faq-question" type="button" aria-expanded="false">
              <span><span class="arch-faq-coord">06</span> How do I choose the right digital marketing strategist for a small business?</span>
              <span class="arch-faq-toggle-icon">+</span>
            </button>
            <div class="arch-faq-answer">
              Look for someone who understands your business model, focuses on measurable outcomes, and can connect strategy with the actual execution required to achieve those outcomes.
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 8: CALL TO ACTION -->
    <section id="cta-consultant-delhi">
      <div class="hp-container">
        <div class="arch-cta-monolith">
          <div class="arch-cta-kicker">STRATEGIC PARTNERSHIP &amp; ADVISORY</div>
          <h2 class="arch-cta-title">Work With a Digital Marketing Consultant in Delhi</h2>
          <p class="arch-cta-text">If your current digital marketing feels like a lot of activity without a clear number attached to it, that's usually the first thing worth fixing. Get in touch with Ritwik Sachdeva to talk through where your digital marketing stands today.</p>
          <a href="contact.html" class="arch-cta-btn">
            <span>Book a Consultation</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="5" y1="12" x2="19" y2="12"></line>
              <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
          </a>
        </div>
      </div>
    </section>
  </main>"""

with open('index.html', 'r', encoding='utf-8') as f:
    content = f.read()

pattern = re.compile(r'<main id="main-content">.*?</main>', re.DOTALL)
if pattern.search(content):
    updated = pattern.sub(new_main_content, content)
    with open('index.html', 'w', encoding='utf-8') as f:
        f.write(updated)
    print("SUCCESS: index.html updated")
else:
    print("ERROR: main-content pattern not matched")
