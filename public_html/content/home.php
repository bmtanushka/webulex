<?php
declare(strict_types=1);

// Home page copy: BRIEF.md §7.1.

return [
    'problems' => [
        ['icon' => 'search', 'problem' => "Customers can't find you online", 'solution' => 'SEO, Local SEO and AI search visibility put you in front of people who are ready to buy.'],
        ['icon' => 'inbox', 'problem' => 'Enquiries slip through the cracks', 'solution' => 'Every lead goes into a CRM and is followed up automatically.'],
        ['icon' => 'phone-call', 'problem' => 'You miss calls while you work', 'solution' => 'AI chatbots and call agents answer 24/7 and book appointments.'],
        ['icon' => 'chart-column', 'problem' => 'Marketing feels like guesswork', 'solution' => 'Clear monthly reports on rankings, leads and ad performance.'],
    ],

    'roadmap' => [
        ['month' => 'Month 1', 'title' => 'Build the foundation'],
        ['month' => 'Month 2', 'title' => 'Get found, capture leads'],
        ['month' => 'Month 3', 'title' => 'Automate and advertise'],
        ['month' => 'Month 4', 'title' => 'Optimise and hand over'],
    ],

    'industry_cards' => [
        'cleaning-companies' => 'More bookings. Less admin.',
        'handyman-services' => 'Get the call. Win the job.',
        'sole-traders' => 'Look established. Work smarter.',
    ],

    // TODO(owner): confirm working hours. These overlap windows are draft wording.
    'regions' => [
        'us' => ['tz' => 'America/New_York', 'tz_label' => 'New York', 'overlap' => 'US: your morning, with flexible evening calls'],
        'uk' => ['tz' => 'Europe/London', 'tz_label' => 'London', 'overlap' => 'UK: your morning and early afternoon'],
        'sg' => ['tz' => 'Asia/Singapore', 'tz_label' => 'Singapore', 'overlap' => 'Singapore: most of your working day'],
        'au' => ['tz' => 'Australia/Sydney', 'tz_label' => 'Sydney', 'overlap' => 'Australia: your afternoon'],
    ],

    'steps' => [
        ['title' => 'Discover', 'text' => 'We learn about your business, customers and goals.'],
        ['title' => 'Plan', 'text' => 'A clear proposal with scope, timeline and fixed pricing.'],
        ['title' => 'Build & launch', 'text' => 'Design, development and testing, with your feedback at each stage.'],
        ['title' => 'Grow & report', 'text' => 'Marketing, SEO and automation, measured with regular reports.'],
        ['title' => 'Support', 'text' => 'Ongoing maintenance, updates and improvements.'],
    ],

    'why' => [
        ['icon' => 'handshake', 'title' => 'One partner, end to end', 'text' => 'Development, marketing and automation from a single accountable team.'],
        ['icon' => 'code', 'title' => 'Engineering-led', 'text' => 'Secure, well-built solutions designed to grow with your business.'],
        ['icon' => 'chart-line', 'title' => 'Results you can measure', 'text' => 'Clear reports on rankings, traffic, leads and campaign performance.'],
        ['icon' => 'receipt', 'title' => 'Transparent pricing', 'text' => 'Fixed project quotes and simple monthly plans, with no hidden costs.'],
        ['icon' => 'message-circle', 'title' => 'Responsive support', 'text' => 'A team you can reach directly by email, phone or WhatsApp.'],
    ],
];
