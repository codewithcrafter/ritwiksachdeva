<?php
$html = file_get_contents(__DIR__ . '/raw_best_consultant_body.html');
$posForm = strpos($html, 'Schedule Your Free Strategy Call Today');
echo "Form pos: $posForm\n";

$posFooter = strpos($html, '<footer', $posForm);
echo "Footer pos: $posFooter\n";
if ($posFooter !== false) {
    echo "Before footer:\n" . substr($html, $posFooter - 200, 200) . "\n---\n";
    echo "At footer:\n" . substr($html, $posFooter, 300) . "\n";
}

