<?php
$js = file_get_contents('consult-popup.js');
$lines = explode("\n", $js);
for ($i = 50; $i < 115; $i++) {
    echo ($i+1) . ": " . $lines[$i] . "\n";
}
