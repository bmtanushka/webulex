<?php
declare(strict_types=1);

// General packages: BRIEF.md §7.5.
// 'services' lists the service slugs each package includes (used for cross-links).
// Prices — TODO(owner): prices. Add 'prices' => ['USD' => 0, 'GBP' => 0, 'SGD' => 0, 'AUD' => 0] to a package
// and set SHOW_PRICES => true in config.php. Until then every package shows "Price on request".

return [
    'complete-business-launch' => [
        'title' => 'Complete Business Launch',
        'timeline' => '4 months',
        'flagship' => true,
        'tagline' => 'From scratch to a fully working online business in four months.',
        'intro' => 'From scratch to a fully working online business in four months: a website that books appointments, marketing that brings in leads, and AI that follows them up for you.',
        'ideal_for' => 'New and growing service businesses (clinics, salons, consultants, tutors, trades) that want customers to find them, book online and be followed up automatically.',
        'groups' => [
            ['title' => 'Online foundation', 'icon' => 'layout-template', 'items' => ['Business website', 'Landing pages for your key services', 'Online booking pages', 'Google Business Profile setup', 'Social media pages (Facebook, Instagram, LinkedIn, X)']],
            ['title' => 'Get found', 'icon' => 'search', 'items' => ['SEO', 'AIEO', 'Local SEO', 'SEO-friendly blog posting']],
            ['title' => 'Attract customers', 'icon' => 'megaphone', 'items' => ['Google Ads setup and management', 'Social media paid advertising', 'Lead collection forms and funnels']],
            ['title' => 'AI & automation', 'icon' => 'bot', 'items' => ['AI chatbot that books appointments', 'AI call agent for incoming and follow-up calls', 'CRM setup', 'Automated follow-up notifications (email, SMS, WhatsApp)']],
        ],
        'roadmap' => [
            ['month' => 'Month 1', 'title' => 'Build the foundation', 'items' => ['Discovery and planning', 'Website design and build', 'Booking pages', 'Google Business Profile setup', 'Social media page setup', 'Analytics and tracking']],
            ['month' => 'Month 2', 'title' => 'Get found, capture leads', 'items' => ['Technical and on-page SEO', 'Local SEO and citations', 'AIEO setup (schema, FAQs)', 'Landing pages and lead forms', 'CRM setup', 'First SEO blog posts']],
            ['month' => 'Month 3', 'title' => 'Automate and advertise', 'items' => ['AI chatbot with appointment booking', 'AI call agent', 'Follow-up notification automation', 'Google Ads launch', 'Social media ads launch', 'Ongoing blog posting']],
            ['month' => 'Month 4', 'title' => 'Optimise and hand over', 'items' => ['Ad and budget optimisation', 'Landing page testing', 'SEO, AIEO and content growth', 'Full performance report', 'Staff training on CRM and tools', 'Handover and next-step plan']],
        ],
        'outcomes' => ['A professional website with booking and landing pages', 'Visibility on Google Search, Maps and AI assistants', 'Live Google and social ad campaigns', 'Every lead in a CRM and followed up automatically', 'An AI chatbot and call agent answering around the clock', 'A trained team and a growth plan'],
        'services' => ['website-development', 'landing-pages', 'google-business-profile', 'social-media-management', 'seo', 'aieo', 'local-seo', 'seo-blog-posting', 'google-ads', 'social-media-advertising', 'ai-chatbots-call-agents', 'crm-setup', 'n8n-automation', 'analytics-tracking'],
    ],
    'starter-online-presence' => [
        'title' => 'Starter Online Presence',
        'timeline' => '4–6 weeks',
        'icon' => 'rocket',
        'tagline' => 'A professional presence, quickly.',
        'ideal_for' => 'New businesses that need a professional presence quickly.',
        'includes' => ['Website (up to 5 pages)', 'One-time on-page SEO', 'Google Business Profile setup', 'Social page setup (2 platforms)', 'Contact form and WhatsApp chat', 'Business email setup'],
        'services' => ['website-development', 'google-business-profile', 'social-media-management', 'business-email-workspace'],
    ],
    'growth-marketing-plan' => [
        'title' => 'Growth Marketing Plan',
        'timeline' => 'Monthly, min. 3 months',
        'icon' => 'trending-up',
        'popular' => true,
        'tagline' => 'More traffic and more leads.',
        'ideal_for' => 'Businesses with a website that want more traffic and leads.',
        'includes' => ['SEO, Local SEO and AIEO', 'Google Business Profile management', 'Monthly SEO blog posts', 'Social media management', 'Google Ads and social ads management', 'Monthly report'],
        'services' => ['seo', 'local-seo', 'aieo', 'google-business-profile', 'seo-blog-posting', 'social-media-management', 'google-ads', 'social-media-advertising'],
    ],
    'ai-sales-assistant' => [
        'title' => 'AI Sales Assistant',
        'timeline' => '6–8 weeks',
        'icon' => 'bot',
        'tagline' => 'Never lose an enquiry again.',
        'ideal_for' => 'Busy teams losing enquiries or spending hours on follow-ups.',
        'includes' => ['AI chatbot with booking', 'AI call agent', 'Lead collection forms', 'CRM setup and data import', 'Automated follow-up notifications', 'Training and support'],
        'services' => ['ai-chatbots-call-agents', 'crm-setup', 'n8n-automation', 'landing-pages'],
    ],
    'ecommerce-launch' => [
        'title' => 'eCommerce Launch',
        'timeline' => '6–8 weeks',
        'icon' => 'shopping-cart',
        'tagline' => 'Start selling online.',
        'ideal_for' => 'Retailers ready to sell online.',
        'includes' => ['Online store and product setup', 'Payment gateway integration', 'Delivery and discount rules', 'Google Shopping and Meta catalogue', 'Abandoned-cart and order notifications', 'Launch ad campaign'],
        'services' => ['ecommerce-development', 'payment-gateway-integration', 'google-ads', 'social-media-advertising'],
    ],
];
