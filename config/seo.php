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
        | Sedi in presenza: `name` formula = professionista come soggetto, centro come luogo di ricezione
        | (mai “Centro X – Dott.ssa”, sempre riceve presso / colloqui presso). JSON-LD: Place con nome descrittivo.
        | maps_embed_url: opzionale. maps_url: query per embed (preferita all’indirizzo se presente).
        */
        'locations' => [
            [
                'name' => 'Riceve in presenza presso Centro Imago, Tivoli',
                'street_address' => 'Piazza Santa Croce 12',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Centro+Imago+Tivoli',
            ],
            [
                'name' => 'Riceve in presenza presso Centro Empathia, Tivoli',
                'street_address' => 'Piazzale delle Nazioni Unite 16',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Centro+Empathia+Tivoli',
            ],
            [
                'name' => 'Riceve in presenza presso Centro Liberamente, Villanova di Guidonia',
                'street_address' => 'Via Tito Bernardini 13',
                'address_locality' => 'Villanova di Guidonia',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Centro+Liberamente+Guidonia',
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
            'og_image' => 'img/og-image.jpg',
            'og_image_alt' => 'Dott.ssa Cristina Pacifici, psicologa a Tivoli',
        ],
        'about' => [
            'title' => 'Chi è Cristina Pacifici | Psicologa a Tivoli e online',
            'description' => 'Scopri il profilo della Dott.ssa Cristina Pacifici, psicologa a Tivoli. Approccio, esperienza, aree di intervento e modalità di lavoro.',
            'og_image' => 'img/cristina.webp',
            'og_image_alt' => 'Dott.ssa Cristina Pacifici, psicologa a Tivoli',
        ],
        'areas' => [
            'title' => 'Ambiti di intervento | Psicologa a Tivoli – Cristina Pacifici',
            'description' => 'Aree di intervento della Dott.ssa Cristina Pacifici, psicologa tra Tivoli e Guidonia Montecelio: ansia, umore basso, relazioni, autostima, genitorialità, scuola e benessere emotivo.',
            'og_image' => 'img/stress.webp',
            'og_image_alt' => 'Aree di intervento psicologico a Tivoli',
        ],
        'firstInterview' => [
            'title' => 'Primo colloquio psicologico a Tivoli | Dott.ssa Cristina Pacifici',
            'description' => 'Scopri come si svolge il primo colloquio psicologico con la Dott.ssa Cristina Pacifici, psicologa a Tivoli: online o in presenza, in un clima accogliente e senza pressioni.',
            'og_image' => 'img/cristina.webp',
            'og_image_alt' => 'Primo colloquio psicologico con la Dott.ssa Cristina Pacifici',
        ],
        'contacts' => [
            'title' => 'Contatti e sedi | Dott.ssa Cristina Pacifici, Psicologa a Tivoli',
            'description' => 'Contatta la Dott.ssa Cristina Pacifici, psicologa a Tivoli. Informazioni, sedi, modalità online e in presenza, WhatsApp e modulo contatti.',
            'og_image' => 'img/logo.webp',
            'og_image_alt' => 'Contatti e sedi della Dott.ssa Cristina Pacifici',
        ],
        'testimonials' => [
            'title' => 'Testimonianze | Psicologa a Tivoli e Guidonia Montecelio',
            'description' => 'Testimonianze su percorsi con la Dott.ssa Cristina Pacifici, psicologa a Tivoli e Guidonia Montecelio. Esperienze condivise in forma anonima.',
            'og_image' => 'img/og-image.webp',
            'og_image_alt' => 'Testimonianze sui percorsi psicologici',
        ],
        'privacy' => [
            'title' => 'Privacy Policy | Dott.ssa Cristina Pacifici',
            'description' => 'Informativa privacy del sito della Dott.ssa Cristina Pacifici: finalità, base giuridica, tempi di conservazione e diritti dell\'interessato.',
        ],
    ],
];
