<?php

return [
    'name'      => 'myPOS',
    'url'       => env('APP_URL', 'https://mypos.pk'),
    'phone'     => '+92 322 476 5528',
    'phone_raw' => '+923224765528',
    'whatsapp'  => '923224765528',
    'email'     => 'info@mypos.pk',
    'address'   => 'Office No. 1, Midlane Plaza, Ghazni Lane, New Super Town, Lahore, Pakistan',
    'hours'     => 'Mon–Fri, 10:00 am – 18:00 pm (Pakistan Standard Time)',
    'register_url' => 'https://erp.mypos.pk/business/register',
    // Keep the whole site out of search engines (meta robots + X-Robots-Tag on every response + robots.txt).
    // Set SITE_NOINDEX=false in .env on launch day.
    'noindex' => env('SITE_NOINDEX', true),

    // Serve not-yet-migrated /uploads files from the old WordPress server (see routes/web.php).
    'remote_uploads' => env('SITE_REMOTE_UPLOADS', true),
    'free_download' => 'https://drive.google.com/open?id=1EQBjuP8GQZDwOKGs09rf81bU56QD-2mM&usp=drive_fs',

    // Where website enquiries are emailed (stored in the `leads` table either way).
    'leads_email' => env('LEADS_EMAIL', 'info@mypos.pk'),

    // Businesses running myPOS, shown on the client logo strip (the clients table only holds the showcased ones).
    'clients_total' => 1200,

    // myPOS mobile app on the home page "Mobile Reporting" tab. Leave empty to show the built-in mockup / demo button.
    'play_store_url' => env('PLAY_STORE_URL', ''),
    'app_screenshot' => '', // e.g. 'images/app/mobile-app.png' under public/

    'enquiry_types' => ['Sales Enquiry', 'Customer Support', 'Technical Assistance', 'FBR / PRA Integration', 'Free Demo'],

    // Pages whose CTA band keeps plain buttons instead of the inline demo form: they already carry the full
    // contact form, or aren't sales pages. Paths ending in "*" match a prefix.
    'no_lead_form' => [
        '', 'thank-you', 'contact', 'about-us', 'reseller', 'tickets', 'support', 'on-call-support', 'downloads', 'download/*',
        'cookie-policy', 'privacy-policy', 'security-policy', 'support-policy', 'terms-of-service',
    ],

    // Google reviews shown on the WordPress home page (Trustindex widget) — text kept verbatim.
    'reviews' => [
      ['raaj', 'MyPOS Pakistan is a game-changer for my vape shop in Karachi! It offers seamless inventory management, fast transactions, and real-time sales tracking. The user-friendly interface and excellent customer support make it a must-have for any vape business. Highly recommended!'],
      ['Asad Gaba', 'myPOS has simplified managing my shoe shop with easy sales tracking, inventory management, and quick billing. It’s efficient, user-friendly, and perfect for retail!'],
      ['Hassan Raza', 'I’ve been using The MyPOS Hospital Management System (HMS) for two months, and it’s a highly efficient, user-friendly solution that improves hospital operations and patient care. The support team is excellent, especially Salman Khan, who ensures everything runs smoothly. Highly recommended!'],
      ['Fahad Islam', 'As a salon owner, using myPOS.pk has made managing payments effortless. It supports multiple payment methods, integrates smoothly with my system, and offers real-time updates via the mobile app. The secure transactions give me peace of mind, and my clients appreciate the convenience. Highly recommend it for any salon business!'],
      ['Yousuf Usman', 'We are using my pos as there partner and we have more then 300 Setisfied customer in oman for my pos and they are very happy with the software and there support'],
      ['Javaid Nasir', 'Its amazing software. It meets our each & every need of business. I m more than satisfied not only withe software but service and gratitude of POS reps. Regards Happy Bhayi'],
      ['Mubashar Hussain', 'Very nice and cooperative staff sir Khalil and Salman khan thanks for guiding me.mjy apni boutique k leye myPOS SE achha koi software nhi lga'],
      ['Eaze App', 'I using this software since last three months and it is wonderful. It is very user friendly and the support provided by there team is amazing. I recommend this software to every retailer.'],
      ['Salman Raza', 'I am using MyPos Its very amazing user friendly software'],
      ['Faheem Akram', 'Efficient POS software, streamlines transactions, user-friendly interface.'],
    ],

    /*
    | Main navigation — mirrors the WordPress "Main Menu" item-for-item,
    | grouped into dropdowns. `match` = URL prefixes that mark the item active.
    */
    // Header menu. Item: [label, url, icon key (see $navIcons), short description (list menus only)].
    // 'mega' menus show grouped columns; the others show an icon list. 'promo' is the side card.
    'menu' => [
        ['label' => 'FBR & Tax', 'type' => 'list', 'cols' => 1, 'items' => [
            ['FBR Digital Invoicing', '/fbr-digital-invoicing', 'doc-check', 'Digital sales tax invoices for FBR'],
            ['FBR POS Integration', '/fbr-pos-integration', 'qr', 'Every sale reported live to FBR'],
            ['PRA POS Integration', '/pra-integration', 'landmark', 'Punjab Revenue Authority'],
            ['KPRA Integration', '/kpra-integration', 'mountain', 'Khyber Pakhtunkhwa Revenue Authority'],
            ['SRB Integration', '/srb-integration-services-in-pakistan', 'waves', 'Sindh Revenue Board'],
        ], 'promo' => ['FBR & PRA setup included', 'POS ID registration, setup and staff training come with every new myPOS install.']],
        ['label' => 'Industries', 'type' => 'mega', 'groups' => [
            'Healthcare' => [
                ['Clinics', '/clinics-fbr-pos-integration', 'clinic'],
                ['Dental Clinics', '/dental-clinics-fbr-pos-integration', 'tooth'],
                ['Aesthetic Clinics', '/aesthatic-clinics-fbr-pos-integration', 'sparkle'],
                ['Veteran Clinics', '/veteran-clinic-fbr-pos-integration', 'paw'],
                ['Hospitals', '/hospital-fbr-pos-integration', 'hospital'],
                ['Medical Complex', '/medical-complex-fbr-pos-integration', 'medical-complex'],
                ['Laboratories', '/laboratories-fbr-pos-integration', 'flask'],
            ],
            'Food & Services' => [
                ['Restaurants', '/pra-pos-restaurant-integration', 'restaurant'],
                ['Beauty Salons', '/beauty-salons-fbr-pos-integration', 'scissors'],
                ['Gyms', '/gym-fbr-pos-integration', 'dumbbell'],
                ['Car Wash', '/car-wash-pos', 'car'],
                ['Wedding Event Halls', '/wedding-event-halls-fbr-pos-integration', 'heart'],
            ],
            'Education' => [
                ['Schools', '/schools-fbr-pos-integration', 'cap'],
                ['Colleges', '/college-fbr-pos-integration', 'landmark'],
            ],
        ], 'foot' => ['All FBR POS Integration', '/fbr-pos-integration'],
           'promo' => ['Not sure which setup fits?', 'We show you myPOS working on your own products, free. Live in 1–3 days.']],
        ['label' => 'Software', 'type' => 'mega', 'groups' => [
            'POS by business' => [
                ['Retail Management', '/retail-management', 'store'],
                ['Restaurant Management', '/restaurant-management', 'restaurant'],
                ['RestroPOS', '/restro-pos', 'monitor'],
                ['Home Delivery', '/home-delivery', 'bag'],
                ['Salon Management', '/salon-management', 'scissors'],
                ['Supermarket POS', '/supermarket-pos', 'cart'],
                ['Bakery POS', '/bakery-pos', 'bread'],
                ['Garments POS', '/garments-pos', 'shirt'],
                ['Laundry Management', '/laundry-management', 'washer'],
                ['Tailor Management', '/tailor-management', 'needle'],
            ],
            'Back office' => [
                ['Accounting Software', '/accounting-software', 'calculator'],
                ['Payroll Software', '/payroll-software', 'payroll'],
                ['Distribution Management', '/distribution-management', 'truck'],
                ['Hospital Management', '/hospital-management', 'hospital'],
            ],
        ], 'foot' => ['Compare all plans', '/pricing'],
           'promo' => ['One system for your whole business', 'Sales, stock, accounts and staff in one place, online or offline.']],
        ['label' => 'Features', 'url' => '/features', 'type' => 'list', 'cols' => 2, 'items' => [
            ['All Features', '/features', 'grid', 'Everything myPOS can do'],
            ['Stock Management', '/stock-management', 'box', 'Stock levels, transfers and adjustments'],
            ['Customers Management', '/customers', 'users', 'Customer records, credit and loyalty'],
            ['Employee Management', '/employee-management', 'badge', 'Staff accounts, roles and permissions'],
            ['Mobile POS', '/mobile-mypos', 'phone', 'Sell and check reports on your phone'],
            ['Multi-location Integration', '/multi-location-integration', 'pin', 'Run every branch from one account'],
            ['Paperless Invoicing', '/paperless-invoicing', 'receipt', 'Digital receipts instead of paper'],
            ['WooCommerce Integration', '/woocommerce-pos', 'globe', 'Connect your online store'],
        ]],
        ['label' => 'Pricing', 'url' => '/pricing', 'type' => 'list', 'cols' => 1, 'items' => [
            ['RetailPro Pricing', '/pricing', 'store', 'Shops, marts and retail stores'],
            ['RestroPro Pricing', '/pricing-restropro', 'restaurant', 'Restaurants, cafés and fast food'],
            ['SalonPro Pricing', '/pricing-salonpro', 'scissors', 'Salons, spas and barbers'],
            ['LaundryPro Pricing', '/pricing-laundry-pro', 'washer', 'Laundries and dry cleaners'],
            ['TailorPro Pricing', '/pricing-tailorpro', 'needle', 'Tailors and boutiques'],
            ['One-time Payment Plan', '/one-time-pricing', 'tag', 'Pay once instead of monthly'],
        ]],
        ['label' => 'Resources', 'type' => 'list', 'cols' => 2, 'items' => [
            ['Blog', '/blogs', 'book', 'POS and FBR guides'],
            ['Our Clients', '/clients', 'star', 'Businesses that run on myPOS'],
            ['FAQs', '/frequently-asked-questions', 'help', 'Answers to common questions'],
            ['Support', '/support', 'headset', 'Help from our support team'],
            ['Downloads', '/downloads', 'download', 'Download myPOS software'],
            ['Become a Reseller', '/reseller', 'handshake', 'Sell myPOS and earn commission'],
            ['About Us', '/about-us', 'info', 'Who we are'],
            ['Contact', '/contact', 'mail', 'Talk to our team'],
        ]],
    ],

    // SVG path markup for the header icons, on a 24x24 stroked grid.
    'nav_icons' => [
        'doc-check' => '<path d="M6 3h9l4 4v14H6z"/><path d="M14 3v5h5M9 14l2 2 4-4"/>',
        'qr' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3M21 14v.01M17 21h4v-4M14 21v-3"/>',
        'landmark' => '<path d="M3 9l9-5 9 5"/><path d="M5 9v9M9.5 9v9M14.5 9v9M19 9v9M3 20.5h18"/>',
        'mountain' => '<path d="M3 20l6.5-11 4 6.5 2.5-3.5L21 20z"/>',
        'waves' => '<path d="M3 16c2 0 2 2 4.5 2S10 16 12 16s2 2 4.5 2S19 16 21 16"/><path d="M5 12.5V8l7-3.5L19 8v4.5"/>',
        'clinic' => '<rect x="3" y="5" width="18" height="15" rx="2"/><path d="M12 9v7M8.5 12.5h7M9 5V3h6v2"/>',
        'tooth' => '<path d="M7.5 3C5.2 3 4 4.8 4 7.2c0 3 1.2 4.3 1.7 7.3.4 2.6 1 5.5 2.4 5.5 1.6 0 1.5-4.5 3.9-4.5s2.3 4.5 3.9 4.5c1.4 0 2-2.9 2.4-5.5.5-3 1.7-4.3 1.7-7.3C20 4.8 18.8 3 16.5 3c-2 0-2.7 1.2-4.5 1.2S9.5 3 7.5 3z"/>',
        'sparkle' => '<path d="M11 3l1.8 5.2L18 10l-5.2 1.8L11 17l-1.8-5.2L4 10l5.2-1.8z"/><path d="M18.5 15l.7 1.8 1.8.7-1.8.7-.7 1.8-.7-1.8-1.8-.7 1.8-.7z"/>',
        'paw' => '<circle cx="6.5" cy="10" r="1.8"/><circle cx="10" cy="5.5" r="1.8"/><circle cx="14" cy="5.5" r="1.8"/><circle cx="17.5" cy="10" r="1.8"/><path d="M8 17.5c0-2.6 1.8-5.5 4-5.5s4 2.9 4 5.5a2.3 2.3 0 01-4 1.5 2.3 2.3 0 01-4-1.5z"/>',
        'hospital' => '<path d="M4 21V7l8-4 8 4v14"/><path d="M12 8v6M9 11h6M9 21v-4h6v4"/>',
        'medical-complex' => '<rect x="3" y="8" width="7" height="13"/><rect x="10" y="3" width="11" height="18"/><path d="M15.5 6.5v4M13.5 8.5h4M5.5 12h2M5.5 16h2M13.5 14h4M13.5 17.5h4"/>',
        'flask' => '<path d="M9 3h6M10 3v6l-5 9a2 2 0 001.8 3h10.4a2 2 0 001.8-3l-5-9V3"/><path d="M7.5 15h9"/>',
        'restaurant' => '<path d="M7 3v8M5 3v5a2 2 0 004 0V3M7 11v10"/><path d="M17 21V3c-2 1-3 4-3 7v3h3"/>',
        'scissors' => '<circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M8.1 8.1L20 20M8.1 15.9L20 4"/>',
        'dumbbell' => '<path d="M6.5 6.5v11M17.5 6.5v11M3.5 9v6M20.5 9v6M6.5 12h11"/>',
        'car' => '<path d="M5 15l1.6-4.5A2 2 0 018.5 9h7a2 2 0 011.9 1.5L19 15"/><rect x="3" y="15" width="18" height="4" rx="1.5"/><path d="M8 4.5c0 1-.8 1.5-.8 2.3a.8.8 0 001.6 0C8.8 6 8 5.5 8 4.5zM16 4.5c0 1-.8 1.5-.8 2.3a.8.8 0 001.6 0C16.8 6 16 5.5 16 4.5z"/>',
        'heart' => '<path d="M12 20s-7.5-4.5-7.5-10.2A4.1 4.1 0 0112 7.4a4.1 4.1 0 017.5 2.4C19.5 15.5 12 20 12 20z"/>',
        'cap' => '<path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11v5c3 2.5 9 2.5 12 0v-5M22 9v6"/>',
        'store' => '<path d="M4 9l1.5-5h13L20 9"/><path d="M4 9h16v2a3 3 0 01-5.3 2A3 3 0 0112 14a3 3 0 01-2.7-1A3 3 0 014 11z"/><path d="M5 14v6h14v-6"/><path d="M10 20v-4h4v4"/>',
        'monitor' => '<rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4M7 8h6M7 11h4"/>',
        'bag' => '<path d="M5 8h14l-1.2 12H6.2z"/><path d="M9 8V6.5a3 3 0 016 0V8"/>',
        'cart' => '<path d="M3 4h2l2.4 11h11l2-8H6"/><circle cx="9" cy="19.5" r="1.5"/><circle cx="17" cy="19.5" r="1.5"/>',
        'bread' => '<path d="M4 13a8 5 0 0116 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2z"/><path d="M9 9.5l1 4M15 9.5l-1 4M12 9v4.5"/>',
        'shirt' => '<path d="M9 3l3 2 3-2 5 3-2 4-2-1v12H8V9l-2 1-2-4z"/>',
        'washer' => '<rect x="4" y="3" width="16" height="18" rx="2"/><circle cx="12" cy="13" r="4.5"/><path d="M7 6.5h.01M10 6.5h.01"/>',
        'needle' => '<path d="M4 20L18 6"/><circle cx="19" cy="5" r="1.6"/><path d="M4 8c3 0 3 3 6 3s3-3 6-3"/>',
        'calculator' => '<rect x="5" y="2.5" width="14" height="19" rx="2"/><path d="M8 6.5h8M8 11h.01M12 11h.01M16 11h.01M8 14.5h.01M12 14.5h.01M16 14.5h.01M8 18h.01M12 18h4"/>',
        'payroll' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0113 0"/><path d="M17 7v8M19.5 9H16a1.3 1.3 0 000 2.6h2a1.3 1.3 0 010 2.6h-3.5"/>',
        'truck' => '<path d="M2 6h11v10H2zM13 9h4l3 3.5V16h-7"/><circle cx="6" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>',
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
        'box' => '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5l8 4.5 8-4.5M12 12v9"/>',
        'users' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0113 0"/><path d="M16 4.5a3.5 3.5 0 010 7M18 14a6 6 0 013.5 6"/>',
        'badge' => '<rect x="4" y="3" width="16" height="18" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M8 17a4 4 0 018 0"/>',
        'call' => '<path d="M5 4h3.5l2 5-2.4 1.5a11 11 0 005.4 5.4L15 13.5l5 2V19a2 2 0 01-2 2A16 16 0 013 6a2 2 0 012-2z"/>',
        'phone' => '<rect x="7" y="2.5" width="10" height="19" rx="2"/><path d="M11 18h2"/>',
        'pin' => '<path d="M12 21s-6-5.4-6-10a6 6 0 0112 0c0 4.6-6 10-6 10z"/><circle cx="12" cy="11" r="2.2"/>',
        'receipt' => '<path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6M9 16h3"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 010 18M12 3a14 14 0 000 18"/>',
        'tag' => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.3"/>',
        'book' => '<path d="M4 4.5A1.5 1.5 0 015.5 3H20v15H5.5A1.5 1.5 0 004 19.5z"/><path d="M4 19.5A1.5 1.5 0 005.5 21H20v-3M8 7h8"/>',
        'star' => '<path d="M12 3l2.7 5.6 6.1.8-4.5 4.2 1.1 6.1L12 16.8l-5.4 2.9 1.1-6.1-4.5-4.2 6.1-.8z"/>',
        'help' => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9.5a2.5 2.5 0 014.8 1c0 1.7-2.3 2-2.3 3.5M12 17h.01"/>',
        'headset' => '<path d="M4 14v-2a8 8 0 0116 0v2"/><rect x="3" y="14" width="4" height="6" rx="1.5"/><rect x="17" y="14" width="4" height="6" rx="1.5"/><path d="M19 20a3 3 0 01-3 2h-3"/>',
        'download' => '<path d="M12 3v12M7 10l5 5 5-5M4 20h16"/>',
        'handshake' => '<path d="M2 11l4-4 4 2 3-2 4 1 5 3"/><path d="M6 7v7l5 4.5a1.4 1.4 0 002-2M13 13l3 3a1.4 1.4 0 002-2l-4-4M18 14l1-1"/>',
        'info' => '<circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7.5h.01"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
    ],

    'footer' => [
        'Features' => [
            ['Stock Management', '/stock-management'],
            ['Customers', '/customers'],
            ['Employee Management', '/employee-management'],
            ['Mobile POS', '/mobile-mypos'],
            ['Multi Location', '/multi-location-integration'],
            ['Paperless Invoicing', '/paperless-invoicing'],
            ['WooCommerce POS', '/woocommerce-pos'],
        ],
        'Compliance' => [
            ['FBR Digital Invoicing', '/fbr-digital-invoicing'],
            ['FBR POS Integration', '/fbr-pos-integration'],
            ['PRA Integration', '/pra-integration'],
            ['KPRA Integration', '/kpra-integration'],
            ['SRB Integration', '/srb-integration-services-in-pakistan'],
            ['Restaurant PRA POS', '/pra-pos-restaurant-integration'],
        ],
        'Downloads' => [
            ['RetailPro', '/downloads#retailpro'],
            ['RestroPro', '/download/restropro'],
            ['SalonPro', '/download/salonpro'],
            ['LaundryPro', '/download/laundrypro'],
            ['TailorPro', '/download/tailorpro'],
        ],
        'Company' => [
            ['About Us', '/about-us'],
            ['Blog', '/blogs'],
            ['Our Clients', '/clients'],
            ['Become a Reseller', '/reseller'],
            ['Support', '/support'],
            ['Submit a Ticket', '/tickets'],
            ['Contact', '/contact'],
        ],
    ],

    'legal' => [
        ['Privacy Policy', '/privacy-policy'],
        ['Terms of Service', '/terms-of-service'],
        ['Support Policy', '/support-policy'],
        ['Security Policy', '/security-policy'],
        ['Cookie Policy', '/cookie-policy'],
    ],

    /*
    | Old WordPress URLs that no longer exist as pages → best new destination (301).
    */
    'redirects' => [
        'download'                 => '/downloads',
        'download/mypos-retailpro' => '/downloads#retailpro',
        'online-store-catalogue'   => '/woocommerce-pos',
        'restaurant-pos-software'  => '/restaurant-management',
        'woocommerce-integration'  => '/woocommerce-pos',
        'pricing-laundrypro'       => '/pricing-laundry-pro',
        'category/uncategorized'   => '/blogs',
        'author/mypos_admin'       => '/blogs',
        'author/author'            => '/blogs',
        'portfolio'                => '/clients',
        'multilocation'            => '/multi-location-integration', // broken link inside two WP blog posts
        'home'                     => '/',
    ],

    // Spam / test URLs injected into the old WordPress install — answered with 410 Gone.
    'gone' => [
        'discovering-big-red-pokies-online-fun',
        'australia-pokies-online-real-money-choices',
        'is-payid-safe-for-pokies-transactions',
        'test-post-d505479a-6998-4bf6-b5c4-66bfdb6dbcb7-e1fba110b3948adf',
    ],
];
