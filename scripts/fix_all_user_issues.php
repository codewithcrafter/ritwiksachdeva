<?php
// Load raw body and original files
$rawBody = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$indexHtml = file_get_contents(__DIR__ . '/../index.html');
$originalPage = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');

// 1. Extract Head and Navigation from originalPage
preg_match('/^(.*?)<main\b[^>]*>/is', $originalPage, $topPartMatch);
$topPart = $topPartMatch[1] ?? '';

// Ensure best-consultant-live.css is linked in <head>
if (strpos($topPart, 'css/best-consultant-live.css') === false) {
    $topPart = str_replace(
        '<link rel="stylesheet" href="css/services.css">',
        "<link rel=\"stylesheet\" href=\"css/services.css\">\n  <link rel=\"stylesheet\" href=\"css/best-consultant-live.css\">",
        $topPart
    );
}

// 2. Extract clean site-footer from index.html
preg_match('/<footer class="site-footer".*?<\/footer>/is', $indexHtml, $footerMatch);
$siteFooter = $footerMatch[0] ?? '';

// 3. Extract Section 1: Hero Section
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

// 4. Build Section 2: Proven Digital Impact
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

// 5. Extract Section 3: Our Digital Marketing Services
$servicesStart = strpos($rawBody, 'Our Digital Marketing Services');
$servicesStart = strrpos(substr($rawBody, 0, $servicesStart), '<section');
if ($servicesStart === false) {
    $servicesStart = strrpos(substr($rawBody, 0, strpos($rawBody, 'Our Digital Marketing Services')), '<div');
}
$servicesEnd = strpos($rawBody, 'Trusted by Leading Brands');
$servicesEnd = strrpos(substr($rawBody, 0, $servicesEnd), '<section');
$servicesHtml = substr($rawBody, $servicesStart, $servicesEnd - $servicesStart);

// Clean up Services links
$serviceLinks = [
    'Web Design &amp; Development' => 'service-website-designer.html',
    'Social Media Marketing' => 'service-social-media-marketing.html',
    'Content Writing' => 'contact.html',
    'Video Production &amp; Editing' => 'service-video-editing.html',
    'Performance Marketing' => 'service-performance-marketing.html',
    'SEO Services' => 'service-seo-expert.html'
];
foreach ($serviceLinks as $name => $url) {
    $servicesHtml = str_replace("<h3>$name</h3>", "<h3><a href=\"$url\" style=\"color:inherit;text-decoration:none;\">$name &rarr;</a></h3>", $servicesHtml);
}

// 6. Extract Section 4: Trusted by Leading Brands (Logos)
$brandsStart = strpos($rawBody, 'Trusted by Leading Brands');
$brandsStart = strrpos(substr($rawBody, 0, $brandsStart), '<section');
$brandsEnd = strpos($rawBody, '🚀 Our Results');
$brandsEnd = strrpos(substr($rawBody, 0, $brandsEnd), '<section');
$brandsHtml = substr($rawBody, $brandsStart, $brandsEnd - $brandsStart);

// Map Brand Images
$brandsHtml = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', '', $brandsHtml);
$brandsHtml = preg_replace('/src="data:image\/[^"]*"/i', '', $brandsHtml);
$brandsHtml = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $brandsHtml);
$brandsHtml = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/logo-1.png', 'assets/images/brand-logo-1.png', $brandsHtml);
$brandsHtml = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/download-1.png', 'assets/images/brand-logo-2.png', $brandsHtml);
$brandsHtml = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/delhi-6-final-png.png', 'assets/images/brand-logo-3.png', $brandsHtml);
$brandsHtml = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/printex-90x90-1.webp', 'assets/images/brand-logo-4.webp', $brandsHtml);
$brandsHtml = str_replace('https://ritwiksachdeva.in/wp-content/uploads/2026/01/download.jpg', 'assets/images/brand-logo-5.jpg', $brandsHtml);

// 7. Extract Section 5: Our Results Gallery (Screenshots)
$resultsStart = strpos($rawBody, '🚀 Our Results');
$resultsStart = strrpos(substr($rawBody, 0, $resultsStart), '<section');
$resultsEnd = strpos($rawBody, 'Digital Marketing Results That Speak for Themselves');
$resultsEnd = strrpos(substr($rawBody, 0, $resultsEnd), '<div class="elementor-element');
$resultsHtml = substr($rawBody, $resultsStart, $resultsEnd - $resultsStart);

$resultsHtml = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', '', $resultsHtml);
$resultsHtml = preg_replace('/src="data:image\/[^"]*"/i', '', $resultsHtml);
$resultsHtml = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $resultsHtml);
$resultsHtml = preg_replace('/\s*data-placeholder-resp="[^"]*"/i', '', $resultsHtml);
$resultsHtml = preg_replace('/\s*data-lazyloaded="[^"]*"/i', '', $resultsHtml);

for ($i = 1; $i <= 7; $i++) {
    $resultsHtml = str_replace("https://ritwiksachdeva.in/wp-content/uploads/2026/03/$i.jpg", "assets/images/result-$i.jpg", $resultsHtml);
}

// 8. Build Section 6: Digital Marketing Results That Speak for Themselves (Exact Match to Image 1)
$statsHtml = <<<'HTML'
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

// 9. Extract Section 7: Let's Build a Winning Digital Growth Strategy (CTA)
$growthStart = strpos($rawBody, "Let's Build a Winning Digital Growth Strategy");
$growthStart = strrpos(substr($rawBody, 0, $growthStart), '<section');
$growthEnd = strpos($rawBody, 'About Ritwik Sachdeva');
$growthEnd = strrpos(substr($rawBody, 0, $growthEnd), '<div class="elementor-element');
$growthHtml = substr($rawBody, $growthStart, $growthEnd - $growthStart);
$growthHtml = str_replace('https://ritwiksachdeva.in/contact-us/', 'contact.html', $growthHtml);

// 10. Extract Section 8: About Ritwik Sachdeva (Cards)
$aboutStart = strpos($rawBody, 'About Ritwik Sachdeva');
$aboutStart = strrpos(substr($rawBody, 0, $aboutStart), '<section');
$aboutEnd = strpos($rawBody, 'Schedule Your Free Strategy Call Today');
$aboutEnd = strrpos(substr($rawBody, 0, $aboutEnd), '<section');
$aboutHtml = substr($rawBody, $aboutStart, $aboutEnd - $aboutStart);

// 11. Build Section 9: Schedule Your Free Strategy Call Today (Exact Match to Image 2)
$strategyCallHtml = <<<'HTML'
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

// 12. Complete Main Body Content
$mainContent = implode("\n\n", [
    $heroHtml,
    $impactHtml,
    $servicesHtml,
    $brandsHtml,
    $resultsHtml,
    $statsHtml,
    $growthHtml,
    $aboutHtml,
    $strategyCallHtml
]);

// 13. Counter & Form JavaScript
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

// 14. Assemble Complete HTML File
$finalHtml = $topPart . "\n  <main id=\"main-content\" class=\"best-consultant-main\">\n" . $mainContent . "\n  </main>\n\n" . $siteFooter . "\n\n" . $scripts . "\n</body>\n</html>";

file_put_contents(__DIR__ . '/../service-best-marketing-consultant.html', $finalHtml);
echo "Successfully built updated service-best-marketing-consultant.html (" . strlen($finalHtml) . " bytes)\n";

