<?php
declare(strict_types=1);

// Services by area: BRIEF.md §7.3–7.4. Outcomes, process steps and FAQs are added in Phase 3.

return [
    'areas' => [
        'build' => [
            'title' => 'Web & Software Development',
            'short' => 'Build',
            'icon' => 'code',
            'accent' => 'cyan',
            'summary' => 'Websites, web apps, online stores, integrations and payments.',
            'intro' => 'Fast, secure and scalable websites, online stores and business applications, designed to look great and built to perform.',
        ],
        'grow' => [
            'title' => 'Search & Online Visibility',
            'short' => 'Grow',
            'icon' => 'trending-up',
            'accent' => 'magenta',
            'summary' => 'SEO, AIEO, Local SEO, Google Business Profile and content.',
            'intro' => 'Be found wherever your customers look: on Google, on Maps and in the new generation of AI search assistants.',
        ],
        'promote' => [
            'title' => 'Social Media & Advertising',
            'short' => 'Promote',
            'icon' => 'megaphone',
            'accent' => 'cyan',
            'summary' => 'Social media, Google Ads, social ads, YouTube, email and WhatsApp.',
            'intro' => 'Build a loyal audience and generate leads with consistent content and data-driven paid campaigns.',
        ],
        'automate' => [
            'title' => 'AI & Business Automation',
            'short' => 'Automate',
            'icon' => 'bot',
            'accent' => 'magenta',
            'summary' => 'n8n automation, AI chatbots and call agents, CRM and business email.',
            'intro' => 'Save time, cut errors and serve customers faster by putting AI and automation to work in your business.',
        ],
    ],

    'services' => [
        // BUILD
        'website-development' => [
            'area' => 'build', 'icon' => 'layout-template', 'title' => 'Website Development',
            'description' => 'Professional, mobile-friendly websites that represent your brand and turn visitors into enquiries.',
            'includes' => ['Responsive design for mobile, tablet and desktop', 'Easy-to-edit CMS (WordPress or custom)', 'One-time on-page SEO setup at launch', 'Contact forms, maps and WhatsApp chat', 'SSL, speed optimisation and backups'],
        ],
        'custom-web-applications' => [
            'area' => 'build', 'icon' => 'layers', 'title' => 'Custom Web Application Development',
            'description' => 'Bespoke systems built around the way your business works.',
            'includes' => ['Customer portals, booking and order systems', 'Internal tools, dashboards and admin panels', 'Role-based user access and audit trails', 'Secure architecture and cloud deployment', 'Laravel, Python, PHP and modern JavaScript'],
        ],
        'ecommerce-development' => [
            'area' => 'build', 'icon' => 'shopping-cart', 'title' => 'eCommerce Website Development',
            'description' => 'Online stores that are simple to manage and easy to buy from.',
            'includes' => ['WooCommerce, Shopify or custom stores', 'Local and international payment gateways', 'Product, stock and order management', 'Delivery, discount and tax rules', 'Abandoned-cart and order notifications'],
        ],
        'integration-support' => [
            'area' => 'build', 'icon' => 'plug', 'title' => 'Web Application Integration Support',
            'description' => 'Connect your website and systems so data flows without re-keying.',
            'includes' => ['REST API development and integration', 'Payment, SMS and email gateway integration', 'CRM, ERP and accounting system links', 'Fixes and enhancements to existing systems', 'Data migration between platforms'],
        ],
        'payment-gateway-integration' => [
            'area' => 'build', 'icon' => 'credit-card', 'title' => 'Online Payment Gateway Integration',
            'description' => 'Accept card and online payments securely on your website, store or booking system.',
            'includes' => ['Stripe, PayPal, Square and local gateway options', 'Merchant account application support', 'Secure checkout and payment confirmation', 'Recurring payments and subscriptions'],
        ],
        'ui-ux-branding' => [
            'area' => 'build', 'icon' => 'palette', 'title' => 'UI/UX Design & Branding',
            'description' => 'A consistent, professional look across your website and marketing.',
            'includes' => ['Logo and brand identity design', 'Wireframes and clickable prototypes', 'User-friendly interface design', 'Brand guidelines and templates'],
        ],
        'website-care-hosting' => [
            'area' => 'build', 'icon' => 'server', 'title' => 'Website Care, Hosting & Domains',
            'description' => 'Fully managed support so your website stays online, secure and up to date.',
            'includes' => ['Web hosting and domain registration/renewal', 'Monthly updates, backups and monitoring', 'Allocated hours for content changes', 'Priority technical support'],
        ],
        'security-speed' => [
            'area' => 'build', 'icon' => 'shield-check', 'title' => 'Website Security & Speed Optimisation',
            'description' => 'Protect your reputation and stop visitors leaving slow pages.',
            'includes' => ['Security hardening and SSL configuration', 'Malware clean-up and recovery', 'Core Web Vitals and page-speed tuning', 'Uptime monitoring and alerts'],
        ],

        // GROW
        'seo' => [
            'area' => 'grow', 'icon' => 'search', 'title' => 'Search Engine Optimisation (SEO)',
            'description' => 'Rank higher on Google for the searches your customers actually make.',
            'includes' => ['Keyword and competitor research', 'Technical SEO audit and fixes', 'On-page optimisation of content and metadata', 'Quality backlink building', 'Monthly ranking and traffic reports'],
        ],
        'aieo' => [
            'area' => 'grow', 'icon' => 'sparkles', 'title' => 'AIEO – AI Engine Optimisation',
            'description' => 'Get your business recommended by AI assistants such as ChatGPT, Gemini, Perplexity and Google AI Overviews.',
            'includes' => ['AI visibility audit for your brand', 'Structured data and schema markup', 'Answer-focused FAQ and expert content', 'Brand mentions and citation building', 'Tracking of AI search presence'],
        ],
        'local-seo' => [
            'area' => 'grow', 'icon' => 'map-pin', 'title' => 'Local SEO',
            'description' => 'Be the first choice when nearby customers search for what you offer.',
            'includes' => ['Google Maps and local pack optimisation', 'Local keyword targeting', 'Business directory citations', 'Location pages for multiple branches', 'Review generation strategy'],
        ],
        'google-business-profile' => [
            'area' => 'grow', 'icon' => 'building-2', 'title' => 'Google Business Profile Management',
            'description' => 'Keep your Google listing accurate, active and attractive.',
            'includes' => ['Profile setup, verification and optimisation', 'Regular posts, offers and photo updates', 'Review monitoring and responses', 'Q&A management and insights reports'],
        ],
        'seo-blog-posting' => [
            'area' => 'grow', 'icon' => 'file-text', 'title' => 'SEO-Friendly Blog Posting',
            'description' => 'Regular, well-researched articles that build authority and bring in organic traffic.',
            'includes' => ['Keyword-researched topic planning', 'Original, optimised articles', 'Internal linking and featured images', 'Scheduled publishing on your website'],
        ],
        'analytics-tracking' => [
            'area' => 'grow', 'icon' => 'chart-column', 'title' => 'Analytics & Tracking Setup',
            'description' => 'Know exactly where your leads and sales come from.',
            'includes' => ['Google Analytics 4 and Search Console', 'Google Tag Manager and conversion tracking', 'Meta Pixel and event tracking', 'Live Looker Studio performance reports'],
        ],
        'landing-pages' => [
            'area' => 'grow', 'icon' => 'target', 'title' => 'Landing Pages & Lead Generation',
            'description' => 'Dedicated pages and funnels that turn visitors and ad traffic into enquiries.',
            'includes' => ['High-converting landing page design', 'Lead forms connected to your CRM', 'Conversion rate optimisation (CRO)', 'Split testing of offers and layouts'],
        ],

        // PROMOTE
        'social-media-management' => [
            'area' => 'promote', 'icon' => 'share-2', 'title' => 'Social Media Page Management',
            'description' => 'A consistent, on-brand presence on Facebook, Instagram, LinkedIn and X.',
            'includes' => ['Page setup and profile optimisation', 'Monthly content calendar', 'Post design, captions and hashtags', 'Scheduling and publishing', 'Comment and message moderation', 'Monthly engagement reports'],
        ],
        'social-media-advertising' => [
            'area' => 'promote', 'icon' => 'mouse-pointer-click', 'title' => 'Social Media Advertising',
            'description' => 'Targeted paid campaigns that reach the right people and generate leads and sales.',
            'includes' => ['Meta (Facebook and Instagram) ads', 'LinkedIn, X and TikTok ads', 'Audience targeting and retargeting', 'Ad creative and copy', 'A/B testing and budget optimisation'],
        ],
        'youtube-channel-management' => [
            'area' => 'promote', 'icon' => 'circle-play', 'title' => 'YouTube Channel Management',
            'description' => 'Grow a YouTube channel that builds trust and brings in customers.',
            'includes' => ['Channel setup, branding and optimisation', 'Video upload, titles, tags and thumbnails', 'YouTube SEO and playlists', 'Shorts and video editing support', 'Monthly channel performance reports'],
        ],
        'google-ads' => [
            'area' => 'promote', 'icon' => 'chart-line', 'title' => 'Google Advertising',
            'description' => 'Appear at the top of Google the moment customers search for you.',
            'includes' => ['Search, Display and YouTube campaigns', 'Shopping and Performance Max', 'Keyword research and ad copy', 'Conversion tracking setup', 'Ongoing bid and budget optimisation'],
        ],
        'creative-design' => [
            'area' => 'promote', 'icon' => 'brush', 'title' => 'Creative Content & Graphic Design',
            'description' => 'Scroll-stopping visuals for social media, ads and print.',
            'includes' => ['Social media post and story designs', 'Reels and short-form video editing', 'Ad banners and promotional graphics', 'Brochures, flyers and presentations'],
        ],
        'email-whatsapp-marketing' => [
            'area' => 'promote', 'icon' => 'send', 'title' => 'Email & WhatsApp Marketing',
            'description' => 'Stay in touch with customers and bring them back to buy again.',
            'includes' => ['Newsletter design and campaigns', 'Automated welcome and follow-up sequences', 'WhatsApp Business broadcasts and catalogues', 'Subscriber list growth and segmentation'],
        ],

        // AUTOMATE
        'n8n-automation' => [
            'area' => 'automate', 'icon' => 'workflow', 'title' => 'AI Automation using n8n',
            'description' => 'Automate repetitive work by connecting your apps, data and AI into smart workflows.',
            'includes' => ['Lead capture straight into your CRM or sheets', 'Automated quotes, invoices and reminders', 'Email, WhatsApp and Slack notifications', 'AI-powered document and email processing', 'Self-hosted or cloud n8n deployment'],
        ],
        'ai-chatbots-call-agents' => [
            'area' => 'automate', 'icon' => 'phone-call', 'title' => 'AI Chatbots & Call Agents',
            'description' => 'Answer customer chats and phone calls 24/7, and book appointments automatically.',
            'includes' => ['Website, WhatsApp and Messenger chatbots', 'AI call agents that answer and return calls', 'Lead capture and appointment booking', 'Trained on your products and FAQs', 'Smooth hand-over to your staff'],
        ],
        'ai-agents-integration' => [
            'area' => 'automate', 'icon' => 'cpu', 'title' => 'AI Agents & Custom AI Integration',
            'description' => 'Bring leading AI models into your own systems.',
            'includes' => ['AI features inside your web apps', 'Document reading and data extraction', 'MCP connectors so AI can query your data', 'Secure, privacy-conscious design'],
        ],
        'crm-setup' => [
            'area' => 'automate', 'icon' => 'users', 'title' => 'CRM Setup & Integration',
            'description' => 'Track every lead and customer in one place.',
            'includes' => ['HubSpot, Zoho or custom CRM setup', 'Sales pipelines and follow-up automation', 'Integration with website and ads', 'Staff training and support'],
        ],
        'business-email-workspace' => [
            'area' => 'automate', 'icon' => 'at-sign', 'title' => 'Business Email & Workspace Setup',
            'description' => 'Professional email on your own domain, with the collaboration tools your team needs.',
            'includes' => ['Google Workspace or Microsoft 365 setup', 'Domain email (you@yourcompany.com)', 'Migration from existing email accounts', 'Shared drives, calendars and Teams/Meet', 'Security, spam protection and user support'],
        ],
        'it-consultancy' => [
            'area' => 'automate', 'icon' => 'compass', 'title' => 'IT Consultancy & Digital Transformation',
            'description' => 'Practical advice to modernise your business with the right technology.',
            'includes' => ['Technology roadmaps and system selection', 'Cloud hosting and migration (AWS)', 'Cybersecurity reviews and best practice', 'Process digitisation'],
        ],
    ],
];
