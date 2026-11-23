import os
import sys

# Ensure root is in path
sys.path.insert(0, os.path.abspath('.'))

from scratch.shared_layout import render_header, render_mobile_drawer, render_footer
from scratch.page_helpers import build_faq_html, build_metrics_html, build_related_html

# Import all service modules
from scratch.data_ecommerce import DATA as DATA_ECOM
from scratch.data_graphic import DATA as DATA_GRAPHIC
from scratch.data_performance import DATA as DATA_PERF
from scratch.data_ppc import DATA as DATA_PPC
from scratch.data_product import DATA as DATA_PROD
from scratch.data_seo import DATA as DATA_SEO
from scratch.data_smo import DATA as DATA_SMO
from scratch.data_smm import DATA as DATA_SMM
from scratch.data_video import DATA as DATA_VIDEO
from scratch.data_website import DATA as DATA_WEB

ALL_SERVICES = [
    DATA_ECOM,
    DATA_GRAPHIC,
    DATA_PERF,
    DATA_PPC,
    DATA_PROD,
    DATA_SEO,
    DATA_SMO,
    DATA_SMM,
    DATA_VIDEO,
    DATA_WEB
]

def render_section(sec):
    stype = sec['type']
    if stype == 'insight':
        return f"""    <section class="service-content-section">
      <div class="service-page-main">
        <div class="insight-card">
          <span class="section-eyebrow">{sec['eyebrow']}</span>
          <h2 class="section-title">{sec['title']}</h2>
          <p class="section-subtitle">{sec['lead']}</p>
        </div>
      </div>
    </section>"""

    elif stype == 'deliverables':
        cards = []
        for it in sec['items']:
            cards.append(f"""          <div class="deliverable-card">
            <div class="deliverable-header">
              <span class="deliverable-num">{it['num']}</span>
              <span class="deliverable-tag">{it['tag']}</span>
            </div>
            <h3 class="deliverable-title">{it['title']}</h3>
            <p class="deliverable-text">{it['desc']}</p>
          </div>""")
        cards_html = '\n'.join(cards)
        note_html = f"""        <div class="insight-card" style="margin-top: 28px; border-left-color: #D4F542;">
          <p style="margin: 0; font-weight: 600; color: #0F172A;">{sec['note']}</p>
        </div>""" if 'note' in sec else ''

        grid_cls = 'deliverables-grid-2col' if len(sec['items']) <= 4 else 'deliverables-grid-3col'

        return f"""    <section class="service-content-section" id="deliverables">
      <div class="service-page-main">
        <div class="section-header-compact">
          <span class="section-eyebrow">{sec['eyebrow']}</span>
          <h2 class="section-title">{sec['title']}</h2>
          <p class="section-subtitle">{sec.get('subtitle', '')}</p>
        </div>
        <div class="{grid_cls}">
{cards_html}
        </div>
{note_html}
      </div>
    </section>"""

    elif stype == 'comparison':
        note_html = f"""        <div class="insight-card" style="margin-top: 28px; border-left-color: #1D4ED8;">
          <p style="margin: 0; font-weight: 600; color: #0F172A;">{sec['note']}</p>
        </div>""" if 'note' in sec else ''
        return f"""    <section class="service-content-section">
      <div class="service-page-main">
        <div class="section-header-compact">
          <span class="section-eyebrow">{sec['eyebrow']}</span>
          <h2 class="section-title">{sec['title']}</h2>
        </div>
        <div class="comparison-grid-2col">
          <div class="comparison-box">
            <span class="comparison-tag standard">{sec['box1']['tag']}</span>
            <h3 class="comparison-title">{sec['box1']['title']}</h3>
            <p class="comparison-desc">{sec['box1']['desc']}</p>
          </div>
          <div class="comparison-box highlight">
            <span class="comparison-tag consultant">{sec['box2']['tag']}</span>
            <h3 class="comparison-title">{sec['box2']['title']}</h3>
            <p class="comparison-desc">{sec['box2']['desc']}</p>
          </div>
        </div>
{note_html}
      </div>
    </section>"""

    elif stype == 'audience':
        cards = []
        for it in sec['items']:
            cards.append(f"""          <div class="audience-card">
            <div class="audience-icon-wrap">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div>
              <h3 class="audience-body-title">{it['title']}</h3>
              <p class="audience-body-text">{it['desc']}</p>
            </div>
          </div>""")
        cards_html = '\n'.join(cards)
        return f"""    <section class="service-content-section">
      <div class="service-page-main">
        <div class="section-header-compact">
          <span class="section-eyebrow">{sec['eyebrow']}</span>
          <h2 class="section-title">{sec['title']}</h2>
          <p class="section-subtitle">{sec.get('subtitle', '')}</p>
        </div>
        <div class="audience-grid">
{cards_html}
        </div>
      </div>
    </section>"""
    return ''

