<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');

// Replace images with local assets
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

// Clean lazy loading base64 placeholders and attributes
$html = preg_replace('/src="data:image\/[^"]*"/i', '', $html);
$html = preg_replace('/data-src="([^"]*)"/i', 'src="$1"', $html);
$html = preg_replace('/data-lazy-src="([^"]*)"/i', 'src="$1"', $html);
$html = preg_replace('/data-lazyloaded="[^"]*"/i', '', $html);
$html = preg_replace('/class="([^"]*)\blitespeed-loaded\b([^"]*)"/i', 'class="$1$2"', $html);

// Clean up contact links
$html = str_replace('https://ritwiksachdeva.in/contact-us/', 'contact.html', $html);
$html = str_replace('http://ritwiksachdeva.in/contact-us/', 'contact.html', $html);
$html = str_replace('/contact-us/', 'contact.html', $html);

file_put_contents(__DIR__ . '/clean_best_consultant_main.html', $html);
echo "Cleaned body saved (" . strlen($html) . " bytes)\n";


