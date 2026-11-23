<?php
$slugs = [
    'digital-transformation-strategies' => 'blog-digital-transformation-strategies.html',
    'business-growth-strategy' => 'blog-business-growth-strategy.html',
    'leadership-skills' => 'blog-leadership-skills.html',
    'ai-in-business' => 'blog-ai-in-business.html',
    'marketing-strategies' => 'blog-marketing-strategies.html'
];

foreach ($slugs as $slug => $filename) {
    $url = 'http://localhost:8000/blog-detail.php?slug=' . $slug;
    $html = file_get_contents($url);
    if (!$html) {
        echo "Failed to fetch $url\n";
        continue;
    }
    // Replace dynamic links with static equivalents for local browsing
    $html = str_replace('href="blog.php"', 'href="blog.html"', $html);
    $html = str_replace('href="blog.php?', 'href="blog.html?', $html);
    $html = str_replace("href='blog.php'", "href='blog.html'", $html);
    foreach ($slugs as $s => $f) {
        $html = str_replace('blog-detail.php?slug=' . $s, $f, $html);
        $html = str_replace('/blog/' . $s, $f, $html);
    }
    file_put_contents($filename, $html);
    echo "Exported $filename (" . strlen($html) . " bytes)\n";
}


