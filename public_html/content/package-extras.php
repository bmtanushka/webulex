<?php
declare(strict_types=1);

// Shared package content: add-ons, the "Please note" box and FAQs (BRIEF.md §7.5).

return [
    'addons' => [
        ['icon' => 'palette', 'title' => 'Logo and brand identity', 'service' => 'ui-ux-branding'],
        ['icon' => 'at-sign', 'title' => 'Google Workspace or Microsoft 365 email', 'service' => 'business-email-workspace'],
        ['icon' => 'circle-play', 'title' => 'YouTube channel management', 'service' => 'youtube-channel-management'],
        ['icon' => 'layers', 'title' => 'Extra blog posts, landing pages or ad platforms', 'service' => null],
        ['icon' => 'server', 'title' => 'Website care, hosting and domain plans', 'service' => 'website-care-hosting'],
    ],

    'note' => [
        'Advertising budgets are paid directly to Google and Meta and are not included in the package price.',
        'Third-party costs (domain, hosting, booking or CRM software, AI call minutes, SMS and WhatsApp messages) are quoted separately.',
        'Every package can be tailored, and payment can be spread across the package timeline.',
    ],

    // REVIEW(owner): drafted FAQs for the packages pages.
    'faqs' => [
        ['q' => 'How much do the packages cost?', 'a' => 'Every business is different, so we give you a fixed quote after a free consultation. Ad budgets and third-party costs are always shown separately.'],
        ['q' => 'Can I change what is in a package?', 'a' => 'Yes. Every package can be tailored. We can add or remove services so it fits your business and budget.'],
        ['q' => 'Can I spread the payments?', 'a' => 'Yes. Payment can be spread across the package timeline.'],
        ['q' => 'What happens when the package ends?', 'a' => 'You keep everything we set up, in your name. Many clients continue with a monthly marketing or care plan, but there is no obligation.'],
        ['q' => 'Do I own the website, accounts and data?', 'a' => 'Yes. Your domain, website, ad accounts, CRM and data are set up in your name.'],
    ],
];
