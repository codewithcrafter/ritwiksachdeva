<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');

// 1. Remove all <noscript>...</noscript> tags
$html = preg_replace('/<noscript\b[^>]*>.*?<\/noscript>/is', '', $html);

// 2. Remove base64 data src images
$html = preg_replace('/src="data:image\/[^"]*"/i', '', $html);

// 3. Promote data-src to src if src is missing or empty
$html = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $html);
$html = preg_replace('/data-lazy-src="([^"]*)"/i', 'src="$1"', $html);

// 4. Map remote images to local assets
$imgMap = [
    'https://ritwiksachdeva.in/wp-content/uploads/2026/01/Untitled-design-3.jpg' => 'assets/images/stage-photo.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/01/logo-1.png' => 'assets/images/brand-logo-1.png',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/01/download-1.png' => 'assets/images/brand-logo-2.png',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/01/delhi-6-final-png.png' => 'assets/images/brand-logo-3.png',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/01/printex-90x90-1.webp' => 'assets/images/brand-logo-4.webp',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/01/download.jpg' => 'assets/images/brand-logo-5.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/7.jpg' => 'assets/images/result-7.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/6.jpg' => 'assets/images/result-6.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/5.jpg' => 'assets/images/result-5.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/4.jpg' => 'assets/images/result-4.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/3.jpg' => 'assets/images/result-3.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/2.jpg' => 'assets/images/result-2.jpg',
    'https://ritwiksachdeva.in/wp-content/uploads/2026/03/1.jpg' => 'assets/images/result-1.jpg'
];

foreach ($imgMap as $remote => $local) {
    $html = str_replace($remote, $local, $html);
}

// 5. Clean WordPress / LiteSpeed residual attributes
$html = preg_replace('/\s*data-lazyloaded="[^"]*"/i', '', $html);
$html = preg_replace('/\s*data-placeholder-resp="[^"]*"/i', '', $html);
$html = preg_replace('/\s*data-optimized="[^"]*"/i', '', $html);
$html = str_replace('litespeed-loaded', '', $html);

// Remove duplicate src="" if any were left by consecutive replacements
$html = preg_replace('/src="\s*"\s*/i', '', $html);

// 6. Fix internal links
$html = str_replace('https://ritwiksachdeva.in/contact-us/', 'contact.html', $html);
$html = str_replace('http://ritwiksachdeva.in/contact-us/', 'contact.html', $html);
$html = str_replace('/contact-us/', 'contact.html', $html);
$html = str_replace('action="/best-digital-marketing-consultant/"', 'action="contact.html"', $html);

// 7. Make service boxes clickable links
$serviceLinks = [
    'Web Design &amp; Development' => 'service-website-designer.html',
    'Social Media Marketing' => 'service-social-media-marketing.html',
    'Content Writing' => 'contact.html',
    'Video Production &amp; Editing' => 'service-video-editing.html',
    'Performance Marketing' => 'service-performance-marketing.html',
    'SEO Services' => 'service-seo-expert.html'
];

foreach ($serviceLinks as $name => $url) {
    // Add cursor pointer style or wrap title
    $html = str_replace("<h3>$name</h3>", "<h3><a href=\"$url\" style=\"color:inherit;text-decoration:none;\">$name &rarr;</a></h3>", $html);
}

// 8. Set initial counter values for robust fallback
// <span class="counter" data-target="100">0</span>
$html = preg_replace('/(<span class="counter"[^>]*>)\s*0\s*(<\/span>)/i', '$1100$2', $html);
// Elementor counters:
$html = preg_replace('/(data-to-value="6"[^>]*>)\s*0\s*(<\/span>)/i', '$16$2', $html);
$html = preg_replace('/(data-to-value="120"[^>]*>)\s*0\s*(<\/span>)/i', '$1120$2', $html);
$html = preg_replace('/(data-to-value="100"[^>]*>)\s*0\s*(<\/span>)/i', '$1100$2', $html);
$html = preg_replace('/(data-to-value="98"[^>]*>)\s*0\s*(<\/span>)/i', '$198$2', $html);

file_put_contents(__DIR__ . '/clean_best_consultant_main.html', $html);
echo "Successfully generated clean_best_consultant_main.html (" . strlen($html) . " bytes)\n";

