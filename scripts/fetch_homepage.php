<?php
$ch = curl_init('https://www.ritwiksachdeva.in/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
file_put_contents(__DIR__ . '/live_home.html', $html);
echo "HTTP $code, Fetched " . strlen($html) . " bytes from https://www.ritwiksachdeva.in/\n";

