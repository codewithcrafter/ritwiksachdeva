<?php
$html = file_get_contents(__DIR__ . '/live_home.html');

// Remove scripts, styles, noscripts
$html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
$html = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $html);
$html = preg_replace('#<noscript(.*?)>(.*?)</noscript>#is', '', $html);

$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
$xpath = new DOMXPath($doc);

echo "=== 1. HERO SECTION ===\n";
$h1s = $xpath->query('//h1');
foreach ($h1s as $h1) {
    echo "H1: " . trim($h1->textContent) . "\n";
}
// Find paragraphs right under or around H1
$heroPs = $xpath->query('//h1/following-sibling::p | //h1/../following-sibling::*//p | //h1/..//p');
foreach ($heroPs as $p) {
    echo "P: " . trim($p->textContent) . "\n";
}

echo "\n=== 2. WHAT A DIGITAL MARKETING CONSULTANT ACTUALLY DOES ===\n";
$s2 = $xpath->query('//*[contains(text(), "What a Digital Marketing Consultant Actually Does")]/ancestor::section[1] | //*[contains(text(), "What a Digital Marketing Consultant Actually Does")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s2->length > 0) {
    $ps = $xpath->query('.//p', $s2->item(0));
    foreach ($ps as $p) echo "  - " . trim($p->textContent) . "\n";
}

echo "\n=== 3. DIGITAL MARKETING SERVICES IN DELHI ===\n";
$s3 = $xpath->query('//*[contains(text(), "Digital Marketing Services in Delhi")]/ancestor::section[1] | //*[contains(text(), "Digital Marketing Services in Delhi")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s3->length > 0) {
    $cards = $xpath->query('.//div[contains(@class, "elementor-widget-icon-box")] | .//div[contains(@class, "elementor-column")]', $s3->item(0));
    echo "Cards count: " . $cards->length . "\n";
    foreach ($cards as $c) {
        $t = trim($c->textContent);
        if (strlen($t) > 20 && strlen($t) < 400) {
            echo "CARD: " . preg_replace('/\s+/', ' ', $t) . "\n";
        }
    }
}

echo "\n=== 4. WHO THIS IS FOR ===\n";
$s4 = $xpath->query('//*[contains(text(), "Who This Is For")]/ancestor::section[1] | //*[contains(text(), "Who This Is For")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s4->length > 0) {
    $items = $xpath->query('.//p | .//li | .//div[contains(@class, "elementor-icon-box-description")]', $s4->item(0));
    foreach ($items as $it) {
        $t = trim(preg_replace('/\s+/', ' ', $it->textContent));
        if ($t && $t !== 'Who This Is For') {
            echo "  ITEM: $t\n";
        }
    }
}

echo "\n=== 5. CHOOSING A DIGITAL MARKETING CONSULTANT IN DELHI ===\n";
$s5 = $xpath->query('//*[contains(text(), "Choosing a Digital Marketing Consultant in Delhi")]/ancestor::section[1] | //*[contains(text(), "Choosing a Digital Marketing Consultant in Delhi")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s5->length > 0) {
    $ps = $xpath->query('.//p', $s5->item(0));
    foreach ($ps as $p) echo "  - " . trim($p->textContent) . "\n";
}

echo "\n=== 6. RESULTS-FOCUSED DIGITAL MARKETING ===\n";
$s6 = $xpath->query('//*[contains(text(), "Results-Focused Digital Marketing")]/ancestor::section[1] | //*[contains(text(), "Results-Focused Digital Marketing")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s6->length > 0) {
    $items = $xpath->query('.//h3 | .//p', $s6->item(0));
    foreach ($items as $it) {
        $t = trim(preg_replace('/\s+/', ' ', $it->textContent));
        if ($t && $t !== 'Results-Focused Digital Marketing') {
            echo "  [" . $it->nodeName . "]: $t\n";
        }
    }
}

echo "\n=== 7. TRUSTED BY BUSINESSES SEARCHING FOR ===\n";
$s7 = $xpath->query('//*[contains(text(), "Trusted by Businesses Searching For")]/ancestor::section[1] | //*[contains(text(), "Trusted by Businesses Searching For")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s7->length > 0) {
    $ps = $xpath->query('.//p', $s7->item(0));
    foreach ($ps as $p) echo "  - " . trim($p->textContent) . "\n";
}

echo "\n=== 8. FREQUENTLY ASKED QUESTIONS ===\n";
$s8 = $xpath->query('//*[contains(text(), "Frequently Asked Questions")]/ancestor::section[1] | //*[contains(text(), "Frequently Asked Questions")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s8->length > 0) {
    $items = $xpath->query('.//details | .//*[contains(@class, "elementor-tab-title")] | .//*[contains(@class, "elementor-tab-content")] | .//h3 | .//h4 | .//p', $s8->item(0));
    foreach ($items as $it) {
        $t = trim(preg_replace('/\s+/', ' ', $it->textContent));
        if ($t && $t !== 'Frequently Asked Questions') {
            echo "  FAQ ITEM: $t\n";
        }
    }
}

echo "\n=== 9. WORK WITH A DIGITAL MARKETING CONSULTANT IN DELHI (CTA) ===\n";
$s9 = $xpath->query('//*[contains(text(), "Work With a Digital Marketing Consultant in Delhi")]/ancestor::section[1] | //*[contains(text(), "Work With a Digital Marketing Consultant in Delhi")]/ancestor::div[contains(@class, "elementor-section")][1]');
if ($s9->length > 0) {
    $items = $xpath->query('.//p | .//a', $s9->item(0));
    foreach ($items as $it) {
        echo "  CTA ITEM [" . $it->nodeName . "]: " . trim($it->textContent) . "\n";
    }
}

