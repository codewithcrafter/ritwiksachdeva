import os
import re

# Standard top bar HTML
HEADER_TOP_BAR = '''    <!-- Top Contact Links Bar -->
    <div class="header-top-bar">
      <div class="container header-top-inner">
        <div class="header-top-left">
          <span class="top-status-indicator"></span>
          <span class="top-status-text">Available for Q1 Consulting &amp; Growth Audits</span>
        </div>
        <div class="header-top-right">
          <a href="mailto:consult@ritwiksachdeva.com" class="top-contact-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <span>consult@ritwiksachdeva.com</span>
          </a>
          <span class="top-bar-divider" aria-hidden="true">&bull;</span>
          <a href="tel:+919876543210" class="top-contact-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>+91 98765 43210</span>
          </a>
        </div>
      </div>
    </div>
'''

DROPDOWN_MENU = '''            <div class="nav-dropdown-menu" role="menu">
  <div class="nav-dropdown-header">
    <span class="dropdown-header-title">All Services &amp; Practices</span>
    <span class="dropdown-header-tag">10 Services</span>
  </div>
  <div class="nav-dropdown-list">
    <a href="service-ecommerce-management.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">01</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">E-Commerce Management</div>
        <div class="dropdown-item-desc">Amazon, Flipkart &amp; Shopify Growth</div>
      </div>
    </a>
    <a href="service-graphic-designer.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">02</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Graphic Designer</div>
        <div class="dropdown-item-desc">Brand Identity, Logos &amp; Visual Assets</div>
      </div>
    </a>
    <a href="service-performance-marketing.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">03</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Performance Marketing Consultant in Delhi</div>
        <div class="dropdown-item-desc">Meta &amp; Google Paid Media Scaling</div>
      </div>
    </a>
    <a href="service-ppc-expert.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">04</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">PPC Expert in Delhi</div>
        <div class="dropdown-item-desc">Google Ads, PMax &amp; Shopping Campaigns</div>
      </div>
    </a>
    <a href="service-product-shoot.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">05</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Product Shoot Services in Delhi</div>
        <div class="dropdown-item-desc">E-Commerce &amp; High-Conversion Photography</div>
      </div>
    </a>
    <a href="service-seo-expert.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">06</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">SEO Expert in Delhi</div>
        <div class="dropdown-item-desc">Technical, Local &amp; Organic Search Growth</div>
      </div>
    </a>
    <a href="service-smo-services.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">07</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">SMO Services in Delhi</div>
        <div class="dropdown-item-desc">Social Media Optimization &amp; Reach</div>
      </div>
    </a>
    <a href="service-social-media-marketing.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">08</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Social Media Marketing Agency in Delhi</div>
        <div class="dropdown-item-desc">Organic Engagement &amp; Viral Campaigns</div>
      </div>
    </a>
    <a href="service-video-editing.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">09</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Video Editing Services in Delhi</div>
        <div class="dropdown-item-desc">Reels, Shorts, Video Ads &amp; Longform</div>
      </div>
    </a>
    <a href="service-website-designer.html" class="nav-dropdown-item" role="menuitem">
      <span class="dropdown-item-num">10</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">Website Designer in Delhi</div>
        <div class="dropdown-item-desc">Custom Web Development &amp; Shopify Stores</div>
      </div>
    </a>
  </div>
  <div class="nav-dropdown-footer">
    <a href="services.html" class="dropdown-view-all">
      <span>View Comprehensive Services Catalog</span>
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </a>
  </div>
</div>'''

MOBILE_SUBMENU = '''        <div class="mobile-submenu">
          <a href="service-ecommerce-management.html" class="mobile-sublink">01. E-Commerce Management</a>
          <a href="service-graphic-designer.html" class="mobile-sublink">02. Graphic Designer</a>
          <a href="service-performance-marketing.html" class="mobile-sublink">03. Performance Marketing Consultant in Delhi</a>
          <a href="service-ppc-expert.html" class="mobile-sublink">04. PPC Expert in Delhi</a>
          <a href="service-product-shoot.html" class="mobile-sublink">05. Product Shoot Services in Delhi</a>
          <a href="service-seo-expert.html" class="mobile-sublink">06. SEO Expert in Delhi</a>
          <a href="service-smo-services.html" class="mobile-sublink">07. SMO Services in Delhi</a>
          <a href="service-social-media-marketing.html" class="mobile-sublink">08. Social Media Marketing Agency in Delhi</a>
          <a href="service-video-editing.html" class="mobile-sublink">09. Video Editing Services in Delhi</a>
          <a href="service-website-designer.html" class="mobile-sublink">10. Website Designer in Delhi</a>
        </div>'''

