<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HTTP security headers (Lighthouse “Best practices” / Trust & safety)
    |--------------------------------------------------------------------------
    |
    | Disattivato in local/testing di default. In produzione: CSP + HSTS + XFO + COOP.
    | Forza con SECURITY_HEADERS=true in .env (anche in local per provare).
    |
    */
    'headers_enabled' => env('SECURITY_HEADERS') !== null
        ? filter_var(env('SECURITY_HEADERS'), FILTER_VALIDATE_BOOL)
        : ! in_array(env('APP_ENV', 'production'), ['local', 'testing'], true),

    /*
    |--------------------------------------------------------------------------
    | HSTS (solo su richieste HTTPS)
    |--------------------------------------------------------------------------
    |
    | preload: default true (Lighthouse / hardening). Verifica HTTPS su tutto il dominio
    | e sottodomini prima di inviare il dominio all’elenco Chromium.
    | https://hstspreload.org/ — in caso di eccezioni: HSTS_PRELOAD=false in .env
    |
    */
    'hsts_max_age' => (int) env('HSTS_MAX_AGE', 63072000),

    'hsts_include_subdomains' => filter_var(
        env('HSTS_INCLUDE_SUBDOMAINS', true),
        FILTER_VALIDATE_BOOL,
    ),

    'hsts_preload' => filter_var(env('HSTS_PRELOAD', true), FILTER_VALIDATE_BOOL),

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin-Resource-Policy (documento HTML)
    |--------------------------------------------------------------------------
    |
    | same-origin: rafforza l’isolamento (Lighthouse). Se qualcosa si rompe
    | (embed esterni rari), imposta SECURITY_CORP=false.
    |
    */
    'corp_same_origin' => filter_var(env('SECURITY_CORP_SAME_ORIGIN', true), FILTER_VALIDATE_BOOL),

    /*
    |--------------------------------------------------------------------------
    | CSP: connect-src aggiuntivi (es. Vite HMR in locale con SECURITY_HEADERS=true)
    |--------------------------------------------------------------------------
    |
    | Esempio: http://127.0.0.1:5173 ws://127.0.0.1:5173 (separati da spazio)
    |
    */
    'csp_connect_src_extra' => array_values(array_filter(preg_split(
        '/\s+/',
        (string) env('CSP_CONNECT_SRC_EXTRA', ''),
        -1,
        PREG_SPLIT_NO_EMPTY,
    ))),

    /*
    |--------------------------------------------------------------------------
    | Trusted Types (CSP) — Lighthouse “Best practices”
    |--------------------------------------------------------------------------
    |
    | Policy “default” permissiva + script inline con nonce in head: soddisfa
    | l’audit senza rifattorizzare Bootstrap/GA. Se qualcosa in produzione
    | va in errore (es. script di terze parti), imposta CSP_TRUSTED_TYPES=false.
    |
    */
    'csp_trusted_types' => filter_var(env('CSP_TRUSTED_TYPES', true), FILTER_VALIDATE_BOOL),

];
