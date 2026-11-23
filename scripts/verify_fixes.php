<?php
$html = file_get_contents(__DIR__ . '/../service-best-marketing-consultant.html');

echo "=== VERIFICATION OF ALL USER FIXES ===\n\n";

// 1. Proven Digital Impact Counters
$p1 = strpos($html, 'Proven Digital Impact');
echo "1. Proven Digital Impact Section: " . ($p1 !== false ? "FOUND" : "MISSING") . "\n";
preg_match_all('/<span class="counter" data-target="(\d+)">/', $html, $counters);
echo "   Proven Impact Counters targets: " . implode(', ', $counters[1]) . "\n";

// 2. Results That Speak For Themselves
$p2 = strpos($html, 'results-stats-section');
echo "2. Results That Speak For Themselves Section: " . ($p2 !== false ? "FOUND" : "MISSING") . "\n";
preg_match_all('/<span class="stat-number counter" data-target="(\d+)">/', $html, $statCounters);
echo "   Stat Number Counters targets: " . implode(', ', $statCounters[1]) . "\n";

// 3. Strategy Call Today
$p3 = strpos($html, 'strategy-call-section');
echo "3. Strategy Call Today Section: " . ($p3 !== false ? "FOUND" : "MISSING") . "\n";
echo "   Has Dark Card (.strategy-call-card): " . (strpos($html, 'strategy-call-card') !== false ? "YES" : "NO") . "\n";
echo "   Has Name field: " . (strpos($html, 'id="strat-name"') !== false ? "YES" : "NO") . "\n";
echo "   Has Email field: " . (strpos($html, 'id="strat-email"') !== false ? "YES" : "NO") . "\n";
echo "   Has Message field: " . (strpos($html, 'id="strat-message"') !== false ? "YES" : "NO") . "\n";
echo "   Has Submit button: " . (strpos($html, 'class="strategy-submit-btn"') !== false ? "YES" : "NO") . "\n";

// 4. Footer Checks
echo "4. Footer Verification:\n";
$wpFooterCount = substr_count($html, 'WPFooter');
$colophonCount = substr_count($html, 'id="colophon"');
$siteFooterCount = substr_count($html, 'class="site-footer"');
echo "   WordPress WPFooter count: $wpFooterCount (Expect 0)\n";
echo "   WordPress colophon count: $colophonCount (Expect 0)\n";
echo "   Site Footer count: $siteFooterCount (Expect 1)\n";

// 5. Check closing tags
echo "5. Structure:\n";
echo "   Opening <main>: " . substr_count($html, '<main') . "\n";
echo "   Closing </main>: " . substr_count($html, '</main>') . "\n";
echo "   Opening <body>: " . substr_count($html, '<body') . "\n";
echo "   Closing </body>: " . substr_count($html, '</body>') . "\n";


