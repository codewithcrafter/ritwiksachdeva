-- ============================================================================
-- RITWIK SACHDEVA - DATABASE INITIAL SEED DATA
-- Default administrator, roles, permissions, categories, tags, author,
-- 5 comprehensive dummy blogs, sample CRM leads, and website settings.
-- ============================================================================

USE `ritwik_cms_db`;

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------------------------------------------------------
-- 1. INSERT ROLES
-- ----------------------------------------------------------------------------
INSERT INTO `roles` (`id`, `name`, `display_name`, `description`) VALUES
(1, 'SUPER_ADMIN', 'Super Administrator', 'Unrestricted administrative control across all CMS and CRM systems.'),
(2, 'EDITOR', 'Content Editor', 'Manage, author, edit, and publish blogs, media, and categories.'),
(3, 'LEAD_MANAGER', 'Lead & CRM Manager', 'Manage incoming contact inquiries, lead statuses, notes, and follow-ups.');

-- ----------------------------------------------------------------------------
-- 2. INSERT PERMISSIONS
-- ----------------------------------------------------------------------------
INSERT INTO `permissions` (`id`, `name`, `module`, `description`) VALUES
(1, 'blogs.view', 'blogs', 'View blog listings and drafts'),
(2, 'blogs.create', 'blogs', 'Create new blog posts'),
(3, 'blogs.edit', 'blogs', 'Edit existing blog posts'),
(4, 'blogs.delete', 'blogs', 'Delete blog posts'),
(5, 'blogs.publish', 'blogs', 'Publish or schedule blog posts'),
(6, 'categories.manage', 'categories', 'Create and edit categories'),
(7, 'tags.manage', 'tags', 'Create and edit tags'),
(8, 'leads.view', 'leads', 'View CRM contact inquiries'),
(9, 'leads.edit', 'leads', 'Update lead status and follow-ups'),
(10, 'leads.notes', 'leads', 'Add internal notes to leads'),
(11, 'leads.export', 'leads', 'Export leads to CSV'),
(12, 'media.upload', 'media', 'Upload files to media library'),
(13, 'media.delete', 'media', 'Delete files from media library'),
(14, 'seo.manage', 'seo', 'Manage SEO and structured data'),
(15, 'users.manage', 'users', 'Manage admin users and permissions'),
(16, 'settings.manage', 'settings', 'Update site configurations and integrations');

-- ----------------------------------------------------------------------------
-- 3. ASSIGN PERMISSIONS TO ROLES
-- ----------------------------------------------------------------------------
-- Super Admin has all permissions (1 to 16)
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`)
SELECT 1, `id` FROM `permissions`;

-- Editor has blog, category, tag, media, and SEO permissions
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`) VALUES
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6), (2, 7), (2, 12), (2, 13), (2, 14);

-- Lead Manager has CRM permissions
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`) VALUES
(3, 8), (3, 9), (3, 10), (3, 11);

-- ----------------------------------------------------------------------------
-- 4. INSERT DEFAULT ADMINISTRATOR
-- Default credentials: admin@ritwiksachdeva.com / Admin@2026!
-- ----------------------------------------------------------------------------
INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`, `role_id`, `avatar`, `status`) VALUES
(1, 'Ritwik Sachdeva', 'admin@ritwiksachdeva.com', '$2y$12$daaRcVsl7UO5589u6tLmdO1z1bGSQTxx6EfDm5V/tHCJtIRYUVeJy', 1, 'assets/images/about-consultant.svg', 'active'),
(2, 'Sarah Jenkins', 'editor@ritwiksachdeva.com', '$2y$12$daaRcVsl7UO5589u6tLmdO1z1bGSQTxx6EfDm5V/tHCJtIRYUVeJy', 2, 'assets/images/avatar-2.svg', 'active'),
(3, 'Marcus Vance', 'crm@ritwiksachdeva.com', '$2y$12$daaRcVsl7UO5589u6tLmdO1z1bGSQTxx6EfDm5V/tHCJtIRYUVeJy', 3, 'assets/images/avatar-1.svg', 'active');

