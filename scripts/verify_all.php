<?php
// verify_all.php

function testUrl($url) {
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

$tests = [
    'http://localhost:8000/' => 200,
    'http://localhost:8000/about' => 200,
    'http://localhost:8000/about/' => 301,
    'http://localhost:8000/services' => 200,
    'http://localhost:8000/services/' => 301,
    'http://localhost:8000/services/performance-marketing' => 200,
    'http://localhost:8000/services/performance-marketing/' => 301,
    'http://localhost:8000/blog' => 200,
    'http://localhost:8000/blog/' => 301,
    'http://localhost:8000/blog/business-growth-strategy' => 200,
    'http://localhost:8000/blog/business-growth-strategy/' => 301,
    'http://localhost:8000/contact' => 200,
    'http://localhost:8000/privacy-policy' => 200,
    'http://localhost:8000/terms' => 200,
    'http://localhost:8000/services/performance-marketing.md' => 200,
    'http://localhost:8000/llms.txt' => 200,
    'http://localhost:8000/sitemap.xml' => 200,
];

echo "=== ROUTING & REDIRECT VERIFICATION ===\n";
$allPass = true;
foreach ($tests as $url => $expected) {
    $res = testUrl($url);
    $pass = ($res['code'] === $expected);
    if (!$pass) $allPass = false;
    echo ($pass ? '[PASS]' : '[FAIL]') . " $url -> Got {$res['code']} (Expected $expected)";
    if ($res['redirect']) echo " -> Redirected to: {$res['redirect']}";
    echo "\n";
}

echo "\n=== PLACEHOLDER CHECKS ===\n";
$popup = file_get_contents(__DIR__ . '/../consult-popup.html');
echo "consult-popup Name placeholder: " . (strpos($popup, 'placeholder="e.g. Rohan Sharma"') !== false ? "PASS\n" : "FAIL\n");
echo "consult-popup Email placeholder: " . (strpos($popup, 'placeholder="alex@company.com"') !== false ? "PASS\n" : "FAIL\n");
echo "consult-popup Phone placeholder: " . (strpos($popup, 'placeholder="+91 00000-00000"') !== false ? "PASS\n" : "FAIL\n");

$perf = file_get_contents(__DIR__ . '/../service-performance-marketing.html');
echo "service-performance-marketing Phone placeholder: " . (strpos($perf, 'placeholder="+91 00000-00000"') !== false ? "PASS\n" : "FAIL\n");
echo "service-performance-marketing Email placeholder: " . (strpos($perf, 'placeholder="alex@company.com"') !== false ? "PASS\n" : "FAIL\n");

echo "\n=== ENCODING & RUPEE CHECKS ===\n";
echo "service-performance-marketing contains '₹50 Cr+': " . (strpos($perf, '₹50 Cr+') !== false ? "PASS\n" : "FAIL\n");
echo "service-performance-marketing contains ',50 Cr+': " . (strpos($perf, ',50 Cr+') === false ? "PASS (None found)\n" : "FAIL\n");
echo "service-performance-marketing contains broken chars: " . (strpos($perf, "\xEF\xBF\xBD") === false ? "PASS (None found)\n" : "FAIL\n");

echo "\n=== WHATSAPP ICON CHECK ===\n";
echo "service-performance-marketing has official WhatsApp SVG: " . (strpos($perf, '17.472 14.382') !== false ? "PASS\n" : "FAIL\n");

echo "\n=== ADMIN PANEL SIDEBAR CHECK ===\n";
$sidebar = file_get_contents(__DIR__ . '/../admin/includes/sidebar.php');
$hasDashboard = strpos($sidebar, 'Dashboard') !== false;
$hasBlog = strpos($sidebar, 'Blog') !== false;
$hasLeads = strpos($sidebar, 'Leads') !== false;
$hasSettings = strpos($sidebar, 'Settings') !== false;
$hasSeo = strpos($sidebar, 'SEO & Schema') !== false;
echo "Sidebar has Dashboard: " . ($hasDashboard ? "YES\n" : "NO\n");
echo "Sidebar has Blog: " . ($hasBlog ? "YES\n" : "NO\n");
echo "Sidebar has Leads: " . ($hasLeads ? "YES\n" : "NO\n");
echo "Sidebar has Settings: " . ($hasSettings ? "YES\n" : "NO\n");
echo "Sidebar excludes separate SEO menu: " . (!$hasSeo ? "PASS\n" : "FAIL\n");

echo "\n=== PYTHON FILES CHECK ===\n";
$pyFiles = glob(__DIR__ . '/../*.py');
echo "Python files in workspace: " . (empty($pyFiles) ? "0 (PASS)\n" : count($pyFiles) . " (FAIL)\n");

echo "\nOverall Result: " . ($allPass ? "ALL TESTS PASSED!" : "SOME TESTS FAILED") . "\n";
