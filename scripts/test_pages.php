<?php
$pages = [
  'services.html',
  'service-fractional-cmo.html',
  'service-brand-strategy.html',
  'service-performance-marketing.html',
  'service-seo-consulting.html',
  'service-b2b-lead-generation.html',
  'service-content-marketing.html',
  'service-marketing-analytics.html'
];
foreach ($pages as $p) {
  $ctx = stream_context_create(['http' => ['ignore_errors' => true]]);
  $content = file_get_contents('http://localhost:8000/' . $p, false, $ctx);
  $status = $http_response_header[0] ?? 'UNKNOWN';
  echo "$p => $status (" . strlen($content) . " bytes)\n";
}