-- ----------------------------------------------------------------------------
-- 5. INSERT AUTHOR
-- ----------------------------------------------------------------------------
INSERT INTO `blog_authors` (`id`, `name`, `slug`, `title`, `bio`, `avatar`, `email`, `social_links`) VALUES
(1, 'Ritwik Sachdeva', 'ritwik-sachdeva', 'Senior Business & Marketing Consultant', 'Over a decade of experience advising enterprise leaders and venture-backed scaleups on digital growth, performance marketing economics, and organizational transformation.', 'assets/images/about-consultant.svg', 'consult@ritwiksachdeva.com', '{"linkedin": "https://linkedin.com", "twitter": "https://twitter.com", "substack": "https://substack.com"}');

-- ----------------------------------------------------------------------------
-- 6. INSERT CATEGORIES
-- ----------------------------------------------------------------------------
INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Business Strategy', 'business-strategy', 'Actionable frameworks for sustainable commercial scale, unit economics, and competitive moats.'),
(2, 'Digital Transformation', 'digital-transformation', 'Modernizing enterprise technology stacks, operational workflows, and data governance.'),
(3, 'Leadership & Growth', 'leadership-growth', 'Executive decision-making, team culture, and entrepreneurial management principles.'),
(4, 'Artificial Intelligence', 'artificial-intelligence', 'Pragmatic enterprise adoption of AI, predictive analytics, and workflow automation.'),
(5, 'Performance Marketing', 'performance-marketing', 'Full-funnel customer acquisition, paid media optimization, and attribution architectures.');

-- ----------------------------------------------------------------------------
-- 7. INSERT TAGS
-- ----------------------------------------------------------------------------
INSERT INTO `blog_tags` (`id`, `name`, `slug`) VALUES
(1, 'Strategy', 'strategy'),
(2, 'Digital Transformation', 'digital-transformation'),
(3, 'Leadership', 'leadership'),
(4, 'AI & Automation', 'ai-automation'),
(5, 'Marketing', 'marketing'),
(6, 'B2B Growth', 'b2b-growth'),
(7, 'ROI & Metrics', 'roi-metrics'),
(8, 'Innovation', 'innovation'),
(9, 'Consulting', 'consulting');

-- ----------------------------------------------------------------------------
-- 8. INSERT 5 REALISTIC PUBLISHED BLOGS
-- ----------------------------------------------------------------------------

-- Blog 1: Digital Transformation Strategies for Modern Businesses
INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `featured_image_alt`, `category_id`, `author_id`, `status`, `is_featured`, `reading_time`, `published_at`, `markdown_file_path`, `views_count`, `meta_title`, `meta_description`, `canonical_url`, `og_image`, `schema_type`, `created_by`, `updated_by`) VALUES
(1,
'Digital Transformation Strategies for Modern Businesses',
'digital-transformation-strategies',
'Discover actionable methodologies to modernize legacy operations, foster organizational agility, and unlock sustainable competitive advantages through digital transformation.',
'## The Imperative for Digital Evolution

In an era defined by rapid technological acceleration, digital transformation is no longer a discretionary luxury—it is an existential commercial necessity. Traditional business models that rely on fragmented legacy software and manual operational bottlenecks are increasingly vulnerable to agile competitors who leverage integrated data ecosystems.

True digital transformation goes far beyond simply moving workloads to the cloud or introducing modern collaboration tools. It demands a holistic reimagining of how value is created, delivered, and captured across the entire organizational value chain.

---

## 1. Establishing Strategic Alignment Before Technology Selection

The most common pitfall in enterprise digital initiatives is treating transformation as an IT project rather than a strategic business imperative. Before evaluating enterprise software vendors or cloud platforms, executive leadership must answer three foundational questions:

1. **What commercial friction point are we eliminating for our customers?**
2. **How does this technological change improve our unit economics and operational margins?**
3. **Does our existing organizational structure support cross-functional data transparency?**

When strategic outcomes dictate technological investments—rather than the reverse—organizations avoid costly implementation delays and ensure measurable return on investment (ROI).

```text
Strategic Vision -> Process Simplification -> Technology Architecture -> Team Enablement
```

---

## 2. Breaking Down Data Silos and Unifying Customer Intelligence

Legacy enterprises frequently suffer from departmental fragmentation. Marketing operates in one database, sales pipeline is trapped in isolated CRM views, and fulfillment data resides in on-premise ERP software.

To compete in contemporary digital markets, businesses must establish a **single source of truth**. Centralized data lakes and real-time API integrations empower leadership teams to track customer lifetime value (LTV), identify churn risks proactively, and optimize resource allocation with statistical confidence.

### Key Milestones in Data Consolidation:
- **Audit Existing Architecture:** Map all data touchpoints across customer-facing and back-office systems.
- **Implement Modern Middleware:** Utilize secure REST APIs and event-driven architectures to enable seamless data exchange.
- **Standardize KPI Definitions:** Ensure that customer acquisition cost (CAC), pipeline velocity, and churn are calculated consistently across all business units.

---

## 3. Cultivating a Culture of Agile Experimentation

Technology is only as effective as the human beings tasked with operating it. Successful digital leaders prioritize change management and continuous upskilling over rigid top-down mandates.

By instituting bi-weekly sprint cadences and encouraging calculated experimentation, companies foster psychological safety. Teams feel empowered to test automated workflows, refine customer journey touchpoints, and eliminate redundant operational friction without fear of failure.

---

## Conclusion: Engineering Sustainable Competitive Moats

Digital transformation is not a finite project with a fixed conclusion—it is an enduring organizational discipline. Businesses that embrace continuous architectural refinement, data transparency, and strategic customer-centricity will dominate their categories for the decade ahead.',
'assets/images/insight-1.svg',
'Digital Transformation Strategies for Modern Enterprises',
2, 1, 'published', 1, 7, '2026-11-01 09:00:00',
'content/blogs/digital-transformation-strategies.md',
428,
'Digital Transformation Strategies for Modern Businesses | Ritwik Sachdeva',
'Discover actionable methodologies to modernize legacy operations, foster organizational agility, and unlock sustainable competitive advantages.',
'https://www.ritwiksachdeva.in/blog/digital-transformation-strategies/',
'assets/images/insight-1.svg',
'BlogPosting', 1, 1);

