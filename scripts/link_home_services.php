<?php
$html = file_get_contents(__DIR__ . '/../index.html');

$map = [
    'SEO &amp; PPC Consultant Delhi' => 'service-seo-expert.html',
    'Performance Marketing Consultant Delhi' => 'service-performance-marketing.html',
    'Social Media Marketing Consultant Delhi' => 'service-social-media-marketing.html',
    'Growth Marketing Consultant in Delhi' => 'service-best-marketing-consultant.html',
    'B2B Digital Marketing Consultant Delhi' => 'service-best-marketing-consultant.html',
    'E-commerce Digital Marketing Consultant Delhi' => 'service-ecommerce-management.html',
    'Digital Marketing Advisory Services Delhi' => 'service-best-marketing-consultant.html',
    'Lead Generation Strategist Delhi' => 'service-ppc-expert.html'
];

foreach ($map as $title => $url) {
    // Replace <div class="dm-service-card"> that contains this title with <a href="$url" class="dm-service-card">
    // Find title position
    $tPos = strpos($html, $title);
    if ($tPos !== false) {
        $cardStart = strrpos(substr($html, 0, $tPos), '<div class="dm-service-card">');
        if ($cardStart !== false) {
            // Check distance
            if ($tPos - $cardStart < 400) {
                // Find closing </div> of this card
                $cardClose = strpos($html, '</div>', $tPos);
                if ($cardClose !== false) {
                    $html = substr_replace($html, '</a>', $cardClose, 6);
                    $html = substr_replace($html, '<a href="' . $url . '" class="dm-service-card">', $cardStart, 29);
                    echo "Linked: $title => $url\n";
                }
            }
        }
    }
}

file_put_contents(__DIR__ . '/../index.html', $html);
echo "index.html updated with service card links.\n";

