<?php
$url = 'http://localhost:8000/index.html';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $code\n";
echo "Length: " . strlen($res) . " bytes\n";

if ($code == 200) {
    echo "Check hero: " . (strpos($res, 'id="hero"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check what-consultant-does: " . (strpos($res, 'id="what-consultant-does"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check services: " . (strpos($res, 'id="services"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check who-for: " . (strpos($res, 'id="who-for"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check choosing-consultant: " . (strpos($res, 'id="choosing-consultant"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check results-focused-marketing: " . (strpos($res, 'id="results-focused-marketing"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check trusted-businesses-searching: " . (strpos($res, 'id="trusted-businesses-searching"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check dm-faq: " . (strpos($res, 'id="dm-faq"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check cta-consultant-delhi: " . (strpos($res, 'id="cta-consultant-delhi"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check image: " . (strpos($res, 'assets/images/Best-Digital-Marketing-Consultant-in-Delhi.webp') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check header navbar: " . (strpos($res, 'class="site-header"') !== false ? 'PASS' : 'FAIL') . "\n";
    echo "Check footer: " . (strpos($res, 'class="site-footer"') !== false ? 'PASS' : 'FAIL') . "\n";
}

