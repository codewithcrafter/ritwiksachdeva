<?php
$cssFile = __DIR__ . '/../css/best-consultant-live.css';
$css = file_get_contents($cssFile);

$customBlock = <<<'CSS'

/* ==========================================================================
   ENHANCED STYLES: DIGITAL MARKETING RESULTS + STRATEGY CALL + IMPACT COUNTERS
   ========================================================================== */

/* Navbar offset */
.best-consultant-main {
  padding-top: 80px;
}
.marketing-hero-wrap {
  padding-top: 40px !important;
}

/* Proven Digital Impact Section */
.impact-section {
  width: 100%;
  padding: 80px 20px;
  background: linear-gradient(135deg, #0b1020, #03050a);
  color: #fff;
  overflow: hidden;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
  text-align: center;
}
.impact-container {
  max-width: 1200px;
  margin: 0 auto;
}
.impact-title {
  font-size: clamp(2rem, 3.8vw, 2.75rem);
  font-weight: 800;
  margin: 0 0 14px;
  color: #f1f5f9;
}
.impact-subtitle {
  font-size: 1.05rem;
  color: #94a3b8;
  max-width: 650px;
  margin: 0 auto 50px;
  line-height: 1.6;
}
.impact-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.impact-card {
  padding: 44px 30px;
  border-radius: 22px;
  background: linear-gradient(180deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 25px 55px rgba(0, 0, 0, 0.4);
  transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
}
.impact-card:hover {
  transform: translateY(-8px);
  border-color: rgba(99, 102, 241, 0.4);
  box-shadow: 0 30px 65px rgba(79, 70, 229, 0.3);
}
.impact-number {
  font-size: clamp(2.8rem, 4.5vw, 3.5rem);
  font-weight: 900;
  margin: 0 0 10px;
  display: flex;
  align-items: baseline;
  justify-content: center;
  line-height: 1;
}
.impact-number .counter {
  background: linear-gradient(135deg, #6366f1, #a5b4fc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-variant-numeric: tabular-nums;
}
.impact-number .unit {
  font-size: clamp(1.8rem, 2.5vw, 2.2rem);
  font-weight: 800;
  color: #a5b4fc;
  margin-left: 4px;
}
.impact-text {
  font-size: 0.98rem;
  color: #cbd5e1;
  margin: 0;
  font-weight: 500;
}

/* Digital Marketing Results That Speak for Themselves Section (Matching Image 1) */
.results-stats-section {
  background: #ffffff;
  padding: 90px 24px;
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
.results-stats-container {
  max-width: 960px;
  margin: 0 auto;
  text-align: center;
}
.results-stats-title {
  font-size: clamp(2.1rem, 4vw, 2.85rem);
  font-weight: 800;
  color: #111827;
  letter-spacing: -0.03em;
  margin: 0 0 18px;
  line-height: 1.2;
}
.results-stats-subtitle {
  font-size: 16px;
  line-height: 1.75;
  color: #64748b;
  max-width: 820px;
  margin: 0 auto 55px;
}
.results-stats-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  max-width: 820px;
  margin: 0 auto;
}
.results-stat-box {
  padding: 38px 24px;
  text-align: center;
}
.stat-border-right {
  border-right: 1px solid #e2e8f0;
}
.stat-border-bottom {
  border-bottom: 1px solid #e2e8f0;
}
.stat-number-wrapper {
  display: flex;
  align-items: baseline;
  justify-content: center;
  font-size: clamp(3.2rem, 5.5vw, 4.4rem);
  font-weight: 300;
  line-height: 1;
  color: #e91e63;
  margin-bottom: 12px;
}
.stat-number-wrapper .stat-number {
  font-variant-numeric: tabular-nums;
  color: #e91e63;
}
.stat-number-wrapper .stat-suffix {
  font-size: clamp(2.2rem, 4vw, 3rem);
  font-weight: 300;
  color: #e91e63;
  margin-left: 2px;
}
.stat-label {
  font-size: 15px;
  font-weight: 500;
  color: #334155;
  line-height: 1.4;
}

/* Schedule Strategy Call Section (Matching Image 2) */
.strategy-call-section {
  width: 100%;
  background: radial-gradient(circle at 15% 45%, #181d38 0%, #0c0f1c 100%);
  padding: 100px 24px;
  position: relative;
  color: #fff;
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
.strategy-call-container {
  max-width: 1200px;
  margin: 0 auto;
}
.strategy-call-grid {
  display: grid;
  grid-template-columns: 1.15fr 1fr;
  gap: 60px;
  align-items: center;
}
.strategy-call-title {
  font-size: clamp(2.2rem, 4.5vw, 3.25rem);
  font-weight: 800;
  line-height: 1.15;
  color: #ffffff;
  letter-spacing: -0.025em;
  margin: 0 0 22px;
}
.strategy-call-desc {
  font-size: 16px;
  line-height: 1.75;
  color: #94a3b8;
  max-width: 480px;
  margin: 0;
}
.strategy-call-card {
  background: rgba(22, 27, 46, 0.75);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 24px;
  padding: 44px 38px;
  box-shadow: 0 30px 65px -15px rgba(0, 0, 0, 0.6);
}
.strategy-booking-form {
  display: flex;
  flex-direction: column;
}
.strategy-form-group {
  margin-bottom: 22px;
  text-align: left;
}
.strategy-form-label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #e2e8f0;
  margin-bottom: 8px;
}
.strategy-form-label .required-star {
  color: #ef4444;
  margin-left: 2px;
}
.strategy-form-input,
.strategy-form-textarea {
  width: 100%;
  box-sizing: border-box;
  background: #141829;
  border: 1px solid #28314e;
  border-radius: 12px;
  color: #f8fafc;
  padding: 14px 18px;
  font-size: 15px;
  outline: none;
  font-family: inherit;
  transition: border-color 0.25s, box-shadow 0.25s, background-color 0.25s;
}
.strategy-form-input::placeholder,
.strategy-form-textarea::placeholder {
  color: #64748b;
}
.strategy-form-input:focus,
.strategy-form-textarea:focus {
  border-color: #6366f1;
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
  background: #171c32;
}
.strategy-form-textarea {
  min-height: 120px;
  resize: vertical;
}
.strategy-form-actions {
  margin-top: 6px;
  text-align: left;
}
.strategy-submit-btn {
  background: linear-gradient(135deg, #6366f1, #4f46e5);
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  padding: 14px 44px;
  border-radius: 9999px;
  border: none;
  cursor: pointer;
  box-shadow: 0 8px 24px -4px rgba(99, 102, 241, 0.5);
  transition: transform 0.2s, box-shadow 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.strategy-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px -4px rgba(99, 102, 241, 0.7);
}

/* Mobile Responsive */
@media (max-width: 900px) {
  .impact-grid {
    grid-template-columns: 1fr;
  }
  .strategy-call-grid {
    grid-template-columns: 1fr;
    gap: 40px;
  }
}
@media (max-width: 640px) {
  .results-stats-grid {
    grid-template-columns: 1fr;
  }
  .stat-border-right {
    border-right: none;
  }
  .results-stat-box {
    border-bottom: 1px solid #e2e8f0;
  }
  .strategy-call-card {
    padding: 30px 20px;
  }
}
CSS;

// Remove any existing ENHANCED STYLES block if present
if (strpos($css, 'ENHANCED STYLES: DIGITAL MARKETING RESULTS') !== false) {
    $css = preg_replace('/\/\* ===+ ENHANCED STYLES.*?$/s', '', $css);
}

$css .= "\n" . $customBlock;
file_put_contents($cssFile, $css);
echo "Appended enhanced styles to " . basename($cssFile) . " (" . strlen($css) . " bytes)\n";


