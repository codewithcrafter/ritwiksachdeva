/**
 * ADVANCED INTERACTIONS & MICRO-EXPERIENCES
 * - Custom desktop cursor with magnetic interaction
 * - Premium testimonial slider carousel
 * - Interactive FAQ accordion
 * - Client-side contact form validation & direct mailto/WhatsApp dispatch
 */

document.addEventListener('DOMContentLoaded', () => {
  initCustomCursor();
  initMagneticButtons();
  initTestimonialSlider();
  initFaqAccordion();
  initContactForm();
  prefillServiceFromUrl();
});

/**
 * Automatically selects service dropdown based on ?service=... URL parameter
 */
function prefillServiceFromUrl() {
  const urlParams = new URLSearchParams(window.location.search);
  const serviceParam = urlParams.get('service');
  const serviceSelect = document.getElementById('client-service');

  if (serviceParam && serviceSelect) {
    for (let i = 0; i < serviceSelect.options.length; i++) {
      if (serviceSelect.options[i].value === serviceParam) {
        serviceSelect.selectedIndex = i;
        break;
      }
    }
  }
}

/**
 * 1. Custom Animated Cursor for Desktop
 */
function initCustomCursor() {
  // Only activate on pointer devices with fine control (desktops/laptops)
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const cursorDot = document.createElement('div');
  const cursorRing = document.createElement('div');

  cursorDot.className = 'custom-cursor-dot';
  cursorRing.className = 'custom-cursor-ring';

  document.body.appendChild(cursorDot);
  document.body.appendChild(cursorRing);

  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;
  let ringX = mouseX;
  let ringY = mouseY;
  let isMoving = false;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;

    cursorDot.style.left = `${mouseX}px`;
    cursorDot.style.top = `${mouseY}px`;

    if (!isMoving) {
      isMoving = true;
      cursorDot.style.opacity = '1';
      cursorRing.style.opacity = '1';
    }
  });

  // Smooth lag animation for ring
  function renderCursor() {
    ringX += (mouseX - ringX) * 0.18;
    ringY += (mouseY - ringY) * 0.18;

    cursorRing.style.left = `${ringX}px`;
    cursorRing.style.top = `${ringY}px`;

    requestAnimationFrame(renderCursor);
  }
  requestAnimationFrame(renderCursor);

  // Expand ring when hovering interactive elements
  const hoverables = document.querySelectorAll('a, button, input, select, textarea, .card, .slider-btn');
  hoverables.forEach(el => {
    el.addEventListener('mouseenter', () => cursorRing.classList.add('cursor-active'));
    el.addEventListener('mouseleave', () => cursorRing.classList.remove('cursor-active'));
  });

  document.addEventListener('mouseleave', () => {
    cursorDot.style.opacity = '0';
    cursorRing.style.opacity = '0';
    isMoving = false;
  });
}

/**
 * 2. Magnetic Buttons Effect
 */
function initMagneticButtons() {
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const magneticBtns = document.querySelectorAll('.btn-magnetic, .btn-primary, .slider-btn');

  magneticBtns.forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      // Subtle magnetic attraction
      btn.style.transform = `translate(${x * 0.2}px, ${y * 0.25}px)`;
    });

    btn.addEventListener('mouseleave', () => {
      btn.style.transform = 'translate(0px, 0px)';
      btn.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
      setTimeout(() => {
        btn.style.transition = '';
      }, 400);
    });
  });
}

/**
 * 3. Testimonial Slider Carousel
 */