-- Blog 2: How to Build a Successful Business Growth Strategy
INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `featured_image_alt`, `category_id`, `author_id`, `status`, `is_featured`, `reading_time`, `published_at`, `markdown_file_path`, `views_count`, `meta_title`, `meta_description`, `canonical_url`, `og_image`, `schema_type`, `created_by`, `updated_by`) VALUES
(2,
'How to Build a Successful Business Growth Strategy',
'business-growth-strategy',
'A rigorous, step-by-step framework for executive leaders to clarify category positioning, establish scalable acquisition funnels, and protect profit margins.',
'## Moving Beyond Hope as a Growth Strategy

Many founders and executives mistake heightened activity for strategic growth. Launching new marketing campaigns, expanding headcount prematurely, or discounting prices to acquire market share may temporarily inflate top-line revenue, but it frequently destroys operating margins.

A sustainable business growth strategy is an integrated set of choices that uniquely positions a company to deliver superior customer value at healthy economics.

---

## 1. Deep Market Segmentation and Customer Problem Mapping

Growth begins with radical focus. Companies that attempt to appeal to everyone inevitably dilute their value proposition and exhaust their working capital. 

Effective growth leaders segment their addressable market by **urgency of need** and **willingness to pay**:

- **Tier 1 (High Pain, High Budget):** The core target whose operational bottlenecks cost them hundreds of thousands of dollars annually.
- **Tier 2 (Moderate Pain, Budget Conscious):** Viable prospects that require self-serve or automated onboarding models.
- **Tier 3 (Low Intent / Window Shoppers):** High customer-support demands with low retention; best filtered out during early qualification.

By aligning product features, marketing messaging, and sales resources exclusively behind Tier 1 prospects, businesses shorten sales cycles by up to 45%.

---

## 2. Aligning Unit Economics: LTV to CAC Ratios

Before scaling paid acquisition or hiring expanded sales teams, leaders must validate their core unit economics. In professional business consulting, the golden standard benchmark remains:

| Metric | Target Benchmark | Strategic Implication |
| :--- | :--- | :--- |
| **LTV : CAC** | `3:1 to 5:1` | Indicates healthy capital efficiency and sustainable return. |
| **CAC Payback Period** | `< 12 Months` | Preserves cash flow and mitigates debt dependency. |
| **Gross Margin** | `> 70% (Tech) / > 50% (Services)` | Provides sufficient reinvestment capital for R&D and talent. |

When customer lifetime value reliably outpaces the fully loaded acquisition cost, businesses can deploy growth capital aggressively with minimal downside risk.

---

## 3. Constructing Defensible Moats

Temporary marketing leverage will eventually be eroded by competitor emulation. Enduring companies build compounding structural advantages:

1. **Brand Resonance & Authority:** Becoming the recognized industry benchmark reduces customer price sensitivity.
2. **Proprietary Process IP:** Unique delivery frameworks that competitors cannot easily replicate.
3. **High Switching Costs:** Deep workflow integrations that make client migration inconvenient and financially disadvantageous.

---

## Strategic Summary

Sustainable business expansion is engineered through disciplined customer qualification, validated unit economics, and relentless operational execution. Focus on depth of value before breadth of expansion.',
'assets/images/insight-2.svg',
'Framework for building a sustainable business growth strategy',
1, 1, 'published', 1, 6, '2026-11-03 10:30:00',
'content/blogs/business-growth-strategy.md',
365,
'How to Build a Successful Business Growth Strategy | Ritwik Sachdeva',
'A rigorous framework for executive leaders to clarify category positioning, establish scalable customer acquisition funnels, and protect margins.',
'https://www.ritwiksachdeva.in/blog/business-growth-strategy/',
'assets/images/insight-2.svg',
'BlogPosting', 1, 1);

