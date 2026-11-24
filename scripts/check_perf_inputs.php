<?php
$c = file_get_contents('service-performance-marketing.html');
preg_match_all('/<input[^>]*>/i', $c, $inputs);
foreach ($inputs[0] as $inp) {
    echo $inp . "\n";
}
preg_match_all('/<textarea[^>]*>/i', $c, $txts);
foreach ($txts[0] as $t) {
    echo $t . "\n";
}
