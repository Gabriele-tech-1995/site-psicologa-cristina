<?php

return [
    'defaults' => [
        'site_suffix' => ' | Dott.ssa Cristina Pacifici',
        'site_suffix_local' => ' | Psicologa a Tivoli e Guidonia Montecelio',
    ],

    /*
    | Dati per JSON-LD (Psychologist / Person) e meta: URL assoluti da asset() nel layout.
    |
    | GOOGLE_BUSINESS_PROFILE_URL (.env): URL pubblico della scheda Google Business Profile
    | (stesso valore da inserire in same_as per il grafo entità).
    */
    'psychologist' => [
        'name' => 'Dott.ssa Cristina Pacifici',
        'job_title' => 'Psicologa',
        'practice_name' => 'Dott.ssa Cristina Pacifici – Psicologa',
        'telephone' => '+39 3441122785',
        /*
        | Link WhatsApp (wa.me/…). Se null, in Contatti si ricava dal numero in telephone.
        */
        'whatsapp_url' => 'https://wa.me/393441122785',
        'email' => 'dott.ssapacifici24@gmail.com',
        'albo_registration_url' => 'https://ordinepsicologilazio.it/albo/iscrizione-32019',
        'aspic_url' => 'https://www.aspic.it/',
        'image' => 'img/cristina.webp',
        'og_image' => 'img/og-image.jpg',
        'same_as' => array_values(array_filter([
            env('GOOGLE_BUSINESS_PROFILE_URL') ? trim((string) env('GOOGLE_BUSINESS_PROFILE_URL')) : null,
            'https://wa.me/393441122785',
        ])),
        /*
        | Sedi in presenza: il nome (`name`) descrive il colloquio in loco (soggetto = professionista),
        | non la titolarità del “centro”. Indirizzi e mappe restano espliciti.
        | maps_embed_url: opzionale, src iframe da “Condividi > Inserisci una mappa” su Google Maps
        | (più preciso del riquadro generato da indirizzo). Se assente, si usa l’indirizzo strutturato.
        | maps_url: query geografica per embed (preferita all’indirizzo se entrambe presenti).
        */
        'locations' => [
            [
                'name' => 'Colloqui in presenza – Tivoli, Piazza Santa Croce 12',
                'street_address' => 'Piazza Santa Croce 12',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Piazza+Santa+Croce+12,+Tivoli,+Italia',
            ],
            [
                'name' => 'Colloqui in presenza – Tivoli, Piazzale delle Nazioni Unite 16',
                'street_address' => 'Piazzale delle Nazioni Unite 16',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Piazzale+delle+Nazioni+Unite+16,+Tivoli,+Italia',
            ],
            [
                'name' => 'Colloqui in presenza – Villanova di Guidonia, Via Tito Bernardini 13',
                'street_address' => 'Via Tito Bernardini 13',
                'address_locality' => 'Villanova di Guidonia',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Via+Tito+Bernardini+13,+Villanova+di+Guidonia,+Italia',
            ],
        ],
        'area_served' => [
            'Tivoli',
            'Guidonia Montecelio',
            'Villanova di Guidonia',
            'Roma',
            'Online',
        ],
        'knows_about' => [
            'ansia e gestione dello stress',
            'autostima',
            'difficoltà relazionali',
            'genitorialità',
            'difficoltà scolastiche',
            'disturbi del neurosviluppo',
        ],
    ],

    'pages' => [
        'home' => [
            'title' => 'Cristina Pacifici | Psicologa a Tivoli per bambini, adolescenti e genitori',
            'description' => 'Psicologa a Tivoli e online: Dott.ssa Cristina Pacifici per bambini, adolescenti, adulti e genitori. Supporto psicologico, primo colloquio e contatti sul sito.',
        ],
        'about' => [
            'title' => 'Chi è Cristina Pacifici | Psicologa a Tivoli e online',
            'description' => 'Scopri il profilo della Dott.ssa Cristina Pacifici, psicologa a Tivoli. Approccio, esperienza, aree di intervento e modalità di lavoro.',
        ],
        'areas' => [
            'title' => 'Ambiti di intervento | Psicologa a Tivoli – Cristina Pacifici',
            'description' => 'Aree di intervento della Dott.ssa Cristina Pacifici, psicologa tra Tivoli e Guidonia Montecelio: ansia, umore basso, relazioni, autostima, genitorialità, scuola e benessere emotivo.',
        ],
        'contacts' => [
            'title' => 'Contatti e sedi | Dott.ssa Cristina Pacifici, Psicologa a Tivoli',
            'description' => 'Contatta la Dott.ssa Cristina Pacifici, psicologa a Tivoli. Informazioni, sedi, modalità online e in presenza, WhatsApp e modulo contatti.',
        ],
        'testimonials' => [
            'title' => 'Testimonianze | Psicologa a Tivoli e Guidonia Montecelio',
            'description' => 'Testimonianze su percorsi con la Dott.ssa Cristina Pacifici, psicologa a Tivoli e Guidonia Montecelio. Esperienze condivise in forma anonima.',
        ],
        'privacy' => [
            'title' => 'Privacy Policy | Dott.ssa Cristina Pacifici',
            'description' => 'Informativa privacy del sito della Dott.ssa Cristina Pacifici: finalità, base giuridica, tempi di conservazione e diritti dell\'interessato.',
        ],
    ],
];