-- Blog 3: Leadership Skills Every Entrepreneur Needs
INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `featured_image_alt`, `category_id`, `author_id`, `status`, `is_featured`, `reading_time`, `published_at`, `markdown_file_path`, `views_count`, `meta_title`, `meta_description`, `canonical_url`, `og_image`, `schema_type`, `created_by`, `updated_by`) VALUES
(3,
'Leadership Skills Every Entrepreneur Needs',
'leadership-skills',
'Essential executive capabilities required to transition from a hands-on operator to a high-leverage strategic leader who scales teams and drives accountability.',
'## The Entrepreneurial Transition

In the early phases of building a venture, an entrepreneur’s primary asset is individual grit. You write the proposals, manage client deliverables, balance the ledger, and resolve crises in real time.

However, as an organization scales beyond ten employees or \$1M in annual revenue, the very traits that enabled early survival—micro-involvement and unilateral decision-making—transform into severe operational bottlenecks.

Scaling a business requires evolving from a tactical operator into an **enabling leader**.

---

## 1. Radical Clarity of Vision and Communication

High-performing teams do not require micromanagement; they require unshakeable clarity. An entrepreneur’s chief responsibility is communicating the organizational roadmap with such clarity that team members can make autonomous decisions that align with executive goals.

### The 3 Rules of Strategic Communication:
- **Simplify the Objective:** If your quarterly objective cannot be articulated in a single sentence, it is too complicated.
- **Connect Tasks to Commercial Impact:** Ensure every employee understands how their weekly milestones influence client retention and enterprise revenue.
- **Repeat the Message Consistently:** As former CEO Jack Welch noted, leaders must reiterate core strategic priorities until they become organizational muscle memory.

---

## 2. Decisive Decision-Making with Incomplete Information

Academic theory suggests gathering complete data before reaching a conclusion. In commercial practice, waiting for 100% information often results in missed market windows.

World-class leaders operate with **70% certainty**. If you possess 70% of the relevant data and have evaluated the reversible vs. irreversible risks, decisive execution beats prolonged hesitation every time.

> "Speed of decision-making is an enterprise moat. Deliberation that produces no new insights is simply disguised anxiety."

---

## 3. High-Leverage Delegation and Talent Enablement

True delegation involves handing over both responsibility and decision-making authority. When founders delegate tasks while retaining all approval rights, they cultivate an environment of dependency.

Enable your leadership team by establishing clear boundary conditions:
- **Defined Budgets:** Give managers discretionary approval thresholds (e.g. up to \$5,000 without prior sign-off).
- **Outcome Ownership:** Measure results against agreed KPIs rather than dictating step-by-step methodologies.
- **Constructive Post-Mortems:** Treat errors as systemic learning opportunities rather than individual infractions.

---

## Final Thoughts: The Mindset of Stewardship

Great entrepreneurs recognize that their ultimate legacy is not personal indispensability, but building a resilient, self-governing business that thrives in their absence.',
'assets/images/about-consultant.svg',
'Leadership skills and executive decision making for entrepreneurs',
3, 1, 'published', 0, 5, '2026-11-05 14:15:00',
'content/blogs/leadership-skills.md',
289,
'Leadership Skills Every Entrepreneur Needs | Ritwik Sachdeva',
'Essential executive capabilities required to transition from a hands-on operator to a high-leverage strategic leader who scales teams.',
'https://www.ritwiksachdeva.in/blog/leadership-skills/',
'assets/images/about-consultant.svg',
'BlogPosting', 1, 1);

