<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');
preg_match_all('/<img[^>]+src="([^">]+)"/i', $html, $matches);

$images = array_unique($matches[1]);
echo "Found " . count($images) . " unique images in service-best-marketing-consultant.html:\n";

$allPassed = true;
foreach ($images as $img) {
    if (strpos($img, 'http') === 0) {
        $url = $img;
    } else {
        $url = 'http://localhost:8000/' . ltrim($img, '/');
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $status = ($code >= 200 && $code < 400) ? 'OK (200)' : "FAIL ($code)";
    if ($code < 200 || $code >= 400) $allPassed = false;
    echo "  $status : $img\n";
}

if ($allPassed) {
    echo "\n>>> ALL IMAGES VERIFIED AND ACCESSIBLE! <<<\n";
} else {
    echo "\n>>> WARNING: Some images failed to load! <<<\n";
}


