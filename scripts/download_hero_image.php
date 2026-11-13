<?php
$url = 'https://ritwiksachdeva.in/wp-content/uploads/2026/08/Best-Digital-Marketing-Consultant-in-Delhi.webp';
$dest = __DIR__ . '/../assets/images/Best-Digital-Marketing-Consultant-in-Delhi.webp';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$data = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($code == 200 && strlen($data) > 1000) {
    file_put_contents($dest, $data);
    echo "Downloaded Hero Image ($code, " . strlen($data) . " bytes) to assets/images/\n";
} else {
    echo "Failed to download image (HTTP $code, " . strlen($data) . " bytes)\n";
}

