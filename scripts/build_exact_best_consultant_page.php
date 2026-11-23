<?php
$original = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
$cleanBody = file_get_contents(__DIR__ . '/clean_best_consultant_main.html');

// 1. Ensure marketing-hero-wrap opens properly
if (strpos($cleanBody, '<section class="marketing-hero-wrap">') === false) {
    $cleanBody = '<section class="marketing-hero-wrap">' . "\n" . $cleanBody;
}

// 2. Extract Head, Header, Mobile Drawer, and Footer from original
preg_match('/^(.*?)<header class="site-header"/s', $original, $headMatch);
$headPart = $headMatch[1] ?? '';

// Ensure best-consultant-live.css is linked in head
if (strpos($headPart, 'css/best-consultant-live.css') === false) {
    $headPart = str_replace(
        '<link rel="stylesheet" href="css/services.css">',
        "<link rel=\"stylesheet\" href=\"css/services.css\">\n  <link rel=\"stylesheet\" href=\"css/best-consultant-live.css\">",
        $headPart
    );
}

// Extract header and mobile drawer
preg_match('/(<header class="site-header".*?<\/div>\s*<\/div>\s*<\/header>.*?<div class="mobile-drawer".*?<\/div>\s*<\/div>)/s', $original, $navMatch);
$navPart = $navMatch[1] ?? '';

// If mobile drawer structure needs clean extraction:
if (empty($navPart)) {
    // Fallback regex
    preg_match('/(<header class="site-header".*?<main)/s', $original, $navFallback);
    $navPart = preg_replace('/<main$/', '', $navFallback[1] ?? '');
}

// Extract footer and closing scripts
preg_match('/(<footer class="site-footer".*?<\/html>)/s', $original, $footerMatch);
$footerPart = $footerMatch[1] ?? '';

// Counter animation and interactivity script
$interactiveScript = <<<'JS'
  <!-- Counter & Slider Interactivity -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // 1. Counter animation using IntersectionObserver
      const animateCounters = () => {
        const counters = document.querySelectorAll('.counter, .elementor-counter-number');
        if (!counters.length) return;

        const observer = new IntersectionObserver((entries, obs) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const el = entry.target;
              const target = parseInt(el.getAttribute('data-target') || el.getAttribute('data-to-value'), 10);
              if (!isNaN(target)) {
                let start = 0;
                const duration = 1500;
                const startTime = performance.now();
                const updateCount = (currentTime) => {
                  const elapsed = currentTime - startTime;
                  const progress = Math.min(elapsed / duration, 1);
                  // easeOutExpo
                  const current = Math.floor(progress === 1 ? target : target * (1 - Math.pow(2, -10 * progress)));
                  el.textContent = current;
                  if (progress < 1) {
                    requestAnimationFrame(updateCount);
                  } else {
                    el.textContent = target;
                  }
                };
                requestAnimationFrame(updateCount);
              }
              obs.unobserve(el);
            }
          });
        }, { threshold: 0.2 });

        counters.forEach(c => observer.observe(c));
      };

      animateCounters();

      // 2. Consultation Strategy Form
      const form = document.querySelector('.wpforms-form');
      if (form) {
        form.addEventListener('submit', (e) => {
          e.preventDefault();
          const btn = form.querySelector('button[type="submit"]');
          if (btn) btn.textContent = 'Submitting...';
          setTimeout(() => {
            alert('Thank you for booking your strategy session! Ritwik Sachdeva will reach out to you shortly.');
            form.reset();
            if (btn) btn.textContent = 'Submit';
          }, 800);
        });
      }
    });
  </script>
JS;

// Insert script before </body>
$footerPart = str_replace('</body>', $interactiveScript . "\n</body>", $footerPart);

// Construct complete page
$fullPage = $headPart . "\n" . $navPart . "\n  <main id=\"main-content\" class=\"best-consultant-main\">\n" . $cleanBody . "\n  </main>\n" . $footerPart;

file_put_contents(__DIR__ . '/../service-best-marketing-consultant.html', $fullPage);
echo "Updated service-best-marketing-consultant.html (" . strlen($fullPage) . " bytes)\n";


