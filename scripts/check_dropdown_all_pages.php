<?php
$files = glob(__DIR__ . '/../*.html');
$missing = [];
foreach ($files as $file) {
    $content = file_get_contents($file);
    $name = basename($file);
    if (strpos($content, 'service-best-marketing-consultant.html') === false) {
        $missing[] = $name;
    }
}

echo "Total HTML files: " . count($files) . "\n";
echo "Files containing service-best-marketing-consultant.html: " . (count($files) - count($missing)) . "\n";
if (!empty($missing)) {
    echo "Missing in: " . implode(', ', $missing) . "\n";
} else {
    echo "ALL HTML files include service-best-marketing-consultant.html in their Services dropdown!\n";
}


