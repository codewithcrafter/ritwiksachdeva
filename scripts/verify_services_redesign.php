<?php
// verify_services_redesign.php

$files = [
    'service-graphic-designer.html',
    'service-performance-marketing.html',
    'service-seo-expert.html',
    'service-ecommerce-management.html',
    'service-ppc-expert.html',
    'service-product-shoot.html',
    'service-smo-services.html',
    'service-social-media-marketing.html',
    'service-video-editing.html',
    'service-website-designer.html',
    'service-best-marketing-consultant.html'
];

echo "=== VERIFYING ALL 11 SERVICE PAGES ===\n\n";

$allPassed = true;

foreach ($files as $file) {
    $path = __DIR__ . '/../' . $file;
    if (!file_exists($path)) {
        echo "[FAIL] File missing: $file\n";
        $allPassed = false;
        continue;
    }

    $c = file_get_contents($path);
    $errors = [];

    // 1. Check CSS link
    if (strpos($c, 'css/service-detail.css') === false) {
        $errors[] = "Missing link to css/service-detail.css";
    }

    // 2. Check .rs-fluid-4cm
    if (strpos($c, 'rs-fluid-4cm') === false) {
        $errors[] = "Missing .rs-fluid-4cm class";
    }

    // 3. Check for broken UTF-8 chars
    if (strpos($c, "\xEF\xBF\xBD") !== false) {
        $errors[] = "Contains broken UTF-8 replacement character (\\xEF\\xBF\\xBD)";
    }
    if (strpos($c, ',50 Cr+') !== false) {
        $errors[] = "Contains unescaped ',50 Cr+' instead of '₹50 Cr+'";
    }

    // For the 10 main service detail pages
    if ($file !== 'service-best-marketing-consultant.html') {
        // Hero grid check
        if (strpos($c, 'sd-hero-grid') === false) {
            $errors[] = "Missing .sd-hero-grid";
        }
        if (strpos($c, 'sd-hero-form-card') === false) {
            $errors[] = "Missing .sd-hero-form-card above the fold";
        }

        // Placeholders check
        if (strpos($c, 'placeholder="e.g. Rohan Sharma"') === false) {
            $errors[] = "Missing Name placeholder 'e.g. Rohan Sharma'";
        }
        if (strpos($c, 'placeholder="alex@company.com"') === false) {
            $errors[] = "Missing Email placeholder 'alex@company.com'";
        }
        if (strpos($c, 'placeholder="+91 00000-00000"') === false) {
            $errors[] = "Missing Phone placeholder '+91 00000-00000'";
        }
        if (strpos($c, 'placeholder="Tell us about your project, goals, or challenges..."') === false) {
            $errors[] = "Missing Message placeholder 'Tell us about your project, goals, or challenges...'";
        }

        // WhatsApp SVG check
        if (strpos($c, '17.472 14.382') === false) {
            $errors[] = "Missing official WhatsApp SVG path";
        }

        // Tabs & Deliverables grid
        if (strpos($c, 'sd-tab-bar') === false) {
            $errors[] = "Missing interactive tab bar .sd-tab-bar";
        }
        if (strpos($c, 'sd-deliverables-grid') === false) {
            $errors[] = "Missing 4-column .sd-deliverables-grid";
        }

        // Bento grid
        if (strpos($c, 'sd-bento-grid') === false) {
            $errors[] = "Missing 3-column .sd-bento-grid";
        }

        // FAQ 2-col grid
        if (strpos($c, 'sd-faq-grid') === false) {
            $errors[] = "Missing 2-column .sd-faq-grid";
        }

        // Script check
        if (strpos($c, 'js/service-detail.js') === false) {
            $errors[] = "Missing script js/service-detail.js";
        }
    }

    // 4. Footer check
    if (strpos($c, 'Strategic Digital Marketing &amp; Scaling Consultant.') === false && strpos($c, 'Strategic Digital Marketing & Scaling Consultant.') === false) {
        $errors[] = "Missing footer brand tagline";
    }
    if (strpos($c, 'https://www.buzzspiremedia.com/') === false) {
        $errors[] = "Missing Buzzspire link in footer";
    }
    if (strpos($c, '© 2026 Ritwik Sachdeva. All rights reserved.') === false) {
        $errors[] = "Missing copyright in footer";
    }

    if (empty($errors)) {
        echo "[PASS] $file: 100% compliant with 4cm layout, compact grids, and standardized forms.\n";
    } else {
        echo "[FAIL] $file:\n";
        foreach ($errors as $e) echo "   - $e\n";
        $allPassed = false;
    }
}

// 5. Test HTTP server responses
echo "\n=== TESTING HTTP SERVER ROUTES ===\n";
function checkRoute($url, $expectedCode) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $redirect = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);
    return ['code' => $code, 'redirect' => $redirect];
}

$routesToTest = [
    'http://localhost:8000/services/graphic-designer' => 200,
    'http://localhost:8000/services/graphic-designer/' => 301,
    'http://localhost:8000/services/performance-marketing' => 200,
    'http://localhost:8000/services/performance-marketing/' => 301,
    'http://localhost:8000/services/seo-expert' => 200,
    'http://localhost:8000/services/ecommerce-management' => 200,
    'http://localhost:8000/services/ppc-expert' => 200,
    'http://localhost:8000/services/product-shoot' => 200,
    'http://localhost:8000/services/smo-services' => 200,
    'http://localhost:8000/services/social-media-marketing' => 200,
    'http://localhost:8000/services/video-editing' => 200,
    'http://localhost:8000/services/website-designer' => 200,
];

foreach ($routesToTest as $rUrl => $exp) {
    $res = checkRoute($rUrl, $exp);
    $pass = ($res['code'] === $exp);
    if (!$pass) $allPassed = false;
    echo ($pass ? "[PASS]" : "[FAIL]") . " $rUrl -> Got {$res['code']} (Expected $exp)";
    if ($res['redirect']) echo " -> Redirected: {$res['redirect']}";
    echo "\n";
}

echo "\n========================================\n";
echo "OVERALL VERIFICATION: " . ($allPassed ? "ALL 11 PAGES 100% PASSED!" : "SOME CHECKS FAILED") . "\n";
echo "========================================\n";