SHARED_FOOTER_AND_EXTRAS = '''  <!-- FOOTER -->
  <footer class="site-footer" id="footer">
    <div class="container footer-container">
      <div class="footer-grid">
        <!-- Col 1: Brand Info -->
        <div class="footer-col footer-col-brand">
          <a href="index.html" class="footer-logo">
            <div class="brand-monogram">RS</div>
            <div class="brand-info">
              <span class="brand-name">Ritwik Sachdeva</span>
              <span class="brand-title">Marketing Consultant</span>
            </div>
          </a>
          <p class="footer-tagline">
            Strategic digital marketing consultant helping businesses scale through data-driven campaigns, technical search moats, and high-converting creative systems.
          </p>
          <div class="footer-social-links">
            <a href="https://linkedin.com" class="social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
            </a>
            <a href="https://twitter.com" class="social-link" aria-label="Twitter / X" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
            </a>
            <a href="https://instagram.com" class="social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
          </div>
        </div>

        <!-- Col 2: Navigation -->
        <div class="footer-col">
          <h4 class="footer-col-title">Navigation</h4>
          <ul class="footer-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About Ritwik</a></li>
            <li><a href="services.html">Services Catalog</a></li>
            <li><a href="blog.html">Growth Articles</a></li>
            <li><a href="contact.html">Contact &amp; Bookings</a></li>
          </ul>
        </div>

        <!-- Col 3: Services (10 Services) -->
        <div class="footer-col">
          <h4 class="footer-col-title">Services</h4>
          <ul class="footer-links">
            <li><a href="service-ecommerce-management.html">E-Commerce Management</a></li>
            <li><a href="service-graphic-designer.html">Graphic Designer &amp; Branding</a></li>
            <li><a href="service-performance-marketing.html">Performance Marketing</a></li>
            <li><a href="service-ppc-expert.html">PPC Expert (Google Ads)</a></li>
            <li><a href="service-product-shoot.html">Product Shoot Services</a></li>
            <li><a href="service-seo-expert.html">SEO Expert in Delhi</a></li>
            <li><a href="service-smo-services.html">SMO Services</a></li>
            <li><a href="service-social-media-marketing.html">Social Media Marketing</a></li>
            <li><a href="service-video-editing.html">Video Editing Services</a></li>
            <li><a href="service-website-designer.html">Website Designer &amp; Dev</a></li>
          </ul>
        </div>

        <!-- Col 4: Direct Inquiry -->
        <div class="footer-col">
          <h4 class="footer-col-title">Direct Inquiry</h4>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <a href="mailto:consult@ritwiksachdeva.com">consult@ritwiksachdeva.com</a>
          </p>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <a href="tel:+919876543210">+91 98765 43210</a>
          </p>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Delhi NCR, India (Global Remote)</span>
          </p>
          <div class="footer-cta-box">
            <span class="cta-box-text">Ready to scale your business?</span>
            <a href="contact.html" class="btn btn-primary btn-sm btn-magnetic">Book Consultation</a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p class="copyright-text">&copy; 2026 Ritwik Sachdeva. All rights reserved. Strategic Digital Marketing &amp; Scaling Consultant.</p>
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Engagement</a>
          <a href="sitemap.xml">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button with SVG Circular Progress -->
  <button id="back-to-top" class="back-to-top-progress" aria-label="Back to top" title="Scroll back to top">
    <svg class="progress-ring" width="46" height="46" viewBox="0 0 46 46">
      <circle class="progress-ring-bg" cx="23" cy="23" r="20" fill="none" stroke="#CBD5E1" stroke-width="2.5" />
      <circle class="progress-ring-indicator" cx="23" cy="23" r="20" fill="none" stroke="#1D4ED8" stroke-width="2.5" stroke-dasharray="125.6" stroke-dashoffset="125.6" />
    </svg>
    <span class="back-to-top-arrow">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="18 15 12 9 6 15"></polyline>
      </svg>
    </span>
  </button>

  <!-- Floating WhatsApp and Call Action Buttons -->
  <div class="floating-actions-container" aria-label="Instant Contact Options">
    <a href="https://wa.me/919876543210" class="floating-btn floating-btn-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" title="Chat on WhatsApp with Ritwik Sachdeva">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.12.553 4.11 1.523 5.836l-1.616 5.908 6.06-1.59c1.664.908 3.568 1.42 5.597 1.42 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/>
      </svg>
      <span class="floating-tooltip">WhatsApp</span>
    </a>
    <a href="tel:+919876543210" class="floating-btn floating-btn-call" aria-label="Direct Phone Call" title="Call Ritwik Sachdeva directly">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
      <span class="floating-tooltip">Direct Call</span>
    </a>
  </div>

  <!-- Timed Consultation Popup Modal -->
  <div class="consultation-popup-overlay" id="consultation-popup" role="dialog" aria-modal="true" aria-labelledby="popup-title" aria-hidden="true">
    <div class="consultation-popup-dialog">
      <button class="popup-close-btn" id="popup-close-btn" aria-label="Close consultation modal">&times;</button>
      <div class="popup-header">
        <span class="popup-badge">Free Growth Audit</span>
        <h3 class="popup-title" id="popup-title">Book a 1-on-1 Growth Consultation</h3>
        <p class="popup-subtitle">Discuss your marketing, SEO, paid media, or design requirements directly with Ritwik Sachdeva.</p>
      </div>
      <form class="popup-form" id="consultation-popup-form" action="api/contact.php" method="POST" novalidate>
        <div class="form-group">
          <label for="popup-name" class="form-label">Full Name <span class="required-mark">*</span></label>
          <input type="text" id="popup-name" name="name" class="form-input" placeholder="e.g. Rahul Sharma" required autocomplete="name">
          <div class="form-error-msg" id="popup-name-error">Please enter your full name.</div>
        </div>
        <div class="form-group">
          <label for="popup-email" class="form-label">Email Address <span class="required-mark">*</span></label>
          <input type="email" id="popup-email" name="email" class="form-input" placeholder="e.g. rahul@company.com" required autocomplete="email">
          <div class="form-error-msg" id="popup-email-error">Please enter a valid business email address.</div>
        </div>
        <div class="form-group">
          <label for="popup-number" class="form-label">Phone Number <span class="required-mark">*</span></label>
          <input type="tel" id="popup-number" name="phone" class="form-input" placeholder="e.g. +91 98765 43210" required autocomplete="tel">
          <div class="form-error-msg" id="popup-phone-error">Please enter a valid phone number.</div>
        </div>
        <div class="form-group">
          <label for="popup-message" class="form-label">Message <span class="optional-mark">(optional)</span></label>
          <textarea id="popup-message" name="message" class="form-textarea" rows="3" placeholder="Give us a bit about your idea..."></textarea>
        </div>
        <div class="popup-form-status" id="popup-form-status" role="status" aria-live="polite"></div>
        <button type="submit" class="btn btn-primary btn-block popup-submit-btn" id="popup-submit-btn">
          <span>Submit Request</span>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
      </form>
    </div>
  </div>
'''

