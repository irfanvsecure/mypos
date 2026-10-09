<?php

if (! function_exists('wa_link')) {
    /**
     * WhatsApp chat link with a message that names the page the visitor is on.
     */
    function wa_link(): string
    {
        $path = trim(request()->path(), '/');
        $topic = wa_topic($path);

        $text = match (true) {
            $path === '' => 'Hi myPOS, I would like a free demo of your POS software.',
            str_starts_with($path, 'download') => "Hi myPOS, I need help installing {$topic}.",
            in_array($path, ['support', 'tickets'], true) => 'Hi myPOS, I need help with my POS.',
            default => "Hi myPOS, I would like a free demo of {$topic}.",
        };

        return 'https://wa.me/' . config('site.whatsapp') . '?text=' . rawurlencode($text);
    }
}

if (! function_exists('wa_topic')) {
    function wa_topic(string $path): string
    {
        $map = [
            'restaurant-management' => 'RestroPro',
            'restro-pos' => 'RestroPro',
            'home-delivery' => 'RestroPro home delivery',
            'pricing-restropro' => 'RestroPro',
            'download/restropro' => 'RestroPro',
            'pra-pos-restaurant-integration' => 'PRA restaurant POS',
            'retail-management' => 'RetailPro',
            'pricing' => 'the monthly plan',
            'one-time-pricing' => 'RetailPro',
            'downloads' => 'the free POS download',
            'supermarket-pos' => 'supermarket POS',
            'bakery-pos' => 'bakery POS',
            'garments-pos' => 'garments POS',
            'salon-management' => 'SalonPro',
            'pricing-salonpro' => 'SalonPro',
            'download/salonpro' => 'SalonPro',
            'beauty-salons-fbr-pos-integration' => 'salon FBR and PRA POS',
            'laundry-management' => 'LaundryPro',
            'pricing-laundry-pro' => 'LaundryPro',
            'download/laundrypro' => 'LaundryPro',
            'tailor-management' => 'TailorPro',
            'pricing-tailorpro' => 'TailorPro',
            'download/tailorpro' => 'TailorPro',
            'clinics-fbr-pos-integration' => 'clinic FBR and PRA POS',
            'dental-clinics-fbr-pos-integration' => 'dental clinic FBR POS',
            'aesthatic-clinics-fbr-pos-integration' => 'aesthetic clinic FBR POS',
            'veteran-clinic-fbr-pos-integration' => 'veterinary clinic FBR POS',
            'hospital-fbr-pos-integration' => 'hospital FBR POS',
            'hospital-management' => 'hospital management',
            'medical-complex-fbr-pos-integration' => 'medical complex FBR POS',
            'laboratories-fbr-pos-integration' => 'laboratory FBR POS',
            'gym-fbr-pos-integration' => 'gym FBR POS',
            'schools-fbr-pos-integration' => 'school FBR POS',
            'college-fbr-pos-integration' => 'college FBR POS',
            'wedding-event-halls-fbr-pos-integration' => 'wedding hall FBR POS',
            'car-wash-pos' => 'car wash POS',
            'fbr-pos-integration' => 'FBR POS integration',
            'fbr-digital-invoicing' => 'FBR digital invoicing',
            'pra-integration' => 'PRA integration',
            'kpra-integration' => 'KPRA integration',
            'srb-integration-services-in-pakistan' => 'SRB integration',
            'accounting-software' => 'accounting software',
            'payroll-software' => 'payroll software',
            'distribution-management' => 'distribution software',
        ];

        if (isset($map[$path])) {
            return $map[$path];
        }

        $slug = $path === '' ? 'myPOS' : str_replace(['-', '/'], ' ', $path);

        return trim($slug);
    }
}
