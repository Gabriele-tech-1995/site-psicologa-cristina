<?php

return [
    'defaults' => [
        'site_suffix' => ' | Dott.ssa Cristina Pacifici',
        'site_suffix_local' => ' | Psicologa a Tivoli e Guidonia Montecelio',
    ],

    /*
    | Dati per JSON-LD (Psychologist / Person) e meta: URL assoluti da asset() nel layout.
    */
    'psychologist' => [
        'name' => 'Dott.ssa Cristina Pacifici',
        'job_title' => 'Psicologa',
        'practice_name' => 'Dott.ssa Cristina Pacifici - Psicologa',
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
        'same_as' => [
            'https://wa.me/393441122785',
        ],
        /*
        | Sedi in presenza (allineate alla pagina Contatti). Il primo elemento è anche
        | l’indirizzo principale nel campo address dello schema Psychologist.
        |
        | maps_url: link “Apri in Google Maps” (JSON-LD hasMap + Contatti). Consigliato.
        | maps_embed_url: opzionale legacy; se maps_url manca, usato come stesso link esterno (mai iframe).
        | Senza entrambi, si genera un link da indirizzo (maps/search).
        */
        'locations' => [
            [
                'name' => 'Centro Imago',
                'street_address' => 'Piazza Santa Croce 12',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Centro+Imago+Tivoli',
            ],
            [
                'name' => 'Centro Empathia',
                'street_address' => 'Piazzale delle Nazioni Unite 16',
                'address_locality' => 'Tivoli',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Centro+Empathia+Tivoli',
            ],
            [
                'name' => 'Centro Liberamente',
                'street_address' => 'Via Tito Bernardini 13',
                'address_locality' => 'Villanova di Guidonia',
                'address_region' => 'RM',
                'postal_code' => null,
                'address_country' => 'IT',
                'maps_url' => 'https://maps.google.com/?q=Via+Tito+Bernardini+13+Villanova+di+Guidonia',
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
            'title' => 'Dott.ssa Cristina Pacifici | Psicologa a Tivoli e Guidonia Montecelio',
            'description' => 'Psicologa a Tivoli e Guidonia Montecelio per bambini, adolescenti e genitori: supporto psicologico in presenza (anche Villanova di Guidonia) e online.',
        ],
        'about' => [
            'title' => 'Chi sono | Psicologa a Tivoli e Guidonia Montecelio',
            'description' => 'Profilo della Dott.ssa Cristina Pacifici, psicologa a Tivoli e in zona Guidonia Montecelio. Supporto per bambini, adolescenti, adulti e genitori, anche online.',
        ],
        'areas' => [
            'title' => 'Aree di intervento | Psicologa a Tivoli e Guidonia',
            'description' => 'Aree di intervento della Dott.ssa Cristina Pacifici, psicologa tra Tivoli e Guidonia Montecelio: ansia, umore basso, relazioni, autostima, genitorialità, scuola e benessere emotivo.',
        ],
        'contacts' => [
            'title' => 'Contatti | Dott.ssa Cristina Pacifici, Psicologa a Tivoli e Guidonia',
            'description' => 'Contatti della Dott.ssa Cristina Pacifici, psicologa a Tivoli e Guidonia Montecelio. Colloqui in presenza e online per bambini, adolescenti e genitori.',
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
