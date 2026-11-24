<?php
// scripts/apply_all_updates.php

$htmlFiles = glob('*.html');
$phpFiles = glob('*.php');
$allFiles = array_merge($htmlFiles, $phpFiles);

// --- 1. Footer Replacement Block ---
$newFooterBottom = '<div class="footer-bottom">
        <div class="footer-bottom-left">
          Strategic Digital Marketing &amp; Scaling Consultant.
        </div>
        <div class="footer-bottom-center">
          <div>
            <a href="/privacy-policy/">Privacy Policy</a> &bull; <a href="/terms/">Terms of Engagement</a>
          </div>
          <div class="footer-credit-link">
            Designed by <a href="https://www.buzzspiremedia.com/" target="_blank" rel="noopener noreferrer">Buzzspire Media Pvt Ltd</a>
          </div>
        </div>
        <div class="footer-bottom-right">
          &copy; 2026 Ritwik Sachdeva. All rights reserved.
        </div>
      </div>';

$footerCount = 0;
foreach ($allFiles as $file) {
    if (strpos($file, 'admin') !== false) continue;
    $content = file_get_contents($file);
    if (strpos($content, '<footer') === false) continue;

    // Pattern to match existing <div class="footer-bottom">...</div> inside <footer>
    $pattern = '/<div class="footer-bottom"[^>]*>.*?<\/div>\s*(?=<\/div>\s*<\/footer>|<\/footer>)/is';
    if (preg_match($pattern, $content)) {
        $updated = preg_replace($pattern, $newFooterBottom . "\n    ", $content);
        if ($updated !== $content) {
            file_put_contents($file, $updated);
            $footerCount++;
            echo "Updated footer in $file\n";
        }
    }
}
echo "Total footers updated: $footerCount\n";

// --- 2. Standardize Placeholders in consult-popup.html and contact.html ---
// Name: placeholder="e.g. Rohan Sharma"
// Email: placeholder="yourcompany@com"
// Phone: placeholder="+91 00000-00000"

$filesToUpdatePlaceholders = array_merge($allFiles, ['consult-popup.html', 'consult-popup.js']);
foreach ($filesToUpdatePlaceholders as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    $orig = $content;

    // Name placeholders
    $content = preg_replace('/placeholder=["\']e\.g\.\s*(?:Rahul Sharma|Alex Morgan|John Doe|Your Name)["\']/i', 'placeholder="e.g. Rohan Sharma"', $content);
    // Email placeholders
    $content = preg_replace('/placeholder=["\'](?:e\.g\.\s*)?(?:rahul@company\.com|alex@company\.com|your\.email@company\.com|name@company\.com|email@example\.com)["\']/i', 'placeholder="yourcompany@com"', $content);
    // Phone placeholders
    $content = preg_replace('/placeholder=["\'](?:(?:\+91\s*98765\s*43210)|(?:\+1\s*\(555\)\s*000-0000)|(?:\+91\s*9876543210)|(?:\+91\s*XXXXX-XXXXX))["\']/i', 'placeholder="+91 00000-00000"', $content);

    if ($content !== $orig) {
        file_put_contents($file, $content);
        echo "Updated placeholders in $file\n";
    }
}

// --- 3. Create physical services/*.md files ---
if (!is_dir('services')) {
    mkdir('services', 0755, true);
}

// Copy service-*.md to services/*.md
$serviceMds = glob('service-*.md');
foreach ($serviceMds as $smd) {
    $slug = preg_replace('/^service-/', '', $smd);
    $target = "services/$slug";
    copy($smd, $target);
    echo "Copied $smd -> $target\n";
}
if (is_file('services.md')) {
    copy('services.md', 'services/index.md');
    echo "Copied services.md -> services/index.md\n";
}

// Also create blog/*.md if not present
if (!is_dir('blog')) {
    mkdir('blog', 0755, true);
}
$blogMds = glob('blog-*.md');
foreach ($blogMds as $bmd) {
    $slug = preg_replace('/^blog-/', '', $bmd);
    $target = "blog/$slug";
    copy($bmd, $target);
    echo "Copied $bmd -> $target\n";
}
if (is_file('blog.md')) {
    copy('blog.md', 'blog/index.md');
    echo "Copied blog.md -> blog/index.md\n";
}

echo "Markdown synchronization complete.\n";
