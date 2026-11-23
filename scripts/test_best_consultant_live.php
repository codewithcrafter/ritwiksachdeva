<?php
$ch = curl_init('http://localhost:8000/service-best-marketing-consultant.html');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status Code: $httpCode\n";
echo "Response Length: " . strlen($response) . " bytes\n";

// Check for key elements
$checks = [
    'WHO WE ARE',
    'THE BEST MARKETING CONSULTANT IN DELHI',
    'assets/images/stage-photo.jpg',
    'Proven Digital Impact',
    'Our Digital Marketing Services',
    'assets/images/brand-logo-1.png',
    'assets/images/result-7.jpg',
    'Digital Marketing Results That Speak for Themselves',
    'About Ritwik Sachdeva',
    'Schedule Your Free Strategy Call Today',
    'best marketing consultant',
    'css/best-consultant-live.css'
];

foreach ($checks as $item) {
    echo "$item: " . (strpos($response, $item) !== false ? 'PASS' : 'FAIL') . "\n";
}


