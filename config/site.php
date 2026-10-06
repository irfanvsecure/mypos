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

    'enquiry_types' => ['Sales Enquiry', 'Customer Support', 'Technical Assistance', 'FBR / PRA Integration', 'Free Demo'],

    /*
    | Main navigation — mirrors the WordPress "Main Menu" item-for-item,
    | grouped into dropdowns. `match` = URL prefixes that mark the item active.
    */
    'menu' => [
        ['label' => 'FBR & Tax', 'wide' => false, 'items' => [
            ['FBR Digital Invoicing', '/fbr-digital-invoicing'],
            ['FBR POS Integration', '/fbr-pos-integration'],
            ['PRA POS Integration', '/pra-integration'],
            ['KPRA Integration', '/kpra-integration'],
            ['SRB Integration', '/srb-integration-services-in-pakistan'],
        ]],
        ['label' => 'Industries', 'wide' => true, 'head' => 'FBR & PRA POS BY INDUSTRY', 'items' => [
            ['Restaurants', '/pra-pos-restaurant-integration'],
            ['Car Wash', '/car-wash-pos'],
            ['Veteran Clinics', '/veteran-clinic-fbr-pos-integration'],
            ['Dental Clinics', '/dental-clinics-fbr-pos-integration'],
            ['Clinics', '/clinics-fbr-pos-integration'],
            ['Aesthetic Clinics', '/aesthatic-clinics-fbr-pos-integration'],
            ['Hospitals', '/hospital-fbr-pos-integration'],
            ['Medical Complex', '/medical-complex-fbr-pos-integration'],
            ['Laboratories', '/laboratories-fbr-pos-integration'],
            ['Gyms', '/gym-fbr-pos-integration'],
            ['Beauty Salons', '/beauty-salons-fbr-pos-integration'],
            ['Wedding Event Halls', '/wedding-event-halls-fbr-pos-integration'],
            ['Schools', '/schools-fbr-pos-integration'],
            ['Colleges', '/college-fbr-pos-integration'],
        ], 'foot' => ['All FBR POS Integration →', '/fbr-pos-integration']],
        ['label' => 'Software', 'wide' => true, 'head' => 'POS & BUSINESS SOFTWARE', 'items' => [
            ['Retail Management', '/retail-management'],
            ['Restaurant Management', '/restaurant-management'],
            ['Salon Management', '/salon-management'],
            ['Supermarket POS', '/supermarket-pos'],
            ['Bakery POS', '/bakery-pos'],
            ['Garments POS', '/garments-pos'],
            ['Laundry Management', '/laundry-management'],
            ['Tailor Management', '/tailor-management'],
            ['Accounting Software', '/accounting-software'],
            ['Payroll Software', '/payroll-software'],
            ['Distribution Management', '/distribution-management'],
            ['Hospital Management', '/hospital-management'],
            ['RestroPOS', '/restro-pos'],
            ['Home Delivery', '/home-delivery'],
        ]],
        ['label' => 'Features', 'url' => '/features', 'wide' => false, 'items' => [
            ['All Features', '/features'],
            ['Stock Management', '/stock-management'],
            ['Customers Management', '/customers'],
            ['Employee Management', '/employee-management'],
            ['Mobile POS', '/mobile-mypos'],
            ['Multi-location Integration', '/multi-location-integration'],
            ['Paperless Invoicing', '/paperless-invoicing'],
            ['WooCommerce Integration', '/woocommerce-pos'],
        ]],
        ['label' => 'Pricing', 'url' => '/pricing', 'wide' => false, 'items' => [
            ['RetailPro Pricing', '/pricing'],
            ['RestroPro Pricing', '/pricing-restropro'],
            ['SalonPro Pricing', '/pricing-salonpro'],
            ['LaundryPro Pricing', '/pricing-laundry-pro'],
            ['TailorPro Pricing', '/pricing-tailorpro'],
            ['One-time Payment Plan', '/one-time-pricing'],
        ]],
        ['label' => 'Resources', 'wide' => false, 'items' => [
            ['Blog', '/blogs'],
            ['Our Clients', '/clients'],
            ['FAQs', '/frequently-asked-questions'],
            ['Support', '/support'],
            ['Downloads', '/downloads'],
            ['Become a Reseller', '/reseller'],
            ['About Us', '/about-us'],
            ['Contact', '/contact'],
        ]],
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