-- Blog 4: The Future of AI in Business Consulting
INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `featured_image_alt`, `category_id`, `author_id`, `status`, `is_featured`, `reading_time`, `published_at`, `markdown_file_path`, `views_count`, `meta_title`, `meta_description`, `canonical_url`, `og_image`, `schema_type`, `created_by`, `updated_by`) VALUES
(4,
'The Future of AI in Business Consulting',
'ai-in-business',
'Examining how generative intelligence, automated data modeling, and predictive analytics are reshaping professional advisory services and client outcomes.',
'## Deconstructing the Advisory AI Revolution

For decades, management and marketing consultancies operated on a billable-hours model: armies of junior analysts gathered secondary market research, cleaned spreadsheet tables, and formatted 80-page slide decks for corporate review.

The emergence of enterprise generative artificial intelligence and autonomous data synthesis has shattered this paradigm. Routine synthesis tasks that once required weeks of manual labor can now be generated with precision in seconds.

The question facing business leaders is no longer whether to integrate AI, but **how to deploy machine intelligence to amplify strategic human judgment**.

---

## 1. Predictive Analytics Replacing Static Historical Reporting

Traditional consulting delivered retrospective audits: *"Here is how your acquisition channels performed in Q3."* 

Modern AI-augmented advisory delivers predictive foresight:
- **Real-Time Churn Propensity:** Machine learning algorithms detect subtle user behavioral anomalies weeks before an account issues cancellation notices.
- **Dynamic Price Elasticity:** Algorithmic models simulate market response to pricing modifications across distinct customer segments.
- **Multivariate Ad Performance Prediction:** Evaluating creative fatigue and ad delivery trajectories before deploying hundreds of thousands in ad capital.

```text
Historical Reporting -> Diagnostic Insights -> Predictive Forecasting -> Automated Optimization
```

---

## 2. The Shift from Volume to Strategic Synthesis

As generic information becomes commoditized, the commercial value of basic advice approaches zero. Clients do not need another AI-generated summary of industry trends; they require:

1. **Contextual Risk Assessment:** Understanding the second- and third-order financial consequences of an acquisition or product pivot.
2. **Organizational Empathy:** Navigating internal corporate politics, change management resistance, and executive consensus.
3. **Accountable Partnership:** A consultant who stands behind their recommendations and takes co-ownership of commercial deliverables.

AI provides the computational speed; the senior consultant provides the strategic wisdom and commercial courage.

---

## 3. Implementing Ethical AI Guardrails in Enterprise Workflows

As businesses embrace automated language models and proprietary customer data pipelines, governance is paramount. Forward-thinking consulting practices mandate strict protocols:

- **Zero Data Leakage:** Ensuring enterprise datasets are never utilized to train public foundation models.
- **Hallucination Verification:** Rigorous verification systems cross-referencing AI outputs against primary financial statements and verified telemetry.
- **Explainability:** Recommending algorithmic decisions only when the mathematical rationale can be clearly articulated to board members.

---

## Conclusion: The Supercharged Strategic Advisor

The future of business consulting belongs neither to stubborn traditionalists who dismiss technological disruption, nor to technocrats who believe algorithms can replace human discernment. 

The winners are hybrid strategists who leverage AI to eliminate operational friction—devoting their full energy to high-stakes strategic leadership.',
'assets/images/insight-3.svg',
'Future of artificial intelligence in business consulting and strategy',
4, 1, 'published', 0, 8, '2026-11-07 11:00:00',
'content/blogs/ai-in-business.md',
512,
'The Future of AI in Business Consulting | Ritwik Sachdeva',
'Examining how generative intelligence, automated data modeling, and predictive analytics are reshaping professional advisory services.',
'https://www.ritwiksachdeva.in/blog/ai-in-business/',
'assets/images/insight-3.svg',
'BlogPosting', 1, 1);

