import json
import os
import re

# Common Shared Navigation & Footer Data with Clean URLs
SERVICES_NAV = [
    {
        'num': '01',
        'file': 'service-ecommerce-management.html',
        'url': '/services/ecommerce-management/',
        'title': 'E-Commerce Management',
        'desc': 'Amazon, Flipkart &amp; Shopify Growth',
        'short': 'E-Commerce Management'
    },
    {
        'num': '02',
        'file': 'service-graphic-designer.html',
        'url': '/services/graphic-designer/',
        'title': 'Graphic Designer',
        'desc': 'Brand Identity, Logos &amp; Visual Assets',
        'short': 'Graphic Designer &amp; Branding'
    },
    {
        'num': '03',
        'file': 'service-performance-marketing.html',
        'url': '/services/performance-marketing/',
        'title': 'Performance Marketing Consultant in Delhi',
        'desc': 'Meta &amp; Google Paid Media Scaling',
        'short': 'Performance Marketing'
    },
    {
        'num': '04',
        'file': 'service-ppc-expert.html',
        'url': '/services/ppc-expert/',
        'title': 'PPC Expert in Delhi',
        'desc': 'Google Ads, PMax &amp; Shopping Campaigns',
        'short': 'PPC Expert (Google Ads)'
    },
    {
        'num': '05',
        'file': 'service-product-shoot.html',
        'url': '/services/product-shoot/',
        'title': 'Product Shoot Services in Delhi',
        'desc': 'E-Commerce &amp; High-Conversion Photography',
        'short': 'Product Shoot Services'
    },
    {
        'num': '06',
        'file': 'service-seo-expert.html',
        'url': '/services/seo-expert/',
        'title': 'SEO Expert in Delhi',
        'desc': 'Technical, Local &amp; Organic Search Growth',
        'short': 'SEO Expert in Delhi'
    },
    {
        'num': '07',
        'file': 'service-smo-services.html',
        'url': '/services/smo-services/',
        'title': 'SMO Services in Delhi',
        'desc': 'Social Media Optimization &amp; Reach',
        'short': 'SMO Services'
    },
    {
        'num': '08',
        'file': 'service-social-media-marketing.html',
        'url': '/services/social-media-marketing/',
        'title': 'Social Media Marketing Agency in Delhi',
        'desc': 'Organic Engagement &amp; Viral Campaigns',
        'short': 'Social Media Marketing'
    },
    {
        'num': '09',
        'file': 'service-video-editing.html',
        'url': '/services/video-editing/',
        'title': 'Video Editing Services in Delhi',
        'desc': 'Reels, Shorts, Video Ads &amp; Longform',
        'short': 'Video Editing Services'
    },
    {
        'num': '10',
        'file': 'service-website-designer.html',
        'url': '/services/website-designer/',
        'title': 'Website Designer in Delhi',
        'desc': 'Custom Web Development &amp; Shopify Stores',
        'short': 'Website Designer &amp; Dev'
    }
]

def render_dropdown(active_file):
    items = []
    for item in SERVICES_NAV:
        is_act = ' active' if item['file'] == active_file or item['url'] == active_file else ''
        items.append(f"""    <a href="{item['url']}" class="nav-dropdown-item{is_act}" role="menuitem">
      <span class="dropdown-item-num">{item['num']}</span>
      <div class="dropdown-item-body">
        <div class="dropdown-item-title">{item['title']}</div>
        <div class="dropdown-item-desc">{item['desc']}</div>
      </div>
    </a>""")
    return """<div class="nav-dropdown-menu" role="menu">
  <div class="nav-dropdown-header">
    <span class="dropdown-header-title">All Services &amp; Practices</span>
    <span class="dropdown-header-tag">10 Services</span>
  </div>
  <div class="nav-dropdown-list">
""" + "\n".join(items) + """
  </div>
  <div class="nav-dropdown-footer">
    <a href="/services/" class="dropdown-view-all">
      <span>View Comprehensive Services Catalog</span>
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </a>
  </div>
</div>"""

def render_mobile_submenu(active_file):
    links = []
    for item in SERVICES_NAV:
        is_act = ' active' if item['file'] == active_file or item['url'] == active_file else ''
        links.append(f'  <a href="{item["url"]}" class="mobile-sublink{is_act}">{item["num"]}. {item["title"]}</a>')
    return '<div class="mobile-submenu">\n' + '\n'.join(links) + '\n</div>'

