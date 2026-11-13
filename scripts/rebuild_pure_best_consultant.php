<?php
$rawBody = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$indexHtml = file_get_contents(__DIR__ . '/../index.html');
$originalPage = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');

// 1. Extract Head and Navigation from originalPage
preg_match('/^(.*?)<main\b[^>]*>/is', $originalPage, $topPartMatch);
$topPart = $topPartMatch[1] ?? '';

// 2. Extract clean site-footer from index.html
preg_match('/<footer class="site-footer".*?<\/footer>/is', $indexHtml, $footerMatch);
$siteFooter = $footerMatch[0] ?? '';

// Helper to extract clean section between start and end string
function extractSection($startPattern, $endPattern, $html) {
    if (preg_match($startPattern, $html, $mStart, PREG_OFFSET_CAPTURE)) {
        $startPos = $mStart[0][1];
        if (preg_match($endPattern, $html, $mEnd, PREG_OFFSET_CAPTURE, $startPos)) {
            $endPos = $mEnd[0][1] + strlen($mEnd[0][0]);
            return substr($html, $startPos, $endPos - $startPos);
        }
    }
    return '';
}

// -----------------------------------------------------------------------------
// SECTION 1: HERO SECTION
// -----------------------------------------------------------------------------
$heroStart = strpos($rawBody, 'WHO WE ARE');
$heroStart = strrpos(substr($rawBody, 0, $heroStart), '<div class="marketing-section"');
$heroEnd = strpos($rawBody, '</section>', $heroStart) + 10;
$heroHtml = substr($rawBody, $heroStart, $heroEnd - $heroStart);

// Clean up Hero Image
$heroHtml = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/Untitled-design-3.jpg', 'assets/images/stage-photo.jpg', $heroHtml);
$heroHtml = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', '', $heroHtml);
$heroHtml = preg_replace('/src="data:image\/[^"]*"/i', '', $heroHtml);
$heroHtml = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $heroHtml);
$heroHtml = preg_replace('/\s*data-lazyloaded="[^"]*"/i', '', $heroHtml);
$heroHtml = '<section class="marketing-hero-wrap">' . "\n" . $heroHtml;

// -----------------------------------------------------------------------------
// SECTION 2: PROVEN DIGITAL IMPACT
// -----------------------------------------------------------------------------
$impactHtml = <<<'HTML'
<section class="impact-section">
  <div class="impact-container">
    <h2 class="impact-title">Proven Digital Impact</h2>
    <p class="impact-subtitle">Real numbers that showcase performance, consistency, and measurable growth.</p>
    <div class="impact-grid">
      <div class="impact-card">
        <div class="impact-number">
          <span class="counter" data-target="100">0</span><span class="unit">M+</span>
        </div>
        <p class="impact-text">Social Media Reach Generated</p>
      </div>
      <div class="impact-card">
        <div class="impact-number">
          <span class="counter" data-target="100">0</span><span class="unit">+</span>
        </div>
        <p class="impact-text">Successful Projects Delivered</p>
      </div>
      <div class="impact-card">
        <div class="impact-number">
          <span class="counter" data-target="500">0</span><span class="unit">+</span>
        </div>
        <p class="impact-text">Marketing Campaigns Executed</p>
      </div>
    </div>
  </div>
</section>
HTML;

// -----------------------------------------------------------------------------
// SECTION 3: OUR DIGITAL MARKETING SERVICES
// -----------------------------------------------------------------------------
$sec3 = extractSection('/<section class="services-section">/i', '/<\/section>/i', $rawBody);
$serviceLinks = [
    'Web Design &amp; Development' => 'service-website-designer.html',
    'Social Media Marketing' => 'service-social-media-marketing.html',
    'Content Writing' => 'contact.html',
    'Video Production &amp; Editing' => 'service-video-editing.html',
    'Performance Marketing' => 'service-performance-marketing.html',
    'SEO Services' => 'service-seo-expert.html'
];
foreach ($serviceLinks as $name => $url) {
    $sec3 = str_replace("<h3>$name</h3>", "<h3><a href=\"$url\" style=\"color:inherit;text-decoration:none;\">$name &rarr;</a></h3>", $sec3);
}