-- Blog 5: Effective Marketing Strategies for Sustainable Growth
INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `featured_image_alt`, `category_id`, `author_id`, `status`, `is_featured`, `reading_time`, `published_at`, `markdown_file_path`, `views_count`, `meta_title`, `meta_description`, `canonical_url`, `og_image`, `schema_type`, `created_by`, `updated_by`) VALUES
(5,
'Effective Marketing Strategies for Sustainable Growth',
'marketing-strategies',
'How to build an omnichannel marketing ecosystem that balances performance paid media with compounding organic search authority and owned audience assets.',
'## Escaping the Paid Acquisition Trap

Over the past three years, customer acquisition costs across Meta, Google, and LinkedIn have risen by more than 40%. The brands suffering most severely are those that treated paid advertising as their sole distribution mechanism.

When media spend stops, their pipeline evaporates instantly.

Sustainable commercial growth demands an **omnichannel distribution flywheel**—combining immediate performance paid media with compounding organic search authority and owned audience channels.

---

## 1. High-Intent Search Dominance Over Vanity Traffic

Too many businesses invest heavily in content marketing that attracts hundreds of thousands of casual visitors who have zero intention of buying. Ranking for broad educational queries like *"what is marketing"* inflates vanity Google Analytics graphs but generates negligible pipeline.

Instead, structure your search strategy around **commercial decision intent**:
- **Comparison Queries:** *"Platform A vs. Platform B"*, *"Best Enterprise CRM for Mid-Market"*.
- **Problem-Specific Terms:** *"How to reduce B2B churn rate in SaaS"*, *"Cost per qualified lead benchmarks"*.
- **Direct Solution Queries:** High-intent terms demonstrating active buyer purchasing cycles.

By capturing prospects at the point of commercial evaluation, your conversion rates from visitor to qualified inquiry can increase fourfold.

---

## 2. Systematic Creative Testing in Paid Channels

Paid media is not a lottery; it is a scientific testing laboratory. Top-tier growth consultants implement disciplined weekly creative cadences:

```text
Hypothesis -> Hook Variation -> Body Angle -> Call to Action -> Data Analysis -> Winner Scale
```

### The 4 Elements of High-Converting Paid Assets:
1. **The 3-Second Hook:** Disrupting the newsfeed scroll with a contrarian industry insight or specific pain point.
2. **Social Proof Validation:** Referencing verified enterprise case metrics within the initial 15 seconds.
3. **Friction-Free Offer:** Offering an immediate diagnostic audit or specific resource rather than an intimidating *"Request 60-Minute Demo"*.
4. **Dedicated Landing Experience:** Never send paid ad traffic to a generic homepage. Direct prospects to a customized landing page that mirrors the ad’s exact promise.

---

## 3. Building Owned Audience Assets

Algorithms change overnight, ad accounts encounter arbitrary review holds, and platform policies shift. The only audience you truly own is your **email subscriber database and direct customer list**.

Nurture your owned community through high-signal executive newsletters, quarterly benchmark reports, and private webinars. When prospects spend months learning from your proprietary insights, sales resistance disappears when they are finally ready to engage advisory services.

---

## Summary: The Compounding Flywheel

True marketing excellence is achieved when paid media feeds owned audience growth, owned audience fuels referrals, and organic search delivers compounding baseline pipeline independent of daily media budgets.',
'assets/images/insight-1.svg',
'Omnichannel digital marketing strategies for sustainable enterprise growth',
5, 1, 'published', 0, 6, '2026-11-09 16:45:00',
'content/blogs/marketing-strategies.md',
390,
'Effective Marketing Strategies for Sustainable Growth | Ritwik Sachdeva',
'How to build an omnichannel marketing ecosystem that balances performance paid media with compounding organic search authority.',
'https://www.ritwiksachdeva.in/blog/marketing-strategies/',
'assets/images/insight-1.svg',
'BlogPosting', 1, 1);

-- ----------------------------------------------------------------------------
-- 9. ASSOCIATE TAGS WITH BLOGS
-- ----------------------------------------------------------------------------
-- Blog 1: Digital Transformation (Tags: 1, 2, 6, 8)
INSERT INTO `blog_tag_relations` (`blog_id`, `tag_id`) VALUES (1, 1), (1, 2), (1, 6), (1, 8);

-- Blog 2: Business Growth Strategy (Tags: 1, 6, 7, 9)
INSERT INTO `blog_tag_relations` (`blog_id`, `tag_id`) VALUES (2, 1), (2, 6), (2, 7), (2, 9);

-- Blog 3: Leadership Skills (Tags: 1, 3, 8)
INSERT INTO `blog_tag_relations` (`blog_id`, `tag_id`) VALUES (3, 1), (3, 3), (3, 8);

