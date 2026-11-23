<?php
$services = [
    'ecommerce' => 'https://ritwiksachdeva.in/e-commerce-management-services-in-delhi/',
    'graphic_design' => 'https://ritwiksachdeva.in/freelance-graphic-designer-in-delhi/',
    'performance_marketing' => 'https://ritwiksachdeva.in/performance-marketing-consultant-in-delhi/',
    'ppc_expert' => 'https://ritwiksachdeva.in/ppc-expert-in-delhi/',
    'product_shoot' => 'https://ritwiksachdeva.in/product-shoot-services-in-delhi/',
    'seo_expert' => 'https://ritwiksachdeva.in/seo-expert-in-delhi/',
    'smo_services' => 'https://ritwiksachdeva.in/smo-services-in-delhi/',
    'social_media_agency' => 'https://ritwiksachdeva.in/social-media-marketing-consultant-in-delhi/',
    'video_editing' => 'https://ritwiksachdeva.in/video-editing-services-in-delhi/',
    'best_marketing_consultant' => 'https://ritwiksachdeva.in/best-digital-marketing-consultant/',
    'website_designer' => 'https://ritwiksachdeva.in/website-designer-in-delhi/'
];

$opts = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n",
        'timeout' => 15
    ]
];
$context = stream_context_create($opts);

$data = [];
foreach ($services as $key => $url) {
    echo "Fetching $key from $url...\n";
    $html = @file_get_contents($url, false, $context);
    if ($html) {
        // Extract title
        preg_match('/<title[^>]*>(.*?)<\/title>/si', $html, $titleMatch);
        $title = trim($titleMatch[1] ?? '');
        
        // Extract meta description
        preg_match('/<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']*)["\']/si', $html, $descMatch);
        $desc = trim($descMatch[1] ?? '');
        
        // Extract H1, H2, H3
        preg_match_all('/<(h[1-3])[^>]*>(.*?)<\/\1>/si', $html, $hMatches);
        $headings = [];
        for ($i = 0; $i < count($hMatches[0]); $i++) {
            $hTag = strtolower($hMatches[1][$i]);
            $hText = trim(preg_replace('/\s+/', ' ', strip_tags($hMatches[2][$i])));
            if ($hText) {
                $headings[] = "$hTag: $hText";
            }
        }
        
        // Extract main text paragraphs
        preg_match_all('/<p[^>]*>(.*?)<\/p>/si', $html, $pMatches);
        $paras = [];
        for ($i = 0; $i < count($pMatches[0]); $i++) {
            $pText = trim(preg_replace('/\s+/', ' ', strip_tags($pMatches[1][$i])));
            if (strlen($pText) > 40 && !str_contains($pText, 'Copyright') && !str_contains($pText, 'All rights reserved')) {
                $paras[] = $pText;
            }
        }
        
        $data[$key] = [
            'url' => $url,
            'title' => $title,
            'desc' => $desc,
            'headings' => $headings,
            'paragraphs' => array_slice($paras, 0, 10)
        ];
    } else {
        echo "Failed to fetch $key\n";
    }
}

file_put_contents('scripts/scraped_services.json', json_encode($data, JSON_PRETTY_PRINT));
echo "Saved all scraped data to scripts/scraped_services.json\n";


