<?php
declare(strict_types=1);

// Drafted page copy for each service and area (BRIEF.md §7.3–7.4).
// REVIEW(owner): every 'for', 'outcomes' and 'faqs' entry below is a draft written for the owner to check.
// Keep claims factual: no promised rankings, lead numbers or timelines.

return [
    // Area-level process (used by each service unless it sets its own 'process') and area FAQs.
    'areas' => [
        'build' => [
            'process' => [
                ['title' => 'Discover and scope', 'text' => 'We learn how your business works and agree what to build, with a fixed quote.'],
                ['title' => 'Design and prototype', 'text' => 'You see the layout and key screens before any build starts, and tell us what to change.'],
                ['title' => 'Build and test', 'text' => 'We develop, test on real devices and check speed, security and accessibility.'],
                ['title' => 'Launch and support', 'text' => 'We go live, train you on the basics and stay on hand for updates and fixes.'],
            ],
            // REVIEW(owner)
            'faqs' => [
                ['q' => 'Do I own the website or app you build?', 'a' => 'Yes. The domain, hosting account, code and content are set up in your name.'],
                ['q' => 'Can I update the content myself?', 'a' => 'Yes. We build on an easy-to-edit CMS where it suits the project and show you how to make everyday changes.'],
                ['q' => 'Can you work on an existing website or system?', 'a' => 'Yes. We can review what you have, fix problems, add features or plan a rebuild if that is the better option.'],
            ],
        ],
        'grow' => [
            'process' => [
                ['title' => 'Audit and research', 'text' => 'We review your site, your competitors and what your customers search for.'],
                ['title' => 'Fix and optimise', 'text' => 'We fix technical issues and improve your pages, listings and structured data.'],
                ['title' => 'Publish and build authority', 'text' => 'Regular content, citations and reviews build trust with search engines and AI assistants.'],
                ['title' => 'Measure and report', 'text' => 'You get a clear monthly report on rankings, traffic and enquiries.'],
            ],
            // REVIEW(owner)
            'faqs' => [
                ['q' => 'How long does SEO take to work?', 'a' => 'Technical fixes can help quickly, but steady growth in rankings usually builds over several months. We report progress every month so you can see the trend.'],
                ['q' => 'Can you guarantee a number one ranking?', 'a' => 'No one can honestly guarantee rankings, because search engines decide them. We focus on the work that improves your chances and report the results openly.'],
                ['q' => 'What is the difference between SEO and AIEO?', 'a' => 'SEO helps you rank in search results. AIEO helps AI assistants such as ChatGPT, Gemini and Google AI Overviews understand and recommend your business. We do both together.'],
            ],
        ],
        'promote' => [
            'process' => [
                ['title' => 'Strategy and audience', 'text' => 'We agree your goals, your ideal customers and the platforms that reach them.'],
                ['title' => 'Create content and campaigns', 'text' => 'We plan, design and write posts, videos and ads in your brand style.'],
                ['title' => 'Launch and manage', 'text' => 'We publish, run campaigns and handle comments and messages day to day.'],
                ['title' => 'Optimise and report', 'text' => 'We test, adjust budgets and send you a clear monthly report.'],
            ],
            // REVIEW(owner)
            'faqs' => [
                ['q' => 'Is the ad budget included in your fee?', 'a' => 'No. Advertising budgets are paid directly to Google, Meta or the other platforms, so you always see exactly what is spent. Our management fee is separate.'],
                ['q' => 'Which social platforms should my business use?', 'a' => 'It depends on where your customers spend time. We recommend a focused set of platforms in your plan rather than trying to be everywhere.'],
                ['q' => 'Do I approve content before it goes out?', 'a' => 'Yes. We share a monthly content calendar for your approval before anything is published.'],
            ],
        ],
        'automate' => [
            'process' => [
                ['title' => 'Map your processes', 'text' => 'We look at how leads, bookings and admin flow through your business today.'],
                ['title' => 'Design the workflow', 'text' => 'We propose what to automate, which tools to use and where people stay in the loop.'],
                ['title' => 'Build, connect and test', 'text' => 'We build the automations and AI agents, connect your apps and test with real scenarios.'],
                ['title' => 'Train, launch and monitor', 'text' => 'We train your team, go live and keep an eye on everything running smoothly.'],
            ],
            // REVIEW(owner)
            'faqs' => [
                ['q' => 'Will AI replace my staff?', 'a' => 'Our aim is to take repetitive work off your team, such as answering common questions, booking and follow-ups, so people can focus on customers and the work itself.'],
                ['q' => 'Is my customer data safe?', 'a' => 'We design automations with security and privacy in mind, use reputable providers, limit who can access data and can self-host tools such as n8n where that suits you.'],
                ['q' => 'What ongoing costs are there?', 'a' => 'Some tools have their own subscriptions or usage costs, such as AI call minutes or messages. We list these separately in your quote.'],
            ],
        ],
    ],

    // Per-service drafts. REVIEW(owner) applies to every entry.
    'services' => [
        // ---------- BUILD ----------
        'website-development' => [
            'for' => 'new and established businesses that need a professional site that brings in enquiries',
            'outcomes' => ['A fast, mobile-friendly website that makes a strong first impression.', 'Clear calls to action that turn visitors into calls, bookings and enquiries.', 'A site you can update yourself, built on solid technical foundations for SEO.'],
            'faqs' => [
                ['q' => 'Do you use WordPress or custom code?', 'a' => 'Either. WordPress suits most marketing sites that you want to edit yourself; custom builds suit sites with special features. We recommend the right fit in your proposal.'],
                ['q' => 'Will my website work on phones?', 'a' => 'Yes. Every site is designed for mobile first and tested on phones, tablets and desktops.'],
                ['q' => 'Can you move my existing website content across?', 'a' => 'Yes. We can migrate your existing pages and images and set up redirects so you keep your search visibility.'],
            ],
        ],
        'custom-web-applications' => [
            'for' => 'businesses whose processes no longer fit off-the-shelf software',
            'outcomes' => ['A system shaped around your workflow, not the other way round.', 'Less manual admin and fewer errors, with the right people seeing the right data.', 'A secure, documented application that can grow with your business.'],
            'faqs' => [
                ['q' => 'What kind of applications do you build?', 'a' => 'Customer portals, booking and order systems, internal dashboards, admin panels and tools that connect your existing software.'],
                ['q' => 'Which technologies do you use?', 'a' => 'Mainly Laravel, PHP, Python and modern JavaScript, deployed on secure cloud hosting. We choose based on your needs and long-term maintenance.'],
                ['q' => 'Do we get the source code?', 'a' => 'Yes. The code and documentation are yours, so you are never locked in.'],
            ],
        ],
        'ecommerce-development' => [
            'for' => 'retailers and brands ready to sell online or improve an existing store',
            'outcomes' => ['A store that is easy for customers to browse, trust and buy from.', 'Simple day-to-day management of products, stock and orders.', 'Automatic order and abandoned-cart messages that help recover sales.'],
            'faqs' => [
                ['q' => 'Shopify, WooCommerce or custom: which is best?', 'a' => 'Shopify is quick and fully hosted, WooCommerce is flexible and runs on WordPress, and custom suits unusual requirements. We help you choose based on products, budget and growth plans.'],
                ['q' => 'Can I sell internationally?', 'a' => 'Yes. We can set up multiple currencies, international payment gateways, tax rules and shipping zones.'],
                ['q' => 'Can you connect the store to Google Shopping and Meta?', 'a' => 'Yes. We can set up product feeds for Google Shopping and Meta catalogues so your products can appear in ads.'],
            ],
        ],
        'integration-support' => [
            'for' => 'businesses that re-key data between systems or have an existing app that needs work',
            'outcomes' => ['Data that flows between your website, CRM, accounts and other tools automatically.', 'Less double entry and fewer mistakes.', 'Existing systems fixed, improved and documented.'],
            'faqs' => [
                ['q' => 'Can you connect systems that have no ready-made integration?', 'a' => 'Often yes, using their APIs or a custom connector. We check what each system allows before quoting.'],
                ['q' => 'Can you take over a system another developer built?', 'a' => 'Yes. We start with a review of the code and hosting, then agree a plan for fixes and improvements.'],
                ['q' => 'Do you migrate data between platforms?', 'a' => 'Yes. We plan the migration, test it on a copy first and check the results with you before switching over.'],
            ],
        ],
        'payment-gateway-integration' => [
            'for' => 'businesses that want to take card payments, deposits or subscriptions online',
            'outcomes' => ['Customers can pay securely online in a few clicks.', 'Deposits and subscriptions collected automatically, with less chasing.', 'Payments that match up with your orders, bookings and accounts.'],
            'faqs' => [
                ['q' => 'Which payment gateways do you work with?', 'a' => 'Stripe, PayPal and Square, plus local gateways depending on your country.'],
                ['q' => 'Do you handle card data?', 'a' => 'No. Card details are handled by the payment provider on their secure checkout, which keeps your compliance simpler.'],
                ['q' => 'Can customers pay a deposit when they book?', 'a' => 'Yes. We can add deposits or full payment to booking forms, quotes and invoices.'],
            ],
        ],
        'ui-ux-branding' => [
            'for' => 'new businesses and those whose look has become inconsistent',
            'outcomes' => ['A recognisable brand that looks consistent everywhere.', 'Interfaces that are clear and easy to use.', 'Templates and guidelines that keep future marketing on brand.'],
            'faqs' => [
                ['q' => 'Do you design logos?', 'a' => 'Yes. We design logos and simple brand identities, and supply files for web, social media and print.'],
                ['q' => 'Will I see designs before they are built?', 'a' => 'Yes. We share wireframes and clickable prototypes so you can try the experience before development.'],
                ['q' => 'What do brand guidelines include?', 'a' => 'Logo use, colours, fonts, tone of voice and example layouts, so anyone can create on-brand material.'],
            ],
        ],
        'website-care-hosting' => [
            'for' => 'businesses that want their website looked after without thinking about it',
            'outcomes' => ['A website that stays online, secure and up to date.', 'Small content changes handled for you.', 'One team to call when something needs attention.'],
            'faqs' => [
                ['q' => 'What does a care plan include?', 'a' => 'Hosting or hosting management, domain renewals, updates, backups, uptime monitoring and a set number of hours for changes each month.'],
                ['q' => 'Can you look after a site you did not build?', 'a' => 'Yes. We start with a health check, then take over updates, backups and monitoring.'],
                ['q' => 'Who owns the domain and hosting?', 'a' => 'You do. We manage them on your behalf, in your name.'],
            ],
        ],
        'security-speed' => [
            'for' => 'businesses with a slow, outdated or compromised website',
            'outcomes' => ['Faster pages that keep visitors on your site.', 'A hardened site with fewer weak points for attackers.', 'Alerts if your site goes down, so problems are caught early.'],
            'faqs' => [
                ['q' => 'My website has been hacked. Can you help?', 'a' => 'Yes. We clean up the malware, close the gap that let it in, restore from a safe backup where possible and harden the site.'],
                ['q' => 'What are Core Web Vitals?', 'a' => "They are Google's measures of how fast and stable a page feels to visitors. We tune your site to improve them."],
                ['q' => 'Will speed work change how my site looks?', 'a' => 'Usually not. Most improvements happen behind the scenes, such as image compression, caching and cleaner code.'],
            ],
        ],

        // ---------- GROW ----------
        'seo' => [
            'for' => 'businesses that want more customers to find them through Google',
            'outcomes' => ['Better visibility for the searches your customers actually make.', 'A technically healthy site that search engines can crawl and understand.', 'Monthly reports that show rankings, traffic and enquiries.'],
            'faqs' => [
                ['q' => 'What does SEO work involve each month?', 'a' => 'Keyword research, technical fixes, improving page content and metadata, building quality links and reporting on results.'],
                ['q' => 'How do you build backlinks?', 'a' => 'Through genuine, relevant sources such as directories, partners, local organisations and useful content. We avoid paid link schemes.'],
                ['q' => 'Do I need a new website for SEO?', 'a' => 'Not always. We can often improve your existing site. If it has serious technical limits, we will tell you.'],
            ],
        ],
        'aieo' => [
            'for' => 'businesses that want to be recommended by AI assistants as well as search engines',
            'outcomes' => ['AI assistants have accurate, consistent information about your business.', 'Answer-focused content that AI tools can quote.', 'Tracking that shows how often your brand appears in AI answers.'],
            'faqs' => [
                ['q' => 'What does AIEO stand for?', 'a' => 'AI Engine Optimisation: improving how AI assistants such as ChatGPT, Gemini, Perplexity and Google AI Overviews understand and recommend your business.'],
                ['q' => 'How is AIEO done?', 'a' => 'Through structured data, clear answer-style content, consistent business details across the web and mentions on sources that AI tools trust.'],
                ['q' => 'Can you control what AI assistants say?', 'a' => 'No one can control AI answers directly. We improve the quality and consistency of the information they draw on, which raises your chances of being recommended.'],
            ],
        ],
        'local-seo' => [
            'for' => 'businesses that serve customers in a particular town, city or area',
            'outcomes' => ['Better visibility on Google Maps and in "near me" searches.', 'Consistent business details across directories.', 'A steady flow of new reviews that builds local trust.'],
            'faqs' => [
                ['q' => 'What is the local pack?', 'a' => 'The map and three business listings Google shows for local searches. Local SEO improves your chances of appearing there.'],
                ['q' => 'I serve several areas. Can you help?', 'a' => 'Yes. We create useful pages for each area or branch and target local keywords for each.'],
                ['q' => 'How do you help with reviews?', 'a' => 'We set up simple ways to ask happy customers for reviews and help you reply to them, within the platforms\' rules.'],
            ],
        ],
        'google-business-profile' => [
            'for' => 'any business that serves local customers',
            'outcomes' => ['A complete, accurate profile that stands out on Google Search and Maps.', 'Regular posts and photos that show you are active.', 'Reviews and questions answered promptly.'],
            'faqs' => [
                ['q' => 'I do not have a Google Business Profile yet. Can you set one up?', 'a' => 'Yes. We create it, help you through verification and optimise every section.'],
                ['q' => 'Can I have a profile without a shop front?', 'a' => 'Yes. Service-area businesses can hide their address and show the areas they cover instead.'],
                ['q' => 'Will you reply to reviews for me?', 'a' => 'We can draft and post replies in your voice, and flag anything that needs your personal attention.'],
            ],
        ],
        'seo-blog-posting' => [
            'for' => 'businesses that want to build authority and organic traffic over time',
            'outcomes' => ['A regular stream of useful articles your customers are searching for.', 'More pages that can rank and be quoted by AI assistants.', 'Content you can share on social media and in emails.'],
            'faqs' => [
                ['q' => 'Who writes the articles?', 'a' => 'Our team researches and writes each post, and you can review it before it is published.'],
                ['q' => 'How do you choose topics?', 'a' => 'From keyword research, common customer questions and gaps in your competitors\' content.'],
                ['q' => 'Do you publish the posts for us?', 'a' => 'Yes. We format, add images and internal links, and schedule them on your website.'],
            ],
        ],
        'analytics-tracking' => [
            'for' => 'businesses that want to know which marketing actually brings in leads and sales',
            'outcomes' => ['Accurate tracking of enquiries, calls, bookings and sales.', 'Clear dashboards instead of guesswork.', 'Better decisions about where to spend your marketing budget.'],
            'faqs' => [
                ['q' => 'What do you set up?', 'a' => 'Google Analytics 4, Search Console, Google Tag Manager, conversion tracking for forms and calls, and the Meta Pixel where needed.'],
                ['q' => 'Is tracking compliant with privacy laws?', 'a' => 'We set up consent banners and Google Consent Mode so tracking respects visitors\' choices in the UK, EU and elsewhere.'],
                ['q' => 'Can I see results live?', 'a' => 'Yes. We build a Looker Studio dashboard you can open at any time.'],
            ],
        ],
        'landing-pages' => [
            'for' => 'businesses running ads or campaigns that need pages built to convert',
            'outcomes' => ['Focused pages that turn ad clicks into enquiries.', 'Leads that go straight into your CRM.', 'Ongoing tests that improve results over time.'],
            'faqs' => [
                ['q' => 'Why not send ad traffic to my home page?', 'a' => 'A landing page focuses on one offer and one action, which usually makes it easier for visitors to enquire.'],
                ['q' => 'What is split testing?', 'a' => 'Showing two versions of a page or offer to different visitors to see which performs better, then keeping the winner.'],
                ['q' => 'Can landing pages connect to my CRM?', 'a' => 'Yes. Form submissions can go straight into your CRM and trigger automatic follow-ups.'],
            ],
        ],

        // ---------- PROMOTE ----------
        'social-media-management' => [
            'for' => 'businesses that want an active, professional presence without spending hours on it',
            'outcomes' => ['Consistent, on-brand posts every month.', 'Messages and comments handled promptly.', 'A clear view of what content works, from monthly reports.'],
            'faqs' => [
                ['q' => 'Which platforms do you manage?', 'a' => 'Facebook, Instagram, LinkedIn and X. The number of platforms depends on your plan.'],
                ['q' => 'How many posts do you publish?', 'a' => 'It depends on your plan. We agree the number and mix of posts in your monthly content calendar.'],
                ['q' => 'Do you reply to messages?', 'a' => 'Yes. We moderate comments and messages and pass on enquiries or anything that needs your input.'],
            ],
        ],
        'social-media-advertising' => [
            'for' => 'businesses that want to reach new customers on social media with paid campaigns',
            'outcomes' => ['Ads shown to the people most likely to become customers.', 'Retargeting that reminds past visitors to come back.', 'Budgets moved towards what performs best.'],
            'faqs' => [
                ['q' => 'Which platforms do you advertise on?', 'a' => 'Meta (Facebook and Instagram), LinkedIn, X and TikTok, depending on your audience.'],
                ['q' => 'What budget do I need?', 'a' => 'It depends on your goals and market. We recommend a starting budget in your plan, and the budget is paid directly to the platform.'],
                ['q' => 'Do you create the ads?', 'a' => 'Yes. We write the copy and design images or short videos for each campaign.'],
            ],
        ],
        'youtube-channel-management' => [
            'for' => 'businesses that use, or want to start using, video to build trust',
            'outcomes' => ['A professional, well-organised channel.', 'Videos that are easier to find in YouTube and Google search.', 'Monthly insight into views, watch time and subscribers.'],
            'faqs' => [
                ['q' => 'Do you film the videos?', 'a' => 'We focus on channel management, optimisation and editing. You or your videographer supply the footage, and we can advise on what to film.'],
                ['q' => 'Do you make YouTube Shorts?', 'a' => 'Yes. We can cut Shorts from your longer videos and publish them.'],
                ['q' => 'What is YouTube SEO?', 'a' => 'Optimising titles, descriptions, tags, thumbnails and playlists so your videos appear for relevant searches.'],
            ],
        ],
        'google-ads' => [
            'for' => 'businesses that want to appear when customers search for their services right now',
            'outcomes' => ['Your business shown at the moment people search for what you offer.', 'Every call, form and sale from ads tracked.', 'Ongoing optimisation of keywords, bids and ads.'],
            'faqs' => [
                ['q' => 'Which campaign types do you run?', 'a' => 'Search, Display, YouTube, Shopping and Performance Max, chosen to suit your goals.'],
                ['q' => 'Is the ad spend included?', 'a' => 'No. You pay Google directly for clicks, and our management fee is separate.'],
                ['q' => 'How do you measure results?', 'a' => 'We set up conversion tracking for calls, forms, bookings and sales, and report cost per lead or sale.'],
            ],
        ],
        'creative-design' => [
            'for' => 'businesses that need professional visuals for social media, ads and print',
            'outcomes' => ['Eye-catching designs that match your brand.', 'Short videos and reels ready for social media.', 'Print materials that look as good as your online presence.'],
            'faqs' => [
                ['q' => 'What can you design?', 'a' => 'Social posts and stories, reels and short videos, ad banners, brochures, flyers and presentations.'],
                ['q' => 'Do we get the source files?', 'a' => 'Yes. You receive final files for each use, and source files on request.'],
                ['q' => 'How many changes can I ask for?', 'a' => 'We include rounds of revisions in every quote so you are happy with the result.'],
            ],
        ],
        'email-whatsapp-marketing' => [
            'for' => 'businesses that want more repeat customers and referrals',
            'outcomes' => ['Regular newsletters that keep you in mind.', 'Automatic welcome and follow-up messages.', 'WhatsApp broadcasts and catalogues customers can act on quickly.'],
            'faqs' => [
                ['q' => 'Which email platforms do you use?', 'a' => 'Common tools such as Mailchimp, Brevo or the email features in your CRM. We recommend one in your plan.'],
                ['q' => 'Is WhatsApp marketing allowed?', 'a' => 'Yes, through WhatsApp Business with customers who have agreed to hear from you. We follow the platform\'s rules.'],
                ['q' => 'How do I grow my list?', 'a' => 'Through sign-up forms on your website, offers, and collecting consent at checkout or booking.'],
            ],
        ],

        // ---------- AUTOMATE ----------
        'n8n-automation' => [
            'for' => 'businesses losing hours to repetitive admin between apps',
            'outcomes' => ['Repetitive tasks handled automatically, around the clock.', 'Leads, quotes and invoices that move without copy and paste.', 'Instant notifications to the right person on the right channel.'],
            'faqs' => [
                ['q' => 'What is n8n?', 'a' => 'A workflow automation tool that connects your apps, data and AI services. It can run in the cloud or on your own server.'],
                ['q' => 'What can be automated?', 'a' => 'Lead capture, quotes, invoices, reminders, notifications, data entry and AI processing of emails and documents are common examples.'],
                ['q' => 'What happens if something breaks?', 'a' => 'We add error alerts and logging, and can monitor your workflows as part of a support plan.'],
            ],
        ],
        'ai-chatbots-call-agents' => [
            'for' => 'busy businesses that miss calls or messages while they work',
            'outcomes' => ['Every chat and call answered, day or night.', 'Appointments booked straight into your calendar.', 'Clear hand-over to your team when a person is needed.'],
            'faqs' => [
                ['q' => 'Will customers know they are talking to AI?', 'a' => 'We recommend being open about it. The assistant introduces itself and hands over to a person whenever needed.'],
                ['q' => 'What does the AI know about my business?', 'a' => 'We train it on your services, prices, policies and FAQs, and keep it up to date as things change.'],
                ['q' => 'Where can the chatbot run?', 'a' => 'On your website, WhatsApp and Facebook Messenger. Call agents answer and return phone calls.'],
            ],
        ],
        'ai-agents-integration' => [
            'for' => 'businesses that want AI built into their own systems and data',
            'outcomes' => ['AI features that fit inside the tools your team already uses.', 'Faster handling of documents and data.', 'AI that can answer questions using your own data, securely.'],
            'faqs' => [
                ['q' => 'What is an MCP connector?', 'a' => 'A Model Context Protocol connector lets AI assistants query your systems and data in a controlled way.'],
                ['q' => 'Which AI models do you use?', 'a' => 'We choose leading models from established providers based on the task, cost and data requirements.'],
                ['q' => 'How do you protect our data?', 'a' => 'We limit what data the AI can see, use providers with clear data policies and keep audit trails where needed.'],
            ],
        ],
        'crm-setup' => [
            'for' => 'businesses tracking leads in spreadsheets, inboxes or their heads',
            'outcomes' => ['Every lead and customer in one place.', 'Pipelines that show exactly where each deal stands.', 'Automatic follow-ups so nothing is forgotten.'],
            'faqs' => [
                ['q' => 'Which CRM should I use?', 'a' => 'HubSpot and Zoho suit most small businesses. For special needs we can build a custom CRM. We recommend one after learning how you sell.'],
                ['q' => 'Can you import my existing contacts?', 'a' => 'Yes. We clean and import contacts from spreadsheets, email and other systems.'],
                ['q' => 'Will my team get training?', 'a' => 'Yes. We train your team and provide simple guides for everyday tasks.'],
            ],
        ],
        'business-email-workspace' => [
            'for' => 'businesses using free email addresses or messy shared accounts',
            'outcomes' => ['Professional email on your own domain.', 'Shared calendars, files and video calls for your team.', 'Better security and spam protection.'],
            'faqs' => [
                ['q' => 'Google Workspace or Microsoft 365?', 'a' => 'Both work well. Google Workspace suits teams that like Gmail and Google Docs; Microsoft 365 suits teams that use Outlook and Office.'],
                ['q' => 'Will I lose my old emails?', 'a' => 'No. We migrate existing email, contacts and calendars to the new accounts.'],
                ['q' => 'Who pays for the licences?', 'a' => 'Licences are billed by Google or Microsoft per user. We set them up in your name.'],
            ],
        ],
        'it-consultancy' => [
            'for' => 'businesses planning new systems, a move to the cloud or better security',
            'outcomes' => ['A clear technology plan you can act on.', 'The right systems chosen for your size and budget.', 'Practical security improvements that reduce risk.'],
            'faqs' => [
                ['q' => 'What does a technology roadmap include?', 'a' => 'A review of your current systems, recommended changes, priorities, rough costs and a timeline.'],
                ['q' => 'Do you help move to the cloud?', 'a' => 'Yes. We plan and carry out migrations to cloud hosting such as AWS.'],
                ['q' => 'Can you review our cybersecurity?', 'a' => 'Yes. We review accounts, devices, backups and websites, and recommend practical improvements.'],
            ],
        ],
    ],
];