TARGET_FILES = [
    'blog-ai-in-business.html',
    'blog-business-growth-strategy.html',
    'blog-digital-transformation-strategies.html',
    'blog-leadership-skills.html',
    'blog-marketing-strategies.html',
    'blog-detail.php'
]

for filename in TARGET_FILES:
    if not os.path.exists(filename):
        print(f"Skipping {filename}: not found")
        continue

    with open(filename, 'r', encoding='utf-8') as f:
        html = f.read()

    # 1. Add top bar if missing
    if 'header-top-bar' not in html:
        html = re.sub(
            r'(<header\s+class="site-header"\s+id="navbar">)',
            r'\1\n' + HEADER_TOP_BAR,
            html,
            count=1
        )

    # 2. Update navigation dropdown
    html = re.sub(
        r'<div\s+class="nav-dropdown-menu"\s+role="menu">.*?</div>\s*</div>\s*</li>',
        DROPDOWN_MENU + '\n          </li>',
        html,
        flags=re.DOTALL
    )

    # 3. Update mobile submenu
    html = re.sub(
        r'<div\s+class="mobile-submenu">.*?</div>',
        MOBILE_SUBMENU,
        html,
        flags=re.DOTALL
    )

    # 4. Standardize article header container: remove conflicting inline max-width: 980px
    html = re.sub(
        r'<header\s+class="article-header">\s*<div\s+class="container"\s+style="max-width:\s*980px;">',
        '<header class="article-header">\n        <div class="container article-container">',
        html
    )

    # 5. Standardize article body container: remove conflicting inline max-width: 1140px
    html = re.sub(
        r'<div\s+class="container"\s+style="max-width:\s*1140px;\s*padding-bottom:\s*80px;">',
        '<div class="container article-container" style="padding-bottom: 80px;">',
        html
    )

    # 6. Replace old unstyled footer with standard footer, back to top, floating actions, popup modal
    # Find from <!-- FOOTER --> or <footer class="site-footer"> up to <!-- Scripts -->
    footer_pattern = re.compile(
        r'(<!--\s*FOOTER\s*-->\s*)?<footer\s+class="site-footer".*?</footer>\s*(?=<!--\s*Scripts\s*-->|<script\b)',
        re.DOTALL
    )
    if footer_pattern.search(html):
        html = footer_pattern.sub(SHARED_FOOTER_AND_EXTRAS + '\n', html, count=1)
    else:
        print(f"Warning: footer pattern not matched in {filename}")

    # Write back
    with open(filename, 'w', encoding='utf-8') as f:
        f.write(html)
    print(f"Successfully synchronized {filename}")
