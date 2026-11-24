<?php
// update_all_placeholders.php

$files = array_merge(
    glob(__DIR__ . '/../*.html'),
    glob(__DIR__ . '/../*.php'),
    glob(__DIR__ . '/../*.js')
);

$namePlaceholder = 'Alex';
$emailPlaceholder = 'alex@company.com';
$phonePlaceholder = '00000-00000';
$messagePlaceholder = 'Tell us about your business goals, current challenges, or timeline...';

foreach ($files as $file) {
    if (is_dir($file)) continue;
    $content = file_get_contents($file);
    $orig = $content;

    // Name inputs
    $content = preg_replace(
        '/(<input[^>]+(?:name|id)=["\'](?:name|full_name|contact_name|client_name|author)["\'][^>]*?)\s+placeholder=["\'][^"\']*["\']/i',
        '$1 placeholder="' . $namePlaceholder . '"',
        $content
    );
    $content = preg_replace_callback(
        '/(<input[^>]+placeholder=["\'](?:e\.g\.\s*)?(?:Rohan|John|Your Name|Full Name|Name)[^"\']*["\'][^>]*?)/i',
        function ($m) use ($namePlaceholder) {
            return preg_replace('/placeholder=["\'][^"\']*["\']/i', 'placeholder="' . $namePlaceholder . '"', $m[0]);
        },
        $content
    );

    // Email inputs
    $content = preg_replace(
        '/(<input[^>]+(?:type=["\']email["\']|(?:name|id)=["\']email["\'])[^>]*?)\s+placeholder=["\'][^"\']*["\']/i',
        '$1 placeholder="' . $emailPlaceholder . '"',
        $content
    );
    $content = preg_replace_callback(
        '/(<input[^>]+placeholder=["\'](?:[^"\']*(?:@|email)[^"\']*)["\'][^>]*?)/i',
        function ($m) use ($emailPlaceholder) {
            return preg_replace('/placeholder=["\'][^"\']*["\']/i', 'placeholder="' . $emailPlaceholder . '"', $m[0]);
        },
        $content
    );

    // Phone inputs
    $content = preg_replace(
        '/(<input[^>]+(?:type=["\']tel["\']|(?:name|id)=["\'](?:phone|mobile|whatsapp)["\'])[^>]*?)\s+placeholder=["\'][^"\']*["\']/i',
        '$1 placeholder="' . $phonePlaceholder . '"',
        $content
    );
    $content = preg_replace_callback(
        '/(<input[^>]+placeholder=["\'](?:[^"\']*(?:\+91|Phone|Mobile|WhatsApp|\+1|00000)[^"\']*)["\'][^>]*?)/i',
        function ($m) use ($phonePlaceholder) {
            return preg_replace('/placeholder=["\'][^"\']*["\']/i', 'placeholder="' . $phonePlaceholder . '"', $m[0]);
        },
        $content
    );

    // Textarea inputs
    $content = preg_replace(
        '/(<textarea[^>]*?)\s+placeholder=["\'][^"\']*["\']/i',
        '$1 placeholder="' . $messagePlaceholder . '"',
        $content
    );

    // Consultation popup: all three contact fields remain required, but the
    // visual asterisks are intentionally removed. Message is optional.
    $content = preg_replace('/\s*<span class="(?:consult|rs-popup)-required">\*<\/span>/', '', $content);
    $content = preg_replace('/(<label[^>]+for="consult-message"[^>]*>)Message\s*(?:\([^)]*\))?/', '$1Message (Optional)', $content);
    $content = preg_replace_callback('/<textarea([^>]*\bid="consult-message"[^>]*)>/i', function ($m) {
        return '<textarea' . preg_replace('/\srequired(?:=(?:"[^"]*"|\'[^\']*\'|[^\s>]+))?/i', '', $m[1]) . '>';
    }, $content);

    // Specific check for forms missing placeholder attribute
    if (strpos($file, 'consult-popup') !== false || strpos($file, 'service-') !== false || strpos($file, 'contact') !== false || strpos($file, 'index') !== false || strpos($file, 'about') !== false) {
        $content = preg_replace_callback('/<input([^>]+)>/i', function($m) use ($namePlaceholder, $emailPlaceholder, $phonePlaceholder) {
            $attrs = $m[1];
            if (strpos($attrs, 'placeholder=') === false) {
                if (preg_match('/(?:name|id)=["\'](?:phone|mobile|tel)["\']/i', $attrs) || preg_match('/type=["\']tel["\']/i', $attrs)) {
                    return '<input' . $attrs . ' placeholder="' . $phonePlaceholder . '">';
                }
                if (preg_match('/(?:name|id)=["\'](?:email)["\']/i', $attrs) || preg_match('/type=["\']email["\']/i', $attrs)) {
                    return '<input' . $attrs . ' placeholder="' . $emailPlaceholder . '">';
                }
                if (preg_match('/(?:name|id)=["\'](?:name|full_name)["\']/i', $attrs)) {
                    return '<input' . $attrs . ' placeholder="' . $namePlaceholder . '">';
                }
            }
            return $m[0];
        }, $content);

        $content = preg_replace_callback('/<textarea([^>]+)>/i', function($m) use ($messagePlaceholder) {
            $attrs = $m[1];
            if (strpos($attrs, 'placeholder=') === false) {
                return '<textarea' . $attrs . ' placeholder="' . $messagePlaceholder . '">';
            }
            return $m[0];
        }, $content);
    }

    if ($content !== $orig) {
        file_put_contents($file, $content);
        echo "Updated placeholders in: " . basename($file) . "\n";
    }
}

echo "Finished updating placeholders.\n";