// -----------------------------------------------------------------------------
// SECTION 4: TRUSTED BY LEADING BRANDS
// -----------------------------------------------------------------------------
$sec4 = extractSection('/<section class="client-slider-section">/i', '/<\/section>/i', $rawBody);
$sec4 = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', '', $sec4);
$sec4 = preg_replace('/src="data:image\/[^"]*"/i', '', $sec4);
$sec4 = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $sec4);
$sec4 = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/logo-1.png', 'assets/images/brand-logo-1.png', $sec4);
$sec4 = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/download-1.png', 'assets/images/brand-logo-2.png', $sec4);
$sec4 = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/delhi-6-final-png.png', 'assets/images/brand-logo-3.png', $sec4);
$sec4 = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/printex-90x90-1.webp', 'assets/images/brand-logo-4.webp', $sec4);
$sec4 = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/download.jpg', 'assets/images/brand-logo-5.jpg', $sec4);

// -----------------------------------------------------------------------------
// SECTION 5: 🚀 OUR RESULTS
// -----------------------------------------------------------------------------
$sec5 = extractSection('/<section class="slider-section">/i', '/<\/section>/i', $rawBody);
$sec5 = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', '', $sec5);
$sec5 = preg_replace('/src="data:image\/[^"]*"/i', '', $sec5);
$sec5 = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $sec5);
$sec5 = preg_replace('/\s*data-placeholder-resp="[^"]*"/i', '', $sec5);
$sec5 = preg_replace('/\s*data-lazyloaded="[^"]*"/i', '', $sec5);
for ($i = 1; $i <= 7; $i++) {
    $sec5 = str_replace("https://ritwiksachdeva.in/wp-content/uploads/2026/03/$i.jpg", "assets/images/result-$i.jpg", $sec5);
}

// -----------------------------------------------------------------------------
// SECTION 6: DIGITAL MARKETING RESULTS THAT SPEAK FOR THEMSELVES (IMAGE 1)
// -----------------------------------------------------------------------------
$sec6 = <<<'HTML'
<section class="results-stats-section">
  <div class="results-stats-container">
    <h2 class="results-stats-title">Digital Marketing Results That Speak for Themselves</h2>
    <p class="results-stats-subtitle">
      I help brands grow through data-driven digital marketing strategies focused on visibility, leads, and revenue. Every campaign is optimized for performance, scalability, and long-term success—because numbers matter more than promises.
    </p>
    <div class="results-stats-grid">
      <div class="results-stat-box stat-border-right stat-border-bottom">
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="6">0</span>
        </div>
        <div class="stat-label">Years of experience</div>
      </div>
      <div class="results-stat-box stat-border-bottom">
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="120">0</span><span class="stat-suffix">+</span>
        </div>
        <div class="stat-label">Brands Scaled</div>
      </div>
      <div class="results-stat-box stat-border-right">
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="100">0</span><span class="stat-suffix">K</span>
        </div>
        <div class="stat-label">Qualified Leads Generated</div>
      </div>
      <div class="results-stat-box">
        <div class="stat-number-wrapper">
          <span class="stat-number counter" data-target="98">0</span><span class="stat-suffix">%</span>
        </div>
        <div class="stat-label">Client Satisfaction Rate</div>
      </div>
    </div>
  </div>
</section>
HTML;

// -----------------------------------------------------------------------------
// SECTION 7: LET'S BUILD A WINNING DIGITAL GROWTH STRATEGY (IMAGE 2: FULL WIDTH)
// -----------------------------------------------------------------------------
$sec7 = <<<'HTML'
<section id="growth-cta" class="growth-cta">
  <div class="growth-cta-inner">
    <h2 class="growth-cta-title">Let's Build a Winning Digital Growth Strategy</h2>
    <p class="growth-cta-text">
      Get a personalized digital marketing roadmap designed to increase traffic, leads, and revenue.
    </p>
    <a href="contact.html" class="growth-cta-btn">
      Start Your Growth Plan
    </a>
  </div>
</section>
HTML;

// -----------------------------------------------------------------------------
// SECTION 8: ABOUT RITWIK SACHDEVA
// -----------------------------------------------------------------------------
$sec8 = extractSection('/<section class="about-section">/i', '/<\/section>/i', $rawBody);

