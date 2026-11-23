import json
import os
import re

# We will import our shared layout renderer
from scratch.shared_layout import render_header, render_mobile_drawer, render_footer

def build_faq_html(faqs):
    items = []
    for idx, faq in enumerate(faqs):
        is_first = ' is-active active' if idx == 0 else ''
        aria_exp = 'true' if idx == 0 else 'false'
        q = faq['q'].replace('⌄', '').strip()
        a = faq['a'].strip()
        items.append(f"""        <div class="faq-item{is_first}">
          <button class="faq-question" aria-expanded="{aria_exp}">
            <span>{q}</span>
            <svg class="faq-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
          </button>
          <div class="faq-answer">
            <p>{a}</p>
          </div>
        </div>""")
    return '\n'.join(items)

def build_metrics_html(metrics):
    blocks = []
    for m in metrics:
        blocks.append(f"""        <div class="stat-item-block">
          <div class="stat-item-val">{m['val']}</div>
          <div class="stat-item-lbl">{m['lbl']}</div>
        </div>""")
    return '\n'.join(blocks)

def build_related_html(related_files):
    from scratch.shared_layout import SERVICES_NAV
    nav_map = {item['file']: item for item in SERVICES_NAV}
    cards = []
    for f in related_files:
        if f in nav_map:
            item = nav_map[f]
            cards.append(f"""        <div class="deliverable-card" style="box-shadow: 3px 3px 0 #0F172A;">
          <div class="deliverable-header">
            <span class="deliverable-num">{item['num']}</span>
            <span class="deliverable-tag">Specialized Practice</span>
          </div>
          <h3 class="deliverable-title">{item['title']}</h3>
          <p class="deliverable-text">{item['desc']}</p>
          <div style="margin-top: 18px;">
            <a href="{item['file']}" class="btn btn-secondary btn-sm" style="font-weight: 700;">Explore Practice &rarr;</a>
          </div>
        </div>""")
    return '\n'.join(cards)

print("Helper builders ready.")
