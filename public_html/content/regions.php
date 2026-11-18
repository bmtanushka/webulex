<?php
declare(strict_types=1);

// Regional landing pages: BRIEF.md §7.9. Each page is written separately (not a template with the country swapped).
// The US page uses US spelling. REVIEW(owner): all regional copy and FAQs are drafts.
// 'tz' drives the live time-zone table; 'currency' is used once prices exist.

return [
    'us' => [
        'name' => 'United States', 'short' => 'US', 'flag' => 'us', 'hreflang' => 'en-US', 'currency' => 'USD', 'locale' => 'en-US', 'us_english' => true,
        'zones' => [['America/New_York', 'New York (Eastern)'], ['America/Chicago', 'Chicago (Central)'], ['America/Los_Angeles', 'Los Angeles (Pacific)']],
        'title' => 'Web Design, SEO & AI for US Small Businesses | Webulex',
        'description' => 'Websites, local SEO, Google Ads and AI call agents for US small businesses. One accountable team, fixed quotes in USD and check-ins at times that suit you.',
        'h1' => 'Web design, SEO and AI automation for US small businesses',
        'intro' => 'From home services in Texas to clinics in California, US customers search, compare and book on their phones. We help small businesses show up in those searches, answer every lead fast and turn more of them into booked jobs.',
        'points' => [
            ['icon' => 'map-pin', 'title' => 'Win the "near me" search', 'text' => 'Most local buying journeys in the US start on Google Search or Maps. We optimize your Google Business Profile, service-area pages and reviews so you show up when people nearby are ready to call.'],
            ['icon' => 'phone-call', 'title' => 'Answer every call, even after hours', 'text' => 'US customers expect a fast response. An AI call agent and chatbot can answer, qualify the lead and book an appointment while your team is out on jobs.'],
            ['icon' => 'chart-line', 'title' => 'Ads that pay for themselves', 'text' => 'We set up Google Ads and Meta campaigns with call and form tracking, so you can see the cost of each lead instead of guessing.'],
        ],
        'local' => 'We work with owners across US time zones. Calls are scheduled for your morning or a time you choose, and you get a written weekly update so nothing depends on being online at the same moment.',
        'faqs' => [
            ['q' => 'Do you invoice in US dollars?', 'a' => 'Yes. Quotes and invoices for US clients are in USD.'],
            ['q' => 'How do calls work with the time difference?', 'a' => 'We agree a regular check-in slot in your morning or at another time that suits you, and keep you updated in writing between calls.'],
            ['q' => 'Can you work with my existing website?', 'a' => 'Yes. We can improve your current site, its SEO and speed, or plan a rebuild if that makes more sense.'],
        ],
    ],

    'uk' => [
        'name' => 'United Kingdom', 'short' => 'UK', 'flag' => 'gb', 'hreflang' => 'en-GB', 'currency' => 'GBP', 'locale' => 'en-GB', 'us_english' => false,
        'zones' => [['Europe/London', 'London']],
        'title' => 'Web Design, SEO & AI for UK Small Businesses | Webulex',
        'description' => 'Websites, Local SEO, Google Business Profile and AI automation for UK businesses and sole traders. Fixed quotes in GBP and a team that overlaps your day.',
        'h1' => 'Web design, SEO and AI automation for UK small businesses',
        'intro' => 'Whether you are a cleaning company in Manchester, a handyman in Bristol or a consultant in London, your next customer is probably searching on their phone right now. We help UK businesses get found, look established and follow up every enquiry without adding admin.',
        'points' => [
            ['icon' => 'building-2', 'title' => 'Stand out on Google Maps', 'text' => 'For trades and local services, the map results often matter more than anything else. We optimise your Google Business Profile, local citations and review requests for the towns you cover.'],
            ['icon' => 'receipt', 'title' => 'Rely less on paid lead sites', 'text' => 'Many UK tradespeople pay per lead on directory sites. Your own website, Local SEO and well-run Google Ads bring enquiries straight to you.'],
            ['icon' => 'shield-check', 'title' => 'Privacy handled properly', 'text' => 'Cookie banners, consent for analytics and clear privacy notices are set up with UK GDPR in mind, so your marketing respects your customers\' choices.'],
        ],
        'local' => 'The UK morning overlaps with our working afternoon in Sri Lanka, so we can usually talk during your morning and early afternoon and pick up any changes the same day.',
        'faqs' => [
            ['q' => 'Do you invoice in pounds?', 'a' => 'Yes. Quotes and invoices for UK clients are in GBP.'],
            ['q' => 'Is my website set up for UK GDPR?', 'a' => 'We include a consent banner, Google Consent Mode and a privacy notice template. We recommend you have your final privacy policy checked by a UK legal adviser.'],
            ['q' => 'Do you work with sole traders?', 'a' => 'Yes. Our Solo packages are designed for one-person businesses, from consultants and tutors to beauty professionals.'],
        ],
    ],

    'sg' => [
        'name' => 'Singapore', 'short' => 'Singapore', 'flag' => 'sg', 'hreflang' => 'en-SG', 'currency' => 'SGD', 'locale' => 'en-SG', 'us_english' => false,
        'zones' => [['Asia/Singapore', 'Singapore']],
        'title' => 'Web Development, SEO & AI for Singapore SMEs | Webulex',
        'description' => 'Websites, web apps, SEO and AI automation for Singapore SMEs. Close time-zone overlap, fixed quotes in SGD and one team for development and marketing.',
        'h1' => 'Web development, SEO and AI automation for Singapore SMEs',
        'intro' => 'Singapore businesses move quickly and expect digital tools that simply work. We build fast websites and business applications, help you get found on Google and AI assistants, and automate the follow-up so your team can focus on customers.',
        'points' => [
            ['icon' => 'smartphone', 'title' => 'Mobile-first, everywhere', 'text' => 'Customers in Singapore browse, compare and pay on their phones. We design for mobile first and keep pages fast on every connection.'],
            ['icon' => 'message-circle', 'title' => 'WhatsApp at the centre', 'text' => 'Many customers prefer to message rather than call. We connect WhatsApp Business to your website, CRM and automations so enquiries are answered and tracked.'],
            ['icon' => 'layers', 'title' => 'Custom systems, not just websites', 'text' => 'From booking portals to internal dashboards, our engineering team builds web applications around the way your business works.'],
        ],
        'local' => 'Singapore is only two and a half hours ahead of Sri Lanka, so most of your working day overlaps with ours. Quick calls and same-day replies are the norm.',
        'faqs' => [
            ['q' => 'Do you invoice in Singapore dollars?', 'a' => 'Yes. Quotes and invoices for Singapore clients are in SGD.'],
            ['q' => 'Can you build custom web applications?', 'a' => 'Yes. We build customer portals, booking and order systems, dashboards and integrations with your existing software.'],
            ['q' => 'Do you consider Singapore\'s PDPA?', 'a' => 'We design forms and data handling with the PDPA in mind, such as clear consent and limited data collection. Your own legal adviser should confirm your obligations.'],
        ],
    ],

    'au' => [
        'name' => 'Australia', 'short' => 'Australia', 'flag' => 'au', 'hreflang' => 'en-AU', 'currency' => 'AUD', 'locale' => 'en-AU', 'us_english' => false,
        'zones' => [['Australia/Sydney', 'Sydney'], ['Australia/Perth', 'Perth']],
        'title' => 'Web Design, SEO & AI for Australian Businesses | Webulex',
        'description' => 'Websites, Local SEO, Google Ads and AI call agents for Australian tradies and small businesses. Fixed quotes in AUD and support during your working day.',
        'h1' => 'Web design, SEO and AI automation for Australian businesses',
        'intro' => 'Tradies, cleaners, clinics and consultants across Australia win most of their work from local searches and word of mouth. We help you turn both into booked jobs, with a website that converts, strong local visibility and automation that follows up for you.',
        'points' => [
            ['icon' => 'wrench', 'title' => 'Built for tradies and service businesses', 'text' => 'Job request forms with photo upload, online bookings for quotes and automatic review requests help you win more local work with less time on the phone.'],
            ['icon' => 'map-pin', 'title' => 'Local SEO across your service areas', 'text' => 'We create useful pages for the suburbs and regions you cover and keep your Google Business Profile active, so you appear for searches close to home.'],
            ['icon' => 'phone-call', 'title' => 'Never miss a call on site', 'text' => 'An AI call agent answers when you cannot, takes the job details and books a time, then sends you a summary.'],
        ],
        'local' => 'Our working day in Sri Lanka lines up with the Australian afternoon on the east coast and much of the day in Perth, so we are available while you are still on the clock.',
        'faqs' => [
            ['q' => 'Do you invoice in Australian dollars?', 'a' => 'Yes. Quotes and invoices for Australian clients are in AUD.'],
            ['q' => 'Do you work with tradies?', 'a' => 'Yes. Our handyman and cleaning packages are built for trades and home services, and we tailor them for other trades too.'],
            ['q' => 'How do you handle daylight saving?', 'a' => 'Our time-zone table and meeting invites follow your local time automatically, including daylight saving changes in New South Wales, Victoria and other states.'],
        ],
    ],
];