-- Blog 4: AI in Business Consulting (Tags: 1, 4, 8, 9)
INSERT INTO `blog_tag_relations` (`blog_id`, `tag_id`) VALUES (4, 1), (4, 4), (4, 8), (4, 9);

-- Blog 5: Marketing Strategies (Tags: 1, 5, 6, 7)
INSERT INTO `blog_tag_relations` (`blog_id`, `tag_id`) VALUES (5, 1), (5, 5), (5, 6), (5, 7);

-- ----------------------------------------------------------------------------
-- 10. INSERT REALISTIC CONTACT LEADS FOR CRM
-- ----------------------------------------------------------------------------
INSERT INTO `contact_leads` (`id`, `full_name`, `email`, `phone`, `company`, `service_interested`, `monthly_budget`, `message`, `status`, `lead_source`, `assigned_to`, `follow_up_date`, `created_at`) VALUES
(1, 'Alexandra Chen', 'alexandra@apexcloud.io', '+1 (415) 890-2341', 'Apex Cloud Solutions', 'Digital Marketing Strategy', '$15,000 – $35,000 / month', 'Looking to overhaul our B2B SaaS acquisition funnels ahead of our Series B round in Q2. Need fractional CMO direction on paid channels and technical SEO.', 'QUALIFIED', 'Website Contact Form', 1, '2026-11-15', '2026-11-08 14:20:00'),
(2, 'Robert Sterling', 'r.sterling@sterlingfin.co.uk', '+44 20 7946 0912', 'Sterling Financial Advisory', 'Search Engine Optimization (SEO)', '$5,000 – $15,000 / month', 'We want to dominate organic commercial search terms for wealth advisory services in London and Zurich. Need an end-to-end technical SEO roadmap.', 'PROPOSAL_SENT', 'Website Contact Form', 1, '2026-11-12', '2026-11-07 10:15:00'),
(3, 'Priya Sharma', 'priya@healthscale.ai', '+91 98201 44552', 'HealthScale AI', 'Performance Marketing', '$35,000+ / month', 'Currently spending $60k/mo on Google and Meta ads with diminishing returns. Need disciplined creative testing and attribution setup.', 'CONVERTED', 'Website Contact Form', 1, NULL, '2026-10-25 16:40:00'),
(4, 'David Miller', 'dmiller@nexustech.de', '+49 30 1234567', 'Nexus Logistics GmbH', 'Lead Generation Services', '$15,000 – $35,000 / month', 'Looking for high-converting landing pages and automated email nurture flows for our enterprise supply chain management software.', 'CONTACTED', 'Website Contact Form', 3, '2026-11-14', '2026-11-09 11:30:00'),
(5, 'Jonathan Vance', 'jvance@vancemedia.com', '+1 (212) 555-0199', 'Vance Capital Partners', 'Digital Marketing Consulting', 'Strategic Advisory Retainer Only', 'Seeking executive advisory on portfolio marketing governance and growth strategy for three newly acquired SaaS companies.', 'NEW', 'Website Contact Form', 1, '2026-11-11', '2026-11-10 09:10:00'),
(6, 'Elena Rostova', 'elena@nordicbiotech.se', '+46 8 123 4567', 'Nordic BioTech', 'Brand Strategy & Positioning', '$5,000 – $15,000 / month', 'We need to reposition our clinical research platform to better attract North American pharmaceutical enterprise partners.', 'LOST', 'Website Contact Form', 3, NULL, '2026-10-18 15:00:00');

-- ----------------------------------------------------------------------------
-- 11. INSERT LEAD NOTES
-- ----------------------------------------------------------------------------
INSERT INTO `lead_notes` (`lead_id`, `admin_id`, `note`, `created_at`) VALUES
(1, 1, 'Initial discovery call scheduled for Nov 15th at 3pm EST. Strong unit economics, growing 80% YoY, seeking to transition from founder-led sales to scalable digital pipeline.', '2026-11-08 16:00:00'),
(2, 1, 'Detailed audit proposal delivered on Nov 7th. Awaiting board budget approval on Nov 12th.', '2026-11-07 17:30:00'),
(3, 1, 'Contract signed for 90-day growth sprint. Kickoff workshop completed on Nov 1st.', '2026-10-28 11:00:00'),
(4, 3, 'Sent introductory calendar link. David confirmed review of our case studies.', '2026-11-09 14:00:00');

