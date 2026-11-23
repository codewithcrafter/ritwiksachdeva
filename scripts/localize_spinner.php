<?php
$f = __DIR__ . '/../service-best-marketing-consultant.html';
$c = file_get_contents($f);
$c = str_replace('https://ritwiksachdeva.in/wp-content/plugins/wpforms-lite/assets/images/submit-spin.svg', 'assets/images/submit-spin.svg', $c);
file_put_contents($f, $c);
echo "Updated submit-spin in $f\n";


