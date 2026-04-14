<?php

return [
    'contact' => [
        // Campo honeypot (input nascosto): se valorizzato, consideriamo il submit bot.
        'honeypot_field' => env('CONTACT_HONEYPOT_FIELD', 'contact_website'),

        // Limiti anti-flood per route throttle.
        'max_attempts_per_minute' => (int) env('CONTACT_MAX_ATTEMPTS_PER_MINUTE', 3),
        'max_attempts_per_hour' => (int) env('CONTACT_MAX_ATTEMPTS_PER_HOUR', 12),
        'max_attempts_per_hour_per_email' => (int) env('CONTACT_MAX_ATTEMPTS_PER_HOUR_PER_EMAIL', 6),
    ],
];
