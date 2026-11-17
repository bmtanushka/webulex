<?php
declare(strict_types=1);

// Industry pages: BRIEF.md §7.6.
// To add an industry, add an entry here; the menus, routes, sitemap and cross-links pick it up automatically.
// Each tier's 'items' are the NEW items for that tier; higher tiers include everything in the tier before.
// 'services' lists the service slugs covered by any tier (used for cross-links).

$common = ['website-development', 'google-business-profile', 'social-media-management', 'business-email-workspace', 'local-seo', 'aieo', 'seo-blog-posting', 'google-ads', 'social-media-advertising', 'ai-chatbots-call-agents', 'crm-setup', 'n8n-automation', 'landing-pages', 'payment-gateway-integration'];

return [
    'cleaning-companies' => [
        // Illustrative UI labels for the hero art (decorative).
        'chips' => [['calendar-check', 'New booking · Fri 09:00'], ['inbox', 'Quote request received'], ['star', 'New 5-star review']],
        'business_noun' => 'cleaning',
        'title' => 'Cleaning companies',
        'kicker' => 'For cleaning companies',
        'headline' => ['More bookings.', 'Less admin.'],
        'intro' => 'Digital packages for domestic and commercial cleaning businesses. Get found by local customers, take bookings and quote requests online, and keep regular clients coming back automatically.',
        'illustration' => 'cleaning',
        'icon' => 'sparkles',
        'problems' => [
            ['icon' => 'phone-call', 'problem' => 'Missed calls mean missed jobs', 'solution' => 'AI call agent and chatbot answer 24/7 and book cleans while your team is on site.'],
            ['icon' => 'clock', 'problem' => 'Quoting takes too long', 'solution' => 'An online quote form asks for property size, rooms and frequency.'],
            ['icon' => 'map-pin', 'problem' => 'Hard to stand out locally', 'solution' => 'Google Business Profile, Local SEO and reviews help you appear for "cleaners near me".'],
            ['icon' => 'refresh-cw', 'problem' => 'Regular clients drift away', 'solution' => 'Booking reminders, rebooking prompts and review requests after every clean.'],
        ],
        'tiers' => [
            ['name' => 'Clean Start', 'timeline' => '4–6 weeks', 'tagline' => 'Get online and look professional', 'ideal' => 'Ideal for new or single-team cleaning businesses.',
             'items' => ['Website with services, areas covered and pricing guide', 'Online quote request form', 'Google Business Profile setup', 'Facebook and Instagram page setup', 'WhatsApp click-to-chat', 'Business email', 'One-time on-page SEO']],
            ['name' => 'Clean Growth', 'timeline' => '3 months', 'tagline' => 'Fill your diary with local bookings', 'popular' => true, 'ideal' => 'Ideal for established cleaners who want steady weekly bookings.',
             'items' => ['Online booking including recurring cleans', 'Local SEO and service-area pages', 'AIEO', 'Google Ads for local searches', 'Facebook and Instagram ads', 'SEO-friendly blog posts', 'Booking reminders by SMS or WhatsApp', 'Automatic review requests', 'Monthly report']],
            ['name' => 'Clean Pro', 'timeline' => '4 months', 'tagline' => 'Complete business launch', 'ideal' => 'Ideal for growing firms with several teams or commercial clients.',
             'items' => ['AI chatbot that quotes and books cleans', 'AI call agent for calls and callbacks', 'CRM for leads, clients and contracts', 'Automated follow-up of open quotes', 'Landing pages for deep, end-of-tenancy and office cleans', 'Lead collection from ads into the CRM', 'Staff training and handover']],
        ],
        'addons' => ['Before-and-after gallery and social posts', 'Commercial proposal and contract templates', 'Online payments and deposits at booking', 'Logo and van/uniform branding', 'Google Workspace or Microsoft 365 email'],
        'cta' => 'Ready to grow your cleaning business?',
        // REVIEW(owner): drafted FAQs.
        'faqs' => [
            ['q' => 'Can customers book recurring cleans online?', 'a' => 'Yes. From Clean Growth upwards, customers can book one-off or recurring cleans and receive automatic reminders.'],
            ['q' => 'Do you work with commercial cleaning companies?', 'a' => 'Yes. Clean Pro suits firms with commercial clients, with landing pages for office cleans, a CRM for contracts and proposal templates as an add-on.'],
            ['q' => 'Can the AI agent give a price?', 'a' => 'It can give guide prices based on the rules you set, such as rooms and frequency, and pass anything unusual to your team.'],
        ],
        'services' => $common,
    ],

    'handyman-services' => [
        // Illustrative UI labels for the hero art (decorative).
        'chips' => [['image', 'Job photos received'], ['calendar-check', 'Site visit booked · Tue'], ['circle-check', 'Quote accepted']],
        'business_noun' => 'handyman',
        'title' => 'Handyman services',
        'kicker' => 'For handymen and home repair',
        'headline' => ['Get the call.', 'Win the job.'],
        'intro' => 'Digital packages for handymen, home repair and maintenance businesses. We help local customers find you, send job details with photos, and get followed up automatically, so you can stay on the tools instead of the phone.',
        'illustration' => 'handyman',
        'icon' => 'wrench',
        'problems' => [
            ['icon' => 'phone-call', 'problem' => "You can't answer the phone up a ladder", 'solution' => 'An AI call agent answers every call, takes job details and books a site visit.'],
            ['icon' => 'image', 'problem' => 'Customers want a price first', 'solution' => 'A job request form with photo upload lets you quote many jobs without a visit.'],
            ['icon' => 'receipt', 'problem' => 'Lead sites take a cut', 'solution' => 'Your own Google profile, Local SEO and Google Ads bring enquiries straight to you.'],
            ['icon' => 'refresh-cw', 'problem' => 'Repeat work slips away', 'solution' => 'Review requests, job follow-ups and seasonal maintenance reminders.'],
        ],
        'tiers' => [
            ['name' => 'Handy Start', 'timeline' => '4–6 weeks', 'tagline' => 'Look trusted and easy to contact', 'ideal' => 'Ideal for sole handymen and new repair businesses.',
             'items' => ['Website with services, areas covered and past-work gallery', 'Job request form with photo upload', 'Google Business Profile setup', 'Facebook page setup', 'WhatsApp click-to-chat', 'Business email', 'One-time on-page SEO']],
            ['name' => 'Handy Growth', 'timeline' => '3 months', 'tagline' => 'More local jobs, every week', 'popular' => true, 'ideal' => 'Ideal for busy tradespeople who want a steady flow of local work.',
             'items' => ['Online booking for site visits', 'Local SEO and area pages', 'AIEO', 'Google Ads for local job searches', 'Facebook and Instagram ads', 'Monthly project posts from your photos', 'Automatic review requests', 'Monthly report']],
            ['name' => 'Handy Pro', 'timeline' => '4 months', 'tagline' => 'Complete business launch', 'ideal' => 'Ideal for small repair firms with a team or several trades.',
             'items' => ['AI call agent', 'AI chatbot that captures jobs and books visits', 'CRM job pipeline from enquiry to completion', 'Automated quote follow-up', 'Seasonal maintenance reminders', 'Invoice and payment-link automation', 'Landing pages for top services', 'Staff training and handover']],
        ],
        'addons' => ['Online payments and deposits', 'Branded quote and invoice templates', 'Van signage, uniform and leaflet designs', '"How we did it" short videos', 'Google Workspace or Microsoft 365 email'],
        'cta' => 'Ready for more jobs and fewer missed calls?',
        // REVIEW(owner): drafted FAQs.
        'faqs' => [
            ['q' => 'Can customers send photos of the job?', 'a' => 'Yes. Every tier includes a job request form with photo upload, so you can often quote without a visit.'],
            ['q' => 'Will this replace lead websites I pay for?', 'a' => 'Many tradespeople use it to rely less on lead sites. Your own profile, website and ads bring enquiries directly to you, without a per-lead fee to a third party.'],
            ['q' => 'I work alone. Is Handy Start enough?', 'a' => 'It is designed for sole handymen. You can move up to Handy Growth when you want more local jobs each week.'],
        ],
        'services' => $common,
    ],

    'sole-traders' => [
        // Illustrative UI labels for the hero art (decorative).
        'chips' => [['calendar-check', 'Appointment booked'], ['credit-card', 'Deposit paid'], ['bell', 'Reminder sent']],
        'business_noun' => 'one-person',
        'title' => 'Sole traders',
        'kicker' => 'For sole traders and one-person businesses',
        'headline' => ['Look established.', 'Work smarter.'],
        'intro' => 'For consultants, tutors, coaches, beauty and wellness professionals, photographers and freelancers. Look as professional as a larger firm, get found online and let automation handle the admin.',
        'illustration' => 'solo',
        'icon' => 'user',
        'problems' => [
            ['icon' => 'user', 'problem' => 'You are the whole team', 'solution' => 'Automation handles bookings, reminders and follow-ups.'],
            ['icon' => 'briefcase', 'problem' => 'Hard to look established', 'solution' => 'A professional website, simple branding and business email.'],
            ['icon' => 'share-2', 'problem' => 'No time for social media', 'solution' => 'We plan, design and post your content.'],
            ['icon' => 'inbox', 'problem' => 'Enquiries arrive everywhere', 'solution' => 'Website, WhatsApp and social enquiries in one simple CRM.'],
        ],
        'tiers' => [
            ['name' => 'Solo Start', 'timeline' => '3–4 weeks', 'tagline' => 'Your professional online home', 'ideal' => 'Ideal for freelancers and professionals starting out.',
             'items' => ['Personal brand website (up to 4 pages)', 'Simple logo and brand colours', 'Online booking calendar', 'Business email', 'Google Business Profile setup', 'LinkedIn and one social page setup', 'One-time on-page SEO']],
            ['name' => 'Solo Growth', 'timeline' => '3 months', 'tagline' => 'Get found and stay visible', 'popular' => true, 'ideal' => 'Ideal for established sole traders who want more clients.',
             'items' => ['Local SEO and AIEO', 'SEO-friendly blog posts', 'Social media management on two platforms', 'Google or Meta ads on one platform', 'Email newsletter setup', 'Automatic review requests', 'Monthly report']],
            ['name' => 'Solo Pro', 'timeline' => '4 months', 'tagline' => 'Complete business launch', 'ideal' => 'Ideal for busy one-person businesses ready to scale.',
             'items' => ['AI chatbot that answers and books appointments', 'AI call agent for missed calls', 'Simple CRM', 'Automated reminders and follow-ups', 'Online payments and deposit links', 'Landing page for your main offer', 'Training and handover']],
        ],
        'addons' => ['LinkedIn profile optimisation', 'Online course or digital product sales', 'Client portal for files', 'Google Workspace or Microsoft 365 email', 'Website care and hosting plan'],
        'cta' => 'Ready to grow your business, without the admin?',
        // REVIEW(owner): drafted FAQs.
        'faqs' => [
            ['q' => 'I am just starting out. Where should I begin?', 'a' => 'Solo Start gives you a professional website, booking calendar, business email and simple branding, so you look established from day one.'],
            ['q' => 'Can clients book and pay online?', 'a' => 'Every tier includes an online booking calendar. Solo Pro adds online payments and deposit links.'],
            ['q' => 'Will I have to manage complicated software?', 'a' => 'No. We set things up to be simple, train you on the basics and stay on hand if you need help.'],
        ],
        'services' => array_merge($common, ['ui-ux-branding', 'email-whatsapp-marketing']),
    ],
];