def compile_service_page(data):
    filename = data['filename']
    header_html = render_header(filename)
    drawer_html = render_mobile_drawer(filename)
    footer_html = render_footer()
    metrics_html = build_metrics_html(data['metrics'])
    faqs_html = build_faq_html(data['faqs'])
    related_html = build_related_html(data['related'])

    sections_rendered = []
    for sec in data['sections']:
        sections_rendered.append(render_section(sec))
    body_sections = '\n\n'.join(sections_rendered)

    html = f"""<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>{data['meta_title']}</title>
  <meta name="title" content="{data['meta_title']}">
  <meta name="description" content="{data['meta_desc']}">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://ritwiksachdeva.in/{filename}">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://ritwiksachdeva.in/{filename}">
  <meta property="og:title" content="{data['meta_title']}">
  <meta property="og:description" content="{data['meta_desc']}">
  <meta property="og:image" content="assets/images/blog-marketing-strategy.jpg">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/services.css">
  <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="css/responsive.css">

  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%231D4ED8'/><text x='16' y='22' fill='%23D4F542' font-family='sans-serif' font-weight='bold' font-size='16' text-anchor='middle'>RS</text></svg>">

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {{
    "@context": "https://schema.org",
    "@graph": [
      {{
        "@type": "Service",
        "name": "{data['short_title']}",
        "serviceType": "{data['eyebrow']}",
        "provider": {{
          "@type": "Person",
          "name": "Ritwik Sachdeva",
          "jobTitle": "Strategic Digital Marketing Consultant",
          "url": "https://ritwiksachdeva.in/about.html"
        }},
        "description": "{data['meta_desc']}",
        "areaServed": {{
          "@type": "Place",
          "name": "Delhi NCR, India & Global"
        }}
      }},
      {{
        "@type": "BreadcrumbList",
        "itemListElement": [
          {{
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://ritwiksachdeva.in/index.html"
          }},
          {{
            "@type": "ListItem",
            "position": 2,
            "name": "Services",
            "item": "https://ritwiksachdeva.in/services.html"
          }},
          {{
            "@type": "ListItem",
            "position": 3,
            "name": "{data['short_title']}",
            "item": "https://ritwiksachdeva.in/{filename}"
          }}
        ]
      }}
    ]
  }}
  </script>
</head>

<body>

  <!-- Site Preloader -->
  <div class="site-preloader" id="preloader" aria-hidden="true">
    <div class="preloader-inner">
      <div class="preloader-monogram">RS</div>
      <div class="preloader-bar-wrap">
        <div class="preloader-bar" id="preloader-bar"></div>
      </div>
      <div class="preloader-percent" id="preloader-percent">0%</div>
    </div>
  </div>

  <!-- Reading Progress Bar -->
  <div id="scroll-progress" role="progressbar" aria-label="Page reading progress"></div>

  <!-- Ambient Background Layer -->
  <div class="bg-ambient-layer" aria-hidden="true">
    <div class="ambient-glow-circle ambient-glow-1"></div>
    <div class="ambient-glow-circle ambient-glow-2"></div>
    <div class="grid-pattern-overlay"></div>
  </div>

{header_html}

{drawer_html}

  <main id="main-content">

    <!-- HERO SECTION -->
    <section class="service-detail-hero">
      <div class="service-page-main">
        <!-- Breadcrumbs -->
        <nav class="service-breadcrumbs" aria-label="Breadcrumb">
          <a href="index.html">Home</a>
          <span class="sep">/</span>
          <a href="services.html">Services</a>
          <span class="sep">/</span>
          <span class="current">{data['short_title']}</span>
        </nav>

        <div class="service-detail-header-wrap">
          <div class="service-eyebrow-row">
            <span class="badge-accent">{data['eyebrow']}</span>
            <span class="badge-outline">Practice #{data['num']}</span>
          </div>
          <h1 class="service-detail-title">{data['h1']}</h1>
          <p class="service-detail-lead">{data['lead']}</p>

          <div class="service-hero-actions">
            <button type="button" class="btn btn-primary btn-lg btn-magnetic" data-open-popup="consultation">
              Book a Consultation
              <span class="btn-icon-right">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                  <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
              </span>
            </button>
            <a href="https://wa.me/919876543210" class="btn btn-secondary btn-lg" target="_blank" rel="noopener noreferrer">
              WhatsApp Direct
              <span class="btn-icon-right">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
              </span>
            </a>
          </div>

          <!-- Key Metrics / Stats Highlight -->
          <div class="service-key-stats-row">
{metrics_html}
          </div>
        </div>
      </div>
    </section>

{body_sections}

    <!-- FAQS SECTION -->
    <section class="service-content-section" id="faqs">
      <div class="service-page-main service-faq-container">
        <div class="section-header-compact text-center">
          <span class="section-eyebrow">Frequently Answered Questions</span>
          <h2 class="section-title">Common Questions &amp; Direct Answers</h2>
          <p class="section-subtitle">Everything you need to know about partnering with Ritwik Sachdeva for {data['short_title']}.</p>
        </div>

        <div class="faq-accordion-list">
{faqs_html}
        </div>
      </div>
    </section>

    <!-- BOTTOM CTA BANNER -->
    <div class="service-page-main">
      <div class="service-cta-banner">
        <div class="service-cta-text">
          <span class="badge-accent" style="margin-bottom: 14px; display: inline-block;">Proven Growth Execution</span>
          <h2 class="service-cta-title">{data['cta']['title']}</h2>
          <p class="service-cta-desc">{data['cta']['desc']}</p>
        </div>
        <div class="service-cta-actions">
          <button type="button" class="service-cta-btn btn-magnetic" data-open-popup="consultation">
            <span>{data['cta']['btn']}</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
          </button>
        </div>
      </div>
    </div>

    <!-- RELATED SERVICES STRIP -->
    <section class="service-content-section" style="background: #F8FAFC; border-bottom: 2px solid #0F172A;">
      <div class="service-page-main">
        <div class="section-header-compact">
          <span class="section-eyebrow">Complementary Practices</span>
          <h2 class="section-title">Explore Other Growth Services</h2>
          <p class="section-subtitle">Discover complementary capabilities across the Ritwik Sachdeva consulting ecosystem.</p>
        </div>

        <div class="deliverables-grid-3col">
{related_html}
        </div>
      </div>
    </section>

  </main>

{footer_html}

  <!-- Scripts -->
  <script src="js/animations.js" defer></script>
  <script src="js/interactions.js" defer></script>
  <script src="js/main.js" defer></script>
</body>

</html>"""
    with open(filename, 'w', encoding='utf-8') as f:
        f.write(html)
    print(f"Generated {filename} successfully ({len(html)} bytes).")

if __name__ == '__main__':
    for service_data in ALL_SERVICES:
        compile_service_page(service_data)
    print("\nAll 10 service pages compiled successfully!")