function initTestimonialSlider() {
  const track = document.querySelector('.testimonial-track');
  const slides = document.querySelectorAll('.testimonial-slide');
  const prevBtn = document.querySelector('.slider-btn.prev');
  const nextBtn = document.querySelector('.slider-btn.next');
  const dotsContainer = document.querySelector('.slider-dots');

  if (!track || slides.length === 0) return;

  let currentIndex = 0;
  const totalSlides = slides.length;
  let autoPlayTimer = null;

  // Build pagination dots
  if (dotsContainer) {
    dotsContainer.innerHTML = '';
    slides.forEach((_, idx) => {
      const dot = document.createElement('div');
      dot.className = `slider-dot ${idx === 0 ? 'active' : ''}`;
      dot.setAttribute('aria-label', `Slide ${idx + 1}`);
      dot.addEventListener('click', () => {
        goToSlide(idx);
        resetAutoPlay();
      });
      dotsContainer.appendChild(dot);
    });
  }

  const updateSlider = () => {
    track.style.transform = `translateX(-${currentIndex * 100}%)`;

    // Update dots
    const dots = document.querySelectorAll('.slider-dot');
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentIndex);
    });
  };

  const goToSlide = (index) => {
    currentIndex = (index + totalSlides) % totalSlides;
    updateSlider();
  };

  const nextSlide = () => {
    goToSlide(currentIndex + 1);
  };

  const prevSlide = () => {
    goToSlide(currentIndex - 1);
  };

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      nextSlide();
      resetAutoPlay();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      prevSlide();
      resetAutoPlay();
    });
  }

  // Auto-play timer
  const startAutoPlay = () => {
    autoPlayTimer = setInterval(nextSlide, 7000);
  };

  const resetAutoPlay = () => {
    clearInterval(autoPlayTimer);
    startAutoPlay();
  };

  // Pause on hover
  const sliderWrap = document.querySelector('.testimonial-track-container');
  if (sliderWrap) {
    sliderWrap.addEventListener('mouseenter', () => clearInterval(autoPlayTimer));
    sliderWrap.addEventListener('mouseleave', startAutoPlay);
  }

  // Touch Swipe Support
  let touchStartX = 0;
  let touchEndX = 0;

  track.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  track.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    if (touchStartX - touchEndX > 50) {
      nextSlide();
      resetAutoPlay();
    } else if (touchEndX - touchStartX > 50) {
      prevSlide();
      resetAutoPlay();
    }
  }, { passive: true });

  startAutoPlay();
}

/**
 * 4. FAQ Accordion
 */
function initFaqAccordion() {
  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const questionBtn = item.querySelector('.faq-question');
    if (!questionBtn) return;

    questionBtn.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      // Close all other items for a clean accordion effect
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('active');
          const otherBtn = otherItem.querySelector('.faq-question');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        }
      });

      // Toggle current
      if (isActive) {
        item.classList.remove('active');
        questionBtn.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('active');
        questionBtn.setAttribute('aria-expanded', 'true');
      }
    });
  });
}

/**
 * 5. Contact Form Validation & Multi-Option Dispatch
 */