// -----------------------------------------------------------------------------
// SECTION 9: SCHEDULE YOUR FREE STRATEGY CALL TODAY
// -----------------------------------------------------------------------------
$sec9 = <<<'HTML'
<section class="strategy-call-section">
  <div class="strategy-call-container">
    <div class="strategy-call-grid">
      <!-- Left Column -->
      <div class="strategy-call-info">
        <h2 class="strategy-call-title">Schedule Your Free Strategy Call Today</h2>
        <p class="strategy-call-desc">
          Book a 1-on-1 strategy call with Ritwik Sachdeva to identify growth opportunities, fix leaks in your marketing funnel, and create a clear action plan focused on ROI.
        </p>
      </div>

      <!-- Right Column: Dark Rounded Box -->
      <div class="strategy-call-card">
        <form class="strategy-booking-form" id="strategy-booking-form" action="contact.html" method="POST">
          <div class="strategy-form-group">
            <label class="strategy-form-label" for="strat-name">Name <span class="required-star">*</span></label>
            <input type="text" id="strat-name" name="name" class="strategy-form-input" required placeholder="Your name">
          </div>
          <div class="strategy-form-group">
            <label class="strategy-form-label" for="strat-email">Email <span class="required-star">*</span></label>
            <input type="email" id="strat-email" name="email" class="strategy-form-input" required placeholder="Your email address">
          </div>
          <div class="strategy-form-group">
            <label class="strategy-form-label" for="strat-message">Message</label>
            <textarea id="strat-message" name="message" class="strategy-form-textarea" placeholder="Tell us about your business goals..."></textarea>
          </div>
          <div class="strategy-form-actions">
            <button type="submit" class="strategy-submit-btn">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
HTML;

// -----------------------------------------------------------------------------
// MAIN CONTENT STACK (9 CLEAN, INDEPENDENT, FULL-WIDTH SECTIONS)
// -----------------------------------------------------------------------------
$mainSections = [
    $heroHtml,
    $impactHtml,
    $sec3,
    $sec4,
    $sec5,
    $sec6,
    $sec7,
    $sec8,
    $sec9
];

$mainContent = implode("\n\n", $mainSections);

// JavaScript for counters & booking form
$scripts = <<<'JS'
  <!-- Counter & Interactive Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // 1. Smooth Count-Up Animation for all counters
      const counters = document.querySelectorAll('.counter');
      if (counters.length) {
        const observer = new IntersectionObserver((entries, obs) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const el = entry.target;
              const target = parseInt(el.getAttribute('data-target'), 10);
              if (!isNaN(target)) {
                let start = 0;
                const duration = 1600;
                const startTime = performance.now();
                const update = (now) => {
                  const elapsed = now - startTime;
                  const progress = Math.min(elapsed / duration, 1);
                  // easeOutCubic
                  const ease = 1 - Math.pow(1 - progress, 3);
                  const val = Math.floor(ease * target);
                  el.textContent = val;
                  if (progress < 1) {
                    requestAnimationFrame(update);
                  } else {
                    el.textContent = target;
                  }
                };
                requestAnimationFrame(update);
              }
              obs.unobserve(el);
            }
          });
        }, { threshold: 0.25 });

        counters.forEach(c => observer.observe(c));
      }

      // 2. Strategy Booking Form Submission Handler
      const bookingForm = document.getElementById('strategy-booking-form');
      if (bookingForm) {
        bookingForm.addEventListener('submit', (e) => {
          e.preventDefault();
          const btn = bookingForm.querySelector('.strategy-submit-btn');
          const origText = btn.textContent;
          btn.textContent = 'Sending...';
          btn.disabled = true;
          setTimeout(() => {
            alert('Thank you! Your strategy call request has been sent to Ritwik Sachdeva. We will reach out within 24 hours.');
            bookingForm.reset();
            btn.textContent = origText;
            btn.disabled = false;
          }, 800);
        });
      }
    });
  </script>
JS;

// Assemble Complete HTML File
$finalHtml = $topPart . "\n  <main id=\"main-content\" class=\"best-consultant-main\">\n\n" . $mainContent . "\n\n  </main>\n\n" . $siteFooter . "\n\n" . $scripts . "\n</body>\n</html>";

file_put_contents(__DIR__ . '/../service-best-marketing-consultant.html', $finalHtml);
echo "Successfully rebuilt pure service-best-marketing-consultant.html (" . strlen($finalHtml) . " bytes)\n";