def render_footer_services():
    items = []
    for item in SERVICES_NAV:
        items.append(f'            <li><a href="{item["url"]}">{item["short"]}</a></li>')
    return '\n'.join(items)

def render_header(active_file):
    dropdown_html = render_dropdown(active_file)
    
    # Active states
    home_act = ' active' if active_file in ['index.html', '/', ''] else ''
    about_act = ' active' if active_file in ['about.html', '/about/'] else ''
    services_act = ' active' if (active_file in ['services.html', '/services/'] or active_file.startswith('service-') or active_file.startswith('/services/')) else ''
    blog_act = ' active' if (active_file.startswith('blog') or active_file.startswith('/blog/')) else ''
    contact_act = ' active' if active_file in ['contact.html', '/contact/'] else ''

    return f"""  <!-- SITE HEADER / NAVBAR -->
  <header class="site-header" id="navbar">
    <!-- Top Contact Links Bar -->
    <div class="header-top-bar">
      <div class="container header-top-inner">
        <div class="header-top-left">
          <span class="top-status-indicator"></span>
          <span class="top-status-text">Available for Q1 Consulting &amp; Growth Audits</span>
        </div>
        <div class="header-top-right">
          <a href="mailto:Info@ritwiksachdeva.in" class="top-contact-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <span>Info@ritwiksachdeva.in</span>
          </a>
          <span class="top-bar-divider" aria-hidden="true">&bull;</span>
          <a href="tel:+919289626986" class="top-contact-link">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>+91 92896 26986</span>
          </a>
        </div>
      </div>
    </div>

    <div class="container nav-container">
      <a href="/" class="brand-logo" aria-label="Ritwik Sachdeva - Digital Marketing Consultant">
        <div class="brand-monogram">RS</div>
        <div class="brand-info">
          <span class="brand-name">Ritwik Sachdeva</span>
          <span class="brand-title">Marketing Consultant</span>
        </div>
      </a>

      <!-- Desktop Navigation with Dropdown -->
      <nav class="desktop-nav" aria-label="Primary Navigation">
        <ul class="nav-links">
          <li class="nav-item"><a href="/" class="nav-link{home_act}">Home</a></li>
          <li class="nav-item"><a href="/about/" class="nav-link{about_act}">About</a></li>
          <li class="nav-item nav-item-has-dropdown">
            <a href="/services/" class="nav-link dropdown-toggle{services_act}" aria-expanded="false" aria-haspopup="true">
              <span>Services</span>
              <svg class="dropdown-arrow" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" aria-hidden="true" focusable="false">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </a>
            {dropdown_html}
          </li>
          <li class="nav-item"><a href="/blog/" class="nav-link{blog_act}">Blog</a></li>
          <li class="nav-item"><a href="/contact/" class="nav-link{contact_act}">Contact</a></li>
        </ul>
        <div class="nav-actions">
          <a href="/contact/" class="btn btn-primary btn-sm btn-magnetic">
            <span>Let's Talk</span>
            <span class="btn-icon-right" aria-hidden="true">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </span>
          </a>
        </div>
      </nav>

      <!-- Mobile Hamburger Toggle -->
      <button class="mobile-nav-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>
    </div>
  </header>"""

def render_mobile_drawer(active_file):
    submenu_html = render_mobile_submenu(active_file)
    home_act = ' active' if active_file in ['index.html', '/', ''] else ''
    about_act = ' active' if active_file in ['about.html', '/about/'] else ''
    services_act = ' active' if (active_file in ['services.html', '/services/'] or active_file.startswith('service-') or active_file.startswith('/services/')) else ''
    blog_act = ' active' if (active_file.startswith('blog') or active_file.startswith('/blog/')) else ''
    contact_act = ' active' if active_file in ['contact.html', '/contact/'] else ''

    return f"""  <!-- Mobile Drawer Navigation -->
  <div class="mobile-drawer" id="mobile-drawer" aria-label="Mobile Navigation">
    <div class="mobile-links">
      <a href="/" class="mobile-link{home_act}">Home</a>
      <a href="/about/" class="mobile-link{about_act}">About</a>
      <div class="mobile-nav-item-dropdown">
        <div class="mobile-dropdown-header-row">
          <a href="/services/" class="mobile-link{services_act}">Services</a>
          <button class="mobile-submenu-btn" aria-label="Toggle Services submenu" aria-expanded="false">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true" focusable="false">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
          </button>
        </div>
        {submenu_html}
      </div>
      <a href="/blog/" class="mobile-link{blog_act}">Blog</a>
      <a href="/contact/" class="mobile-link{contact_act}">Contact</a>
    </div>
    <div class="mobile-actions">
      <a href="/contact/" class="btn btn-primary btn-block"><span>Let's Talk</span></a>
    </div>
  </div>"""

