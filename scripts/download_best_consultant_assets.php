<?php
$images = [
    'stage-photo.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/01/Untitled-design-3.jpg',
    'brand-logo-1.png' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/01/logo-1.png',
    'brand-logo-2.png' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/01/download-1.png',
    'brand-logo-3.png' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/01/delhi-6-final-png.png',
    'brand-logo-4.webp' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/01/printex-90x90-1.webp',
    'brand-logo-5.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/01/download.jpg',
    'result-1.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/1.jpg',
    'result-2.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/2.jpg',
    'result-3.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/3.jpg',
    'result-4.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/4.jpg',
    'result-5.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/5.jpg',
    'result-6.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/6.jpg',
    'result-7.jpg' => 'https://ritwiksachdeva.in/wp-content/uploads/2026/03/7.jpg'
];

foreach ($images as $localName => $remoteUrl) {
    $dest = __DIR__ . '/../assets/images/' . $localName;
    if (file_exists($dest) && filesize($dest) > 1000) {
        echo "Already exists: $localName\n";
        continue;
    }
    $ch = curl_init($remoteUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($code == 200 && strlen($data) > 500) {
        file_put_contents($dest, $data);
        echo "Downloaded $localName ($code, " . strlen($data) . " bytes)\n";
    } else {
        echo "Failed $localName (HTTP $code)\n";
    }
}