function initContactForm() {
  const contactForm = document.getElementById('consultation-inquiry-form');
  const modalOverlay = document.getElementById('contact-success-modal');
  const closeModalBtns = document.querySelectorAll('.modal-close-trigger');

  if (!contactForm) return;

  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    let isValid = true;

    // Elements
    const nameInput = document.getElementById('client-name');
    const emailInput = document.getElementById('client-email');
    const messageInput = document.getElementById('client-message');
    const serviceInput = document.getElementById('client-service');
    const budgetInput = document.getElementById('client-budget');
    const companyInput = document.getElementById('client-company');
    const phoneInput = document.getElementById('client-phone');

    // Validation helper
    const validateField = (input, condition) => {
      if (!condition) {
        input.classList.add('is-invalid');
        isValid = false;
      } else {
        input.classList.remove('is-invalid');
      }
    };

    // 1. Name validation
    validateField(nameInput, nameInput.value.trim().length >= 2);

    // 2. Email validation (RFC-compliant regex pattern)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    validateField(emailInput, emailRegex.test(emailInput.value.trim()));

    // 3. Message validation
    validateField(messageInput, messageInput.value.trim().length >= 10);

    // 4. Service validation
    if (serviceInput) {
      validateField(serviceInput, serviceInput.value !== '');
    }

    if (!isValid) {
      const firstInvalid = contactForm.querySelector('.is-invalid');
      if (firstInvalid) firstInvalid.focus();
      return;
    }

    // Gather form data
    const formData = {
      name: nameInput.value.trim(),
      email: emailInput.value.trim(),
      phone: phoneInput ? phoneInput.value.trim() : 'Not provided',
      company: companyInput ? companyInput.value.trim() : 'Not provided',
      service: serviceInput ? serviceInput.options[serviceInput.selectedIndex].text : 'General Consulting',
      budget: budgetInput ? budgetInput.options[budgetInput.selectedIndex].text : 'To be discussed',
      message: messageInput.value.trim()
    };

    // Format for WhatsApp & Mailto
    const subject = encodeURIComponent(`Consulting Inquiry: ${formData.service} - ${formData.company}`);
    const emailBody = encodeURIComponent(
      `Hi Ritwik,\n\nI would like to discuss a marketing consulting engagement.\n\n` +
      `Name: ${formData.name}\n` +
      `Company: ${formData.company}\n` +
      `Email: ${formData.email}\n` +
      `Phone: ${formData.phone}\n` +
      `Service Needed: ${formData.service}\n` +
      `Estimated Monthly Budget: ${formData.budget}\n\n` +
      `Project Scope & Growth Goals:\n${formData.message}\n\n` +
      `Looking forward to connecting!`
    );

    const waText = encodeURIComponent(
      `*New Consulting Inquiry*\n\n` +
      `*Name:* ${formData.name}\n` +
      `*Company:* ${formData.company}\n` +
      `*Service:* ${formData.service}\n` +
      `*Budget:* ${formData.budget}\n` +
      `*Email:* ${formData.email}\n\n` +
      `*Message:* ${formData.message}`
    );

    // Disable submit button during dispatch
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = 'Submitting Strategic Inquiry...';
    }

    // Submit asynchronously to CRM backend
    fetch('api/contact.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        name: formData.name,
        email: formData.email,
        phone: formData.phone === 'Not provided' ? '' : formData.phone,
        company: formData.company === 'Not provided' ? '' : formData.company,
        service: formData.service,
        budget: formData.budget === 'To be discussed' ? '' : formData.budget,
        message: formData.message
      })
    })
    .then(res => res.json())
    .then(data => {
      // In either case, show the modal with mailto & whatsapp fallback
      showConfirmationModal();
    })
    .catch(err => {
      console.warn('CRM sync notice (fallback to client modal):', err);
      showConfirmationModal();
    })
    .finally(() => {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
      }
      contactForm.reset();
    });

    function showConfirmationModal() {
      // Update modal action links
      const mailtoBtn = document.getElementById('modal-mailto-btn');
      const whatsappBtn = document.getElementById('modal-whatsapp-btn');
      const summaryClientName = document.getElementById('modal-client-name');

      if (summaryClientName) {
        summaryClientName.textContent = formData.name;
      }

      if (mailtoBtn) {
        mailtoBtn.href = `mailto:consult@ritwiksachdeva.com?subject=${subject}&body=${emailBody}`;
      }

      if (whatsappBtn) {
        // Editable WhatsApp placeholder number
        whatsappBtn.href = `https://wa.me/919876543210?text=${waText}`;
      }

      // Show confirmation modal
      if (modalOverlay) {
        modalOverlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }
    }
  });

  // Modal close handlers
  if (modalOverlay) {
    closeModalBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        modalOverlay.classList.remove('is-open');
        document.body.style.overflow = '';
      });
    });

    modalOverlay.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.classList.remove('is-open');
        document.body.style.overflow = '';
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modalOverlay.classList.contains('is-open')) {
        modalOverlay.classList.remove('is-open');
        document.body.style.overflow = '';
      }
    });
  }
}
