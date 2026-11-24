<?php
$content = file_get_contents('service-performance-marketing.html');
if (preg_match('/<a[^>]*WhatsApp Direct.*?<\/a>/is', $content, $m)) {
    echo $m[0] . "\n";
}
