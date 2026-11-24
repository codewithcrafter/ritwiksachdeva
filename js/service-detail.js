/**
 * RITWIK SACHDEVA — SERVICE DETAIL SCRIPTS (js/service-detail.js)
 * Clean, lightweight Vanilla JS for:
 * 1. Deliverables category tab filtering
 * 2. 2-column FAQ accordion expand/collapse
 * 3. Hero inline form AJAX submission with source attribution
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Deliverable Filter Tabs
  const tabButtons = document.querySelectorAll('.sd-tab-btn');
  const deliverableCards = document.querySelectorAll('.sd-deliv-card');

  if (tabButtons.length > 0 && deliverableCards.length > 0) {
    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        tabButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.getAttribute('data-filter') || 'all';

        deliverableCards.forEach(function (card) {
          const category = card.getAttribute('data-category') || 'all';
          if (filter === 'all' || category === filter || category === 'all') {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  }

  // 2. 2-Column Accordion FAQ Toggle
  const faqTriggers = document.querySelectorAll('.sd-faq-trigger');
  faqTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      const item = trigger.closest('.sd-faq-item');
      if (!item) return;

      const wasActive = item.classList.contains('active');

      // Optional: close other open items in the same column
      const siblingItems = item.parentElement.querySelectorAll('.sd-faq-item');
      siblingItems.forEach(sib => sib.classList.remove('active'));

      if (!wasActive) {
        item.classList.add('active');
      }
    });
  });

  // 3. Hero Inline Form AJAX Submission
  const inlineForm = document.querySelector('.sd-hero-inline-form');
  if (inlineForm) {
    inlineForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const submitBtn = inlineForm.querySelector('.sd-submit-btn');
      const feedback = inlineForm.querySelector('.sd-form-feedback');
      const origBtnText = submitBtn ? submitBtn.innerHTML : 'Request Consultation';

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Sending...';
      }

      if (feedback) {
        feedback.className = 'sd-form-feedback';
        feedback.style.display = 'none';
      }

      const formData = new FormData(inlineForm);

      // Ensure source_page and source_trigger are captured
      if (!formData.get('source_page')) {
        formData.append('source_page', window.location.pathname);
      }
      if (!formData.get('source_trigger')) {
        formData.append('source_trigger', 'Hero Inline Form');
      }
      if (!formData.get('form_type')) {
        formData.append('form_type', 'inline_hero');
      }

      fetch(inlineForm.getAttribute('action') || '/consult-submit.php', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(function (res) {
        return res.json().catch(() => ({ success: res.ok, message: 'Message sent successfully.' }));
      })
      .then(function (data) {
        if (data.success) {
          if (feedback) {
            feedback.className = 'sd-form-feedback success';
            feedback.innerHTML = '<strong>Request Received!</strong> Ritwik will review your inquiry and connect with you within 24 hours.';
            feedback.style.display = 'block';
          }
          inlineForm.reset();
        } else {
          if (feedback) {
            feedback.className = 'sd-form-feedback error';
            feedback.innerHTML = data.message || 'Something went wrong. Please try again or WhatsApp directly.';
            feedback.style.display = 'block';
          }
        }
      })
      .catch(function () {
        if (feedback) {
          feedback.className = 'sd-form-feedback error';
          feedback.innerHTML = 'Connection error. Please try again or message via WhatsApp.';
          feedback.style.display = 'block';
        }
      })
      .finally(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origBtnText;
        }
      });
    });
  }
});