-- ----------------------------------------------------------------------------
-- 12. INSERT LEAD ACTIVITIES
-- ----------------------------------------------------------------------------
INSERT INTO `lead_activities` (`lead_id`, `admin_id`, `activity_type`, `description`, `created_at`) VALUES
(1, 1, 'CREATED', 'Inquiry received via website consultation form.', '2026-11-08 14:20:00'),
(1, 1, 'STATUS_CHANGE', 'Status changed from NEW to QUALIFIED after initial email assessment.', '2026-11-08 15:30:00'),
(2, 1, 'STATUS_CHANGE', 'Proposal sent via DocuSign following strategic scoping call.', '2026-11-07 17:00:00'),
(3, 1, 'STATUS_CHANGE', 'Client status moved to CONVERTED upon deposit receipt.', '2026-10-28 10:45:00'),
(5, 1, 'CREATED', 'New inquiry received from Vance Capital Partners.', '2026-11-10 09:10:00');

-- ----------------------------------------------------------------------------
-- 13. INSERT SEO METADATA FOR MAIN PAGES
-- ----------------------------------------------------------------------------
INSERT INTO `seo_metadata` (`page_route`, `page_title`, `meta_description`, `canonical_url`, `og_title`, `og_description`, `og_image`) VALUES
('home', 'Digital Marketing Consultant | Strategy, SEO & Business Growth', 'Explore professional digital marketing strategies, SEO, performance marketing and lead generation solutions designed to help businesses grow.', 'https://www.ritwiksachdeva.in/', 'Digital Marketing Consultant | Strategy, SEO & Business Growth', 'Explore professional digital marketing strategies, SEO, performance marketing and lead generation solutions.', 'assets/images/hero-consultant.svg'),
('about', 'About | Digital Marketing Consultant', 'Learn about my digital marketing expertise, strategic approach and commitment to helping businesses achieve sustainable online growth.', 'https://www.ritwiksachdeva.in/about.html', 'About | Digital Marketing Consultant', 'Learn about my digital marketing expertise and strategic approach.', 'assets/images/about-consultant.svg'),
('services', 'Digital Marketing Services | SEO, Marketing & Lead Generation', 'Explore digital marketing consulting, SEO, social media marketing, paid advertising and lead generation services.', 'https://www.ritwiksachdeva.in/services.html', 'Digital Marketing Services | SEO, Marketing & Lead Generation', 'Explore digital marketing consulting, SEO, paid advertising and lead generation services.', 'assets/images/hero-consultant.svg'),
('blog', 'Strategic Marketing & Business Consulting Blog | Ritwik Sachdeva', 'Actionable essays and strategic frameworks on digital transformation, performance marketing, B2B lead generation, and executive leadership.', 'https://www.ritwiksachdeva.in/blog/', 'Strategic Marketing & Business Consulting Blog | Ritwik Sachdeva', 'Actionable essays and strategic frameworks on digital transformation, performance marketing, and leadership.', 'assets/images/hero-consultant.svg'),
('contact', 'Contact | Digital Marketing Consultation', 'Get in touch to discuss your marketing goals, business challenges and opportunities for digital growth.', 'https://www.ritwiksachdeva.in/contact.html', 'Contact | Digital Marketing Consultation', 'Get in touch to discuss your marketing goals, business challenges and opportunities for digital growth.', 'assets/images/hero-consultant.svg');

-- ----------------------------------------------------------------------------
-- 14. INSERT DEFAULT WEBSITE SETTINGS
-- ----------------------------------------------------------------------------
INSERT INTO `website_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_name', 'Ritwik Sachdeva', 'general'),
('site_tagline', 'Digital Marketing Consultant & Growth Strategist', 'general'),
('site_url', 'http://localhost:8000', 'general'),
('contact_email', 'consult@ritwiksachdeva.com', 'contact'),
('contact_phone', '+91 98765 43210', 'contact'),
('contact_location', 'New Delhi, India • Serving Clients Worldwide', 'contact'),
('response_guarantee', 'Under 24 business hours guaranteed', 'contact'),
('social_linkedin', 'https://linkedin.com', 'social'),
('social_twitter', 'https://twitter.com', 'social'),
('social_substack', 'https://substack.com', 'social'),
('enable_markdown_sync', '1', 'system'),
('sitemap_auto_generate', '1', 'system');

SET FOREIGN_KEY_CHECKS = 1;

