<?php
$url = 'https://ritwiksachdeva.in/best-digital-marketing-consultant/';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
file_put_contents(__DIR__ . '/live_best_consultant.html', $html);
echo "HTTP $code, Fetched " . strlen($html) . " bytes from $url\n";

