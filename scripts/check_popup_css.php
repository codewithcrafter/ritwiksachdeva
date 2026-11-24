<?php
$css = file_get_contents('consult-popup.css');
preg_match_all('/\.[a-zA-Z0-9_\-]+input[^{]*\{[^}]*\}/is', $css, $m);
foreach ($m[0] as $r) {
    echo $r . "\n---\n";
}
// Also check placeholder styles in consult-popup.css
preg_match_all('/::placeholder[^{]*\{[^}]*\}/is', $css, $p);
foreach ($p[0] as $r) {
    echo $r . "\n";
}
