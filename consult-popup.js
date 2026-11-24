/**
 * ==========================================================================
 * BOOK A GROWTH CONSULTATION POPUP MODAL (CONTROLLER)
 * Vanilla JS, zero dependencies, accessible, focus-trapped, and responsive.
 * ==========================================================================
 */
(function () {
  'use strict';

  // Elements
  let overlay, modal, backdrop, closeBtn, form, submitBtn, errorBox;
  let formView, successView, successName, whatsappBtn, resetBtn;
  let lastActiveElement = null;
  let isSubmitting = false;
  let autoPopupDismissed = false;
  let currentTriggerText = 'Popup Modal';

  function init() {
    overlay = document.getElementById('consult-popup-overlay');
    if (!overlay) return;

    // The contact page already provides the full contact form, so the timed
    // consultation modal must never appear there.
    const cleanPath = window.location.pathname.toLowerCase().replace(/\/$/, '');
    if (cleanPath === '/contact' || cleanPath.endsWith('/contact.html')) {
      overlay.remove();
      return;
    }

    modal = document.getElementById('consult-popup-modal');
    backdrop = document.getElementById('consult-popup-backdrop');
    closeBtn = document.getElementById('consult-close-btn');
    form = document.getElementById('consult-form');
    submitBtn = document.getElementById('consult-submit-btn');
    errorBox = document.getElementById('consult-error-box');
    formView = document.getElementById('consult-form-view');
    successView = document.getElementById('consult-success-view');
    successName = document.getElementById('consult-success-name');
    whatsappBtn = document.getElementById('consult-whatsapp-btn');
    resetBtn = document.getElementById('consult-reset-btn');

    enhancePopupDesign();

    // Attach trigger listeners
    bindTriggers();
    scheduleFirstVisitPopup();

    // Close actions
    if (closeBtn) closeBtn.addEventListener('click', closePopup);
    if (backdrop) backdrop.addEventListener('click', closePopup);
    if (resetBtn) resetBtn.addEventListener('click', closePopup);

    // Escape key and Focus Trap
    document.addEventListener('keydown', handleKeyDown);

    // Form submission
    if (form) form.addEventListener('submit', handleSubmit);
  }

  /* Some pages still contain an earlier shared-popup copy. Add the visual
     focus selector and proof card around that existing form without changing
     its PHP action, method, hidden inputs, or field names. */
  function enhancePopupDesign() {
    const leftPanel = overlay.querySelector('.rs-popup-left, .consult-panel-left');
    const leftBottom = overlay.querySelector('.rs-popup-left-bottom, .consult-left-bottom');

    if (leftPanel && !leftPanel.querySelector('.rs-popup-proof')) {
      const proof = document.createElement('div');
      proof.className = 'rs-popup-proof';
      proof.setAttribute('aria-label', 'Verified performance result');
      proof.innerHTML = `
        <div class="rs-popup-proof-row">
          <strong>4.6x Blended ROAS</strong>
          <span>Verified</span>
        </div>
        <small>₹50 Cr+ Pipeline Generated · 94% Client Retention</small>`;
      if (leftBottom) {
        leftPanel.insertBefore(proof, leftBottom);
      } else {
        leftPanel.appendChild(proof);
      }
    }

    if (!form || form.querySelector('.rs-popup-focus')) return;

    const focus = document.createElement('div');
    focus.className = 'rs-popup-focus';
    focus.innerHTML = `
      <span class="rs-popup-focus-label">Select Primary Focus:</span>
      <div class="rs-popup-focus-chips" role="group" aria-label="Select primary consultation focus">
        <button type="button" class="rs-popup-chip" aria-pressed="false">Performance Ads</button>
        <button type="button" class="rs-popup-chip" aria-pressed="false">SEO &amp; GEO</button>
        <button type="button" class="rs-popup-chip" aria-pressed="false">E-Commerce</button>
        <button type="button" class="rs-popup-chip is-active" aria-pressed="true">Web &amp; Branding</button>
      </div>`;

    const error = form.querySelector('.rs-popup-error, .consult-error-box');
    if (error) {
      error.insertAdjacentElement('afterend', focus);
    } else {
      form.prepend(focus);
    }

    focus.querySelectorAll('.rs-popup-chip').forEach((chip) => {
      chip.addEventListener('click', () => {
        focus.querySelectorAll('.rs-popup-chip').forEach((item) => {
          item.classList.remove('is-active');
          item.setAttribute('aria-pressed', 'false');
        });
        chip.classList.add('is-active');
        chip.setAttribute('aria-pressed', 'true');
      });
    });
  }

  /**
   * Bind all "Book a Consultation" and .js-open-consult triggers across the page
   */
  function bindTriggers() {
    // Delegated click handler to capture any existing or dynamically created triggers
    document.addEventListener('click', function (e) {
      const trigger = e.target.closest(
        '.js-open-consult, [data-open-popup="consultation"], a[href="#consultation"], a[href="#book"], a[href="#popup"]'
      );

      // Also check if an <a> or <button> has exact or partial text "Book a Consultation"
      let isTextMatch = false;
      const btnOrLink = e.target.closest('a, button');
      if (btnOrLink && !trigger) {
        const text = (btnOrLink.textContent || '').trim().toLowerCase();
        if (text === 'book a consultation' || text === 'request consultation' || text === 'book strategy consultation') {
          isTextMatch = true;
        }
      }

      if (trigger || isTextMatch) {
        e.preventDefault();
        e.stopImmediatePropagation();
        openPopup(btnOrLink || trigger);
      }
    });

    // Check URL parameters or hash on page load
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('consult') === '1' || urlParams.get('popup') === 'consultation' || window.location.hash === '#consultation') {
      setTimeout(function () {
        openPopup();
      }, 500);
    }
  }

  /** Show once five seconds after each page load. A refresh starts a new load;
      closing it suppresses any later automatic open until that refresh. */
  function scheduleFirstVisitPopup() {
    window.setTimeout(function () {
      if (!overlay || autoPopupDismissed || overlay.classList.contains('is-active')) return;
      openPopup();
    }, 5000);
  }

  /**
   * Open the consultation popup
   */
  function openPopup(triggerEl) {
    if (!overlay) return;
    lastActiveElement = triggerEl || document.activeElement;

    if (triggerEl && triggerEl instanceof HTMLElement) {
      const rawText = triggerEl.getAttribute('data-trigger') || triggerEl.innerText || triggerEl.textContent || '';
      currentTriggerText = rawText.trim().replace(/\s+/g, ' ');
      if (currentTriggerText.length > 60) currentTriggerText = currentTriggerText.substring(0, 60);
    } else if (triggerEl === 'timer' || (!triggerEl && !lastActiveElement)) {
      currentTriggerText = 'Auto-Popup (Timer)';
    } else {
      currentTriggerText = 'Popup Modal';
    }

    // Reset previous error state if form still active
    hideError();

    // Lock body scroll with scrollbar compensation
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    if (scrollbarWidth > 0) {
      document.body.style.paddingRight = scrollbarWidth + 'px';
    }
    document.body.style.overflow = 'hidden';

    // Show modal with entry animation
    overlay.classList.add('is-active');
    overlay.setAttribute('aria-hidden', 'false');

    // Move focus to first input
    setTimeout(function () {
      const firstInput = document.getElementById('consult-name');
      if (firstInput && formView && formView.style.display !== 'none') {
        firstInput.focus();
      } else if (closeBtn) {
        closeBtn.focus();
      }
    }, 120);
  }

  /**
   * Close the consultation popup
   */
  function closePopup() {
    if (!overlay || !overlay.classList.contains('is-active')) return;

    autoPopupDismissed = true;

    overlay.classList.remove('is-active');
    overlay.setAttribute('aria-hidden', 'true');

    // Restore body scroll
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';

    // If success state was shown, reset views for next time
    setTimeout(function () {
      resetModalViews();
    }, 350);

    // Return focus to trigger element
    if (lastActiveElement && typeof lastActiveElement.focus === 'function') {
      lastActiveElement.focus();
    }
  }

  /**
   * Reset form and views back to default state
   */
  function resetModalViews() {
    if (form) form.reset();
    hideError();
    if (formView) formView.style.display = 'block';
    if (successView) successView.style.display = 'none';
    setLoading(false);
  }

  /**
   * Handle Keydown (Escape to close, Tab for focus trap)
   */
  function handleKeyDown(e) {
    if (!overlay || !overlay.classList.contains('is-active')) return;

    if (e.key === 'Escape' || e.keyCode === 27) {
      e.preventDefault();
      closePopup();
      return;
    }

    if (e.key === 'Tab' || e.keyCode === 9) {
      trapFocus(e);
    }
  }

  /**
   * Accessible Focus Trap inside the modal
   */
  function trapFocus(e) {
    if (!modal) return;
    const focusableSelectors = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusableElements = Array.prototype.slice.call(
      modal.querySelectorAll(focusableSelectors)
    ).filter(function (el) {
      return el.offsetParent !== null && !el.disabled && el.getAttribute('aria-hidden') !== 'true';
    });

    if (focusableElements.length === 0) return;

    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    if (e.shiftKey) {
      if (document.activeElement === firstElement) {
        e.preventDefault();
        lastElement.focus();
      }
    } else {
      if (document.activeElement === lastElement) {
        e.preventDefault();
        firstElement.focus();
      }
    }
  }

  /**
   * Handle Form Submit via fetch()
   */
  function handleSubmit(e) {
    e.preventDefault();
    if (isSubmitting) return;

    hideError();

    const nameInput = document.getElementById('consult-name');
    const emailInput = document.getElementById('consult-email');
    const phoneInput = document.getElementById('consult-phone');
    const messageInput = document.getElementById('consult-message');

    const name = nameInput ? nameInput.value.trim() : '';
    const email = emailInput ? emailInput.value.trim() : '';
    const phone = phoneInput ? phoneInput.value.trim() : '';
    const message = messageInput ? messageInput.value.trim() : '';

    // Client-side validation
    if (name.length < 2) {
      showError('Please enter your full name (at least 2 characters).');
      if (nameInput) nameInput.focus();
      return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      showError('Please enter a valid business email address.');
      if (emailInput) emailInput.focus();
      return;
    }

    const phoneClean = phone.replace(/[^0-9]/g, '');
    if (phoneClean.length < 7 || phoneClean.length > 15) {
      showError('Please enter a valid contact phone number (7-15 digits).');
      if (phoneInput) phoneInput.focus();
      return;
    }

    // Prepare FormData
    const formData = new FormData(form);

    // Append full lead attribution
    const sourcePage = window.location.pathname + (window.location.search || '');
    formData.set('source_page', sourcePage);
    formData.set('source_trigger', currentTriggerText || 'Popup Modal');
    formData.set('form_type', 'popup');

    const activeChip = overlay.querySelector('.rs-popup-chip.is-active');
    if (activeChip) {
      formData.set('service_focus', activeChip.textContent.trim());
    }

    setLoading(true);

    fetch('/consult-submit.php', {
      method: 'POST',
      body: formData,
      headers: {
        'Accept': 'application/json'
      }
    })
      .then(function (response) {
        return response.json().then(function (data) {
          return { status: response.status, ok: response.ok, data: data };
        }).catch(function () {
          return { status: response.status, ok: response.ok, data: null };
        });
      })
      .then(function (res) {
        setLoading(false);
        if (res.data && res.data.success) {
          showSuccess(name, email, phone, message);
        } else {
          const errMsg = (res.data && res.data.message) ? res.data.message : 'Unable to submit inquiry. Please try again shortly or contact us directly.';
          showError(errMsg);
        }
      })
      .catch(function () {
        setLoading(false);
        showError('Network error. Please check your internet connection and try again.');
      });
  }

  /**
   * Transition to Success State View
   */
  function showSuccess(name, email, phone, message) {
    if (formView) formView.style.display = 'none';
    if (successView) successView.style.display = 'flex';

    if (successName) {
      successName.textContent = name || 'there';
    }

    // Set WhatsApp inquiry link with prefilled details
    if (whatsappBtn) {
      const waText = `Hello Ritwik, I have submitted a growth consultation inquiry on your website.\n\n*Name:* ${name}\n*Email:* ${email}\n*Phone:* ${phone}\n*Goals/Message:* ${message}`;
      whatsappBtn.href = 'https://wa.me/919289626986?text=' + encodeURIComponent(waText);
    }
  }

  /**
   * Set button loading state
   */
  function setLoading(isLoading) {
    isSubmitting = isLoading;
    if (!submitBtn) return;

    const btnText = submitBtn.querySelector('.rs-popup-btn-text, .consult-btn-text');
    const btnArrow = submitBtn.querySelector('.rs-popup-btn-arrow, .consult-btn-arrow');
    const btnLoading = submitBtn.querySelector('.rs-popup-btn-loading, .consult-btn-loading');

    if (isLoading) {
      submitBtn.disabled = true;
      if (btnText) btnText.style.display = 'none';
      if (btnArrow) btnArrow.style.display = 'none';
      if (btnLoading) btnLoading.style.display = 'inline-flex';
    } else {
      submitBtn.disabled = false;
      if (btnText) btnText.style.display = '';
      if (btnArrow) btnArrow.style.display = '';
      if (btnLoading) btnLoading.style.display = 'none';
    }
  }

  function showError(msg) {
    if (!errorBox) return;
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
  }

  function hideError() {
    if (!errorBox) return;
    errorBox.textContent = '';
    errorBox.style.display = 'none';
  }

  // Expose global methods
  window.openConsultationPopup = openPopup;
  window.closeConsultationPopup = closePopup;

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