def render_footer():
    footer_services_html = render_footer_services()
    return f"""  <!-- FOOTER -->
  <footer class="site-footer" id="footer">
    <div class="container footer-container">
      <div class="footer-grid">
        <!-- Col 1: Brand Info -->
        <div class="footer-col footer-col-brand">
          <a href="/" class="footer-logo">
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
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
            </a>
            <a href="https://twitter.com" class="social-link" aria-label="Twitter / X" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
            </a>
            <a href="https://instagram.com" class="social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
          </div>
        </div>

        <!-- Col 2: Navigation -->
        <div class="footer-col">
          <h4 class="footer-col-title">Navigation</h4>
          <ul class="footer-links">
            <li><a href="/">Home</a></li>
            <li><a href="/about/">About Ritwik</a></li>
            <li><a href="/services/">Services Catalog</a></li>
            <li><a href="/blog/">Growth Articles</a></li>
            <li><a href="/contact/">Contact &amp; Bookings</a></li>
          </ul>
        </div>

        <!-- Col 3: Services (10 Services) -->
        <div class="footer-col">
          <h4 class="footer-col-title">Services</h4>
          <ul class="footer-links">
{footer_services_html}
          </ul>
        </div>

        <!-- Col 4: Direct Inquiry -->
        <div class="footer-col">
          <h4 class="footer-col-title">Direct Inquiry</h4>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <a href="mailto:Info@ritwiksachdeva.in"><span>Info@ritwiksachdeva.in</span></a>
          </p>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <a href="tel:+919289626986"><span>+91 92896 26986</span></a>
          </p>
          <p class="footer-contact-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Delhi NCR, India (Global Remote)</span>
          </p>
          <div class="footer-cta-box">
            <span class="cta-box-text">Ready to scale your business?</span>
            <a href="/contact/" class="btn btn-primary btn-sm btn-magnetic"><span>Book Consultation</span></a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <p class="copyright-text">&copy; 2026 Ritwik Sachdeva. All rights reserved. Strategic Digital Marketing &amp; Scaling Consultant.</p>
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Engagement</a>
          <a href="/sitemap.xml">Sitemap</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button with SVG Circular Progress -->
  <button id="back-to-top" class="back-to-top-progress" aria-label="Back to top" title="Scroll back to top">
    <svg class="progress-ring" width="46" height="46" viewBox="0 0 46 46" aria-hidden="true" focusable="false">
      <circle class="progress-ring-bg" cx="23" cy="23" r="20" fill="none" stroke="#CBD5E1" stroke-width="2.5" />
      <circle class="progress-ring-indicator" cx="23" cy="23" r="20" fill="none" stroke="#1D4ED8" stroke-width="2.5" stroke-dasharray="125.6" stroke-dashoffset="125.6" />
    </svg>
    <span class="back-to-top-arrow" aria-hidden="true">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
        <polyline points="18 15 12 9 6 15"></polyline>
      </svg>
    </span>
  </button>

  <!-- Floating WhatsApp and Call Action Buttons -->
  <div class="floating-actions-container" id="rs-floating-actions" aria-label="Direct contact options">
    <a href="https://wa.me/919289626986" class="floating-btn floating-btn-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp" title="Chat on WhatsApp with Ritwik Sachdeva">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.12.553 4.11 1.523 5.836l-1.616 5.908 6.06-1.59c1.664.908 3.568 1.42 5.597 1.42 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/>
      </svg>
    </a>
    <a href="tel:+919289626986" class="floating-btn floating-btn-call" aria-label="Direct Phone Call" title="Call Ritwik Sachdeva directly">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
      </svg>
    </a>
  </div>"""

if __name__ == '__main__':
    print("Clean URL shared layout elements compiled successfully.")
