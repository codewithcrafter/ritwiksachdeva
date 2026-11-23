<?php
$files = ['index.html', 'about.html', 'contact.html', 'blog.html', 'blog-detail.php', 'blog.php'];
foreach ($files as $f) {
    $path = __DIR__ . '/../' . $f;
    if (!file_exists($path)) continue;
    $c = file_get_contents($path);
    
    // Pattern that matches duplicate leftover dropdown chunk
    $pattern = '/(<\/div>\s*<\/div>)\s*<\/a>\s*<a href="service-brand-strategy\.html".*?<\/div>\s*<\/div>\s*<\/li>/s';
    if (preg_match($pattern, $c)) {
        $c = preg_replace($pattern, '$1' . "\n          </li>", $c);
        file_put_contents($path, $c);
        echo "Cleaned duplicate in $f\n";
    }
}


