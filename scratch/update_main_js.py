with open('js/main.js', 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update applySharedContactDetails
old_apply = """function applySharedContactDetails() {
  document.querySelectorAll('a[href^="mailto:"]').forEach((link) => {
    link.href = `mailto:${SITE_CONTACT_CONFIG.email}`;
    const text = link.querySelector('span') || link;
    if (text.textContent.trim().includes('@')) text.textContent = SITE_CONTACT_CONFIG.email;
  });
  document.querySelectorAll('a[href^="tel:"]').forEach((link) => {
    link.href = `tel:${SITE_CONTACT_CONFIG.phoneNumber}`;
    const text = link.querySelector('span') || link;
    if (/\d/.test(text.textContent)) text.textContent = SITE_CONTACT_CONFIG.displayPhone;
  });"""

new_apply = """function applySharedContactDetails() {
  document.querySelectorAll('a[href^="mailto:"]').forEach((link) => {
    link.href = `mailto:${SITE_CONTACT_CONFIG.email}`;
    const span = link.querySelector('span');
    if (span) {
      if (span.textContent.trim().includes('@')) span.textContent = SITE_CONTACT_CONFIG.email;
    } else {
      let replaced = false;
      link.childNodes.forEach((node) => {
        if (!replaced && node.nodeType === Node.TEXT_NODE && node.textContent.includes('@')) {
          node.textContent = ` ${SITE_CONTACT_CONFIG.email}`;
          replaced = true;
        }
      });
    }
  });
  document.querySelectorAll('a[href^="tel:"]').forEach((link) => {
    link.href = `tel:${SITE_CONTACT_CONFIG.phoneNumber}`;
    const span = link.querySelector('span');
    if (span) {
      if (/\d/.test(span.textContent)) span.textContent = SITE_CONTACT_CONFIG.displayPhone;
    } else {
      let replaced = false;
      link.childNodes.forEach((node) => {
        if (!replaced && node.nodeType === Node.TEXT_NODE && /\d/.test(node.textContent)) {
          node.textContent = ` ${SITE_CONTACT_CONFIG.displayPhone}`;
          replaced = true;
        }
      });
    }
  });"""

assert old_apply in content, "old_apply not found!"
content = content.replace(old_apply, new_apply, 1)

# 2. Update initFloatingContactActions
old_float = "if (document.getElementById('rs-floating-actions')) return;"
new_float = "if (document.getElementById('rs-floating-actions') || document.querySelector('.floating-actions-container') || document.querySelector('.floating-actions')) return;"
assert old_float in content, "old_float not found!"
content = content.replace(old_float, new_float, 1)

# 3. Update initHeaderTopBar status text
old_top_text = "<span>Available for Q1/Q2 Advisory Engagements</span>"
new_top_text = "<span>Available for Q1 Consulting & Growth Audits</span>"
assert old_top_text in content, "old_top_text not found!"
content = content.replace(old_top_text, new_top_text, 1)

with open('js/main.js', 'w', encoding='utf-8') as f:
    f.write(content)

print("js/main.js updated successfully.")
