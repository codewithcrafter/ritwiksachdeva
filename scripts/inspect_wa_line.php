<?php
$lines = file('service-performance-marketing.html');
foreach ($lines as $num => $line) {
    if (stripos($line, 'WhatsApp Direct') !== false) {
        for ($i = max(0, $num - 5); $i < min(count($lines), $num + 15); $i++) {
            echo ($i + 1) . ": " . $lines[$i];
        }
        break;
    }
}
