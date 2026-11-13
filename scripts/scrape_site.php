<?php
$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($opts);
$html = @file_get_contents('https://www.ritwiksachdeva.in/', false, $context);
if (!$html) {
    echo "Failed to fetch homepage.\n";
    exit(1);
}

preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/si', $html, $matches);
$found = [];
for ($i = 0; $i < count($matches[1]); $i++) {
    $text = trim(preg_replace('/\s+/', ' ', strip_tags($matches[2][$i])));
    $href = $matches[1][$i];
    if ($text && !isset($found[$text])) {
        $found[$text] = $href;
        echo "$text => $href\n";
    }
}

