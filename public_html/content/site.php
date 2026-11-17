<?php
declare(strict_types=1);

// Company facts: the source of truth is BRIEF.md §2. Do not change these without the owner.

return [
    'legal_name' => 'Webulex Technology & Accounting Solutions (PVT) Ltd',
    'trading_name' => 'Webulex',
    'registration' => 'Reg. PV00237882 (Sri Lanka)',
    'address' => [
        'street' => '285/6, Sudarshana Mawatha',
        'locality' => 'Malabe',
        'postcode' => '10115',
        'country' => 'Sri Lanka',
        'one_line' => '285/6, Sudarshana Mawatha, Malabe 10115, Sri Lanka',
    ],
    'phone_display' => '+94 77 227 5760',
    'phone_e164' => '+94772275760',
    'whatsapp_number' => '94772275760',
    'email' => 'info@webulexpro.com',
    'base_url' => 'https://webulexpro.com',
    'tagline' => 'Build. Grow. Promote. Automate.',
    'default_description' => 'Websites, SEO, ads and AI automation for small businesses in the US, UK, Singapore and Australia. One accountable team. Book a free consultation.',
    'home_timezone' => 'Asia/Colombo',

    'regions' => [
        'us' => ['name' => 'USA', 'long' => 'United States', 'flag' => 'us'],
        'uk' => ['name' => 'UK', 'long' => 'United Kingdom', 'flag' => 'gb'],
        'sg' => ['name' => 'Singapore', 'long' => 'Singapore', 'flag' => 'sg'],
        'au' => ['name' => 'Australia', 'long' => 'Australia', 'flag' => 'au'],
    ],

    // Top-level navigation. Items with a 'mega' key open a mega-menu.
    'nav' => [
        ['label' => 'Services', 'href' => '/services', 'mega' => 'services'],
        ['label' => 'Packages', 'href' => '/packages', 'mega' => 'packages'],
        ['label' => 'Industries', 'href' => '/industries'],
        ['label' => 'How we work', 'href' => '/how-we-work'],
        ['label' => 'About', 'href' => '/about'],
        ['label' => 'Blog', 'href' => '/blog'],
    ],

    // TODO(owner): add social media profile URLs, e.g. 'facebook' => 'https://…'
    'social' => [],
];
