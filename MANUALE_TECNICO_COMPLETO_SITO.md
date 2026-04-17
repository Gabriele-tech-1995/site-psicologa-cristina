# MANUALE TECNICO COMPLETO DEL SITO

> Repository analizzato: `/workspace`  
> Stack: Laravel 12 + Blade + Vite + Bootstrap 5 + SCSS  
> Documento di handover tecnico completo, didattico e operativo.

---

## Indice

1. [Panoramica generale del progetto](#1-panoramica-generale-del-progetto)  
2. [Struttura completa del progetto](#2-struttura-completa-del-progetto)  
3. [Analisi file per file](#3-analisi-file-per-file)  
4. [Struttura delle pagine](#4-struttura-delle-pagine)  
5. [Layout globale del sito](#5-layout-globale-del-sito)  
6. [CSS/SCSS completo](#6-cssscssstile-completo)  
7. [Design system del sito](#7-design-system-del-sito)  
8. [Componenti riutilizzabili](#8-componenti-riutilizzabili)  
9. [JavaScript / logica interattiva](#9-javascript--logica-interattiva)  
10. [Framework / librerie / dipendenze](#10-framework--librerie--dipendenze)  
11. [Routing e generazione pagine](#11-routing-e-generazione-delle-pagine)  
12. [Gestione contenuti](#12-gestione-contenuti)  
13. [Immagini, asset e media](#13-immagini-asset-e-media)  
14. [SEO completa del sito](#14-seo-completa-del-sito)  
15. [Accessibilità](#15-accessibilit%C3%A0)  
16. [Performance e ottimizzazione](#16-performance-e-ottimizzazione)  
17. [Sicurezza e robustezza](#17-sicurezza-e-robustezza)  
18. [Modifiche pratiche guidate](#18-modifiche-pratiche-guidate)  
19. [Mappa delle dipendenze](#19-mappa-delle-dipendenze)  
20. [Errori, debito tecnico, miglioramenti](#20-errori-debito-tecnico-e-miglioramenti)  
21. [Spiegazione didattica finale](#21-spiegazione-didattica-finale)  
22. [Allegati utili](#22-allegati-utili)

---

# 1. Panoramica generale del progetto

## Nome e scopo
- Il repository è basato su `laravel/laravel` ma implementa un **sito professionale vetrina** per la Dott.ssa Cristina Pacifici.
- Scopo: presentazione professionale + acquisizione contatti + raccolta testimonianze + SEO locale.

## Tipologia sito
- **Sito vetrina professionale** (non e-commerce, non SaaS).
- Con micro-backoffice admin (`/admin`) per gestire richieste e testimonianze.

## Stack tecnologico
- **Backend:** PHP 8.2+, Laravel 12 (`composer.json`).
- **Templating:** Blade Components + views.
- **Frontend:** Vite 7, SCSS, Bootstrap 5.3, JS vanilla + moduli Bootstrap selettivi.
- **Database:** MySQL/SQLite (config Laravel standard), con migrazioni personalizzate per `contact_requests` e `testimonials`.
- **SEO/Schema:** configurazione custom (`config/seo.php` + `App\Support\SeoLayoutLinkedData`).

## Architettura generale
- Architettura classica Laravel monolite:
  - routing web
  - controller pubblico unico principale
  - support classes per SEO/sitemap/anti-spam
  - Blade component layout per meta e shell globale
  - SCSS modulare ma monolitico lato sezioni.

## Filosofia costruttiva
- Forte orientamento a:
  - copywriting SEO locale
  - rendering server-side (niente SPA)
  - UI responsive mobile-first
  - minimizzazione dipendenze runtime.

## Flusso generale
1. Request HTTP entra da `public/index.php`.
2. Bootstrap Laravel in `bootstrap/app.php`.
3. Routing `routes/web.php`.
4. Controller prepara dati + meta.
5. Render in `<x-layout>` (head/meta + nav/footer + schema + asset).
6. JS applica interazioni progressive (offcanvas, reveal, modal feedback, tracking).

## Organizzazione codice
- `app/Http/Controllers/PublicController.php`: nodo centrale contenuti/logica pubblica.
- `resources/views`: tutte pagine e componenti Blade.
- `resources/css`: design system + sezioni + responsive.
- `config/seo.php`: principale fonte SEO statica.
- `tests/Feature/SeoTest.php`: contratto SEO tecnico automatico.

---

# 2. Struttura completa del progetto

## Albero logico (alto livello)

| Cartella/File | Ruolo |
|---|---|
| `public/index.php` | Front controller |
| `bootstrap/app.php` | Config app, middleware, routing |
| `routes/web.php` | Tutte le rotte HTTP pubbliche/admin |
| `app/Http/Controllers/` | Controller pubblico + admin |
| `app/Http/Middleware/` | Security headers + basic auth admin |
| `app/Support/` | SEO graph, sitemap lastmod, anti-spam, dati contatto |
| `resources/views/` | Layout, componenti, pagine, admin, email |
| `resources/css/` | SCSS modulare (tokens/base/navbar/components/forms/sections/responsive) |
| `resources/js/` | JS interazioni UI e tracking |
| `config/` | SEO, sicurezza, mail, anti-spam, etc |
| `database/migrations/` | Tabelle custom + tabelle Laravel standard |
| `tests/` | Test feature SEO/sicurezza/pubblico + unit |

## File indispensabili vs secondari

### Indispensabili (impatto globale alto)
- `resources/views/components/layout.blade.php`
- `app/Http/Controllers/PublicController.php`
- `routes/web.php`
- `config/seo.php`
- `app/Support/SeoLayoutLinkedData.php`
- `resources/css/style.sections.scss`
- `resources/css/style.responsive.scss`

### Secondari ma utili
- `resources/views/emails/*`
- `tests/Feature/ExampleTest.php` (solo smoke)
- `routes/console.php` (solo comando demo `inspire`)

## File che governano comportamento globale
- Head/meta/OG/Twitter/schema: `components/layout.blade.php`.
- Policy sicurezza HTTP/CSP: `app/Http/Middleware/SecurityHeaders.php` + `config/security.php`.
- Dati contatto globali in view: `AppServiceProvider` con `View::composer('*', ...)`.
- Tema globale: `resources/css/style.scss` e moduli `style.*.scss`.

## Mappa collegamenti principali
- `routes/web.php` -> `PublicController` -> `resources/views/*.blade.php` -> `<x-layout>`.
- `<x-layout>` -> `SeoLayoutLinkedData` + `SeoContact` + `@vite`.
- `@vite` -> `resources/css/app.scss` + `resources/js/app.js`.
- `app.js` -> `main.js` (offcanvas, modal, tracking).

---

# 3. Analisi file per file

## Backend core e routing

| File | Funzione | Dipendenze | Cosa modifichi qui | Rischio se tocchi male |
|---|---|---|---|---|
| `public/index.php` | Bootstrap request Laravel | `bootstrap/app.php` | quasi mai | sito down globale |
| `bootstrap/app.php` | routing/middleware alias | `routes/web.php`, middleware | trust proxies, alias middleware | IP/cookie/header errati |
| `routes/web.php` | tutte route pubbliche/admin + sitemap + robots | controller/support classes | nuove pagine/route/middleware | 404, sitemap incoerente |
| `routes/console.php` | comando demo artisan | n/a | opzionale | irrilevante sito |

## Controller e logica applicativa

| File | Ruolo reale | Centrale? | Effetto modifiche |
|---|---|---|---|
| `app/Http/Controllers/PublicController.php` | Home, About, Aree, AreaDetail, Contatti POST, Testimonianze POST, FAQ parsing, contenuti area hardcoded | **Sì (molto)** | qualsiasi modifica può toccare copy, SEO, form, rendering aree |
| `app/Http/Controllers/Admin/ContactRequestController.php` | CRUD base richieste | Medio | impatta solo admin contatti |
| `app/Http/Controllers/Admin/TestimonialController.php` | CRUD base testimonianze | Medio | impatta solo admin testimonianze |

### Nota critica su `PublicController`
- `getAreas()` contiene grandi blocchi HTML inline.
- Parsing FAQ usa pattern rigido (`<h2>Domande frequenti</h2>` + `<h4><p>`).
- Se cambi il markup interno senza aggiornare regex/metodo formatter, rischi:
  - perdita FAQ accordion
  - perdita FAQ schema JSON-LD
  - mismatch SEO.

## Middleware

| File | Cosa fa | Rischio |
|---|---|---|
| `app/Http/Middleware/SecurityHeaders.php` | XFO, CSP con nonce, HSTS, COOP/CORP, permissions policy | rompere script/embed esterni con CSP troppo restrittiva |
| `app/Http/Middleware/BasicAuth.php` | protegge `/admin` via HTTP Basic usando `env()` | debolezza credenziali, no rate-limit admin |

## Support classes

| File | Funzione | Rischio principale |
|---|---|---|
| `app/Support/SeoLayoutLinkedData.php` | og image route-based + JSON-LD globale | fallback/meta non coerenti se mapping route incompleto |
| `app/Support/SeoContact.php` | normalizza dati contatto/maps da `config/seo.php` | link maps/wa malformati se config sporca |
| `app/Support/SitemapLastmod.php` | calcola `lastmod` da mtime file | tutte area pages con stesso `lastmod` |
| `app/Support/SpamDetector.php` | euristica anti-spam testo contatti | falsi positivi/falsi negativi |

## Modelli

| File | Tabella | Fillable | Note |
|---|---|---|---|
| `app/Models/ContactRequest.php` | `contact_requests` | name,email,phone,message,consent_privacy,is_read | semplice, nessuna relazione |
| `app/Models/Testimonial.php` | `testimonials` | name_label,message,consent_publish,is_approved | semplice |
| `app/Models/User.php` | `users` | standard Laravel | non usato nel flusso admin attuale |

## Mail

| File | Uso |
|---|---|
| `app/Mail/ContactRequestMail.php` | notifica al professionista |
| `app/Mail/ContactRequestConfirmMail.php` | conferma utente |
| `resources/views/emails/layout.blade.php` | shell mail |
| `resources/views/emails/contact-request.blade.php` | contenuto notifica |
| `resources/views/emails/contact-confirm.blade.php` | contenuto conferma |

## View/componenti

| File | Ruolo | Impatto |
|---|---|---|
| `resources/views/components/layout.blade.php` | HTML head globale + schema + nav/footer + vite | **globale totale** |
| `resources/views/components/nav.blade.php` | navbar desktop + offcanvas mobile | globale UX |
| `resources/views/components/nav-menu.blade.php` | voci menu centralizzate | navigazione globale |
| `resources/views/components/footer.blade.php` | footer globale + quick links | globale |
| `resources/views/home.blade.php` | homepage | alto |
| `resources/views/chi-sono.blade.php` | pagina profilo | medio/alto |
| `resources/views/aree.blade.php` | listing aree | medio/alto |
| `resources/views/area-show.blade.php` | dettaglio area + schema specifico | **alto SEO/UI** |
| `resources/views/primo-colloquio.blade.php` | pagina conversione + FAQ schema | alto conversione |
| `resources/views/contatti.blade.php` | form principale + mappe + FAQ + modal | **altissimo conversione** |
| `resources/views/testimonianze.blade.php` | listing + form invio | medio |
| `resources/views/privacy.blade.php` | privacy legale | medio |
| `resources/views/sitemap.blade.php` | template XML sitemap | SEO tecnico |

## Config

| File | Cosa governa |
|---|---|
| `config/seo.php` | meta statici, OG image, dati persona/practice/location |
| `config/strategic_faqs.php` | FAQ condivise Home/Contatti |
| `config/antispam.php` | honeypot + rate limits |
| `config/security.php` | toggle security headers e CSP |
| `config/mail.php` | mailer + destinatario contatti |

## Frontend build e asset

| File | Ruolo |
|---|---|
| `vite.config.js` | input bundle, target build, lightningcss |
| `postcss.config.cjs` | PurgeCSS in produzione + safelist |
| `resources/css/app.scss` | entry CSS pubblico |
| `resources/css/admin.scss` | entry CSS admin |
| `resources/js/app.js` | entry JS |
| `resources/js/main.js` | tutta la logica interattiva |
| `resources/js/bootstrap.js` | axios globale (attualmente non importato) |

## Test

| File | Copertura |
|---|---|
| `tests/Feature/SeoTest.php` | meta, canonical, h1, og/twitter, schema, sitemap, robots |
| `tests/Feature/PublicSiteTest.php` | smoke pagine, form contatti/testimonianze, area FAQ, admin auth |
| `tests/Feature/SecurityHeadersTest.php` | CSP/HSTS/COOP/CORP |
| `tests/Unit/SeoContactTest.php` | embed maps e normalizzazione contatti |

## Inventario completo "file per file" (operativo)

### Backend applicativo (`app/`)

| Percorso | Serve a | Interagisce con | È centrale? | Se lo modifichi, effetti/rischi |
|---|---|---|---|---|
| `app/Http/Controllers/Controller.php` | classe base controller | tutti i controller | basso | praticamente nullo |
| `app/Http/Controllers/PublicController.php` | logica pagine pubbliche, contatti, testimonianze, aree | routes, models, mail, support, views | **molto alto** | regressioni SEO/UI/form |
| `app/Http/Controllers/Admin/ContactRequestController.php` | gestione richieste contatto in admin | model `ContactRequest`, views admin | medio | impatta backoffice |
| `app/Http/Controllers/Admin/TestimonialController.php` | gestione testimonianze in admin | model `Testimonial`, views admin | medio | impatta backoffice |
| `app/Http/Middleware/SecurityHeaders.php` | header sicurezza + CSP | config security, Vite nonce | **alto** | blocchi script/mappe/iframe |
| `app/Http/Middleware/BasicAuth.php` | auth basic per `/admin` | env `ADMIN_*`, routes admin | medio-alto | accesso admin aperto/chiuso male |
| `app/Models/ContactRequest.php` | ORM richieste contatto | migration contact, controller/admin | medio | mass-assignment/errori CRUD |
| `app/Models/Testimonial.php` | ORM testimonianze | migration testimonial, controller/admin | medio | pubblicazione/moderazione errata |
| `app/Models/User.php` | modello user Laravel standard | auth config (potenziale) | basso attuale | attualmente poco usato |
| `app/Mail/ContactRequestMail.php` | email notifica al professionista | contact model, template mail | medio | notifica incompleta |
| `app/Mail/ContactRequestConfirmMail.php` | email conferma utente | contact model, template mail | medio | UX post-invio peggiore |
| `app/Providers/AppServiceProvider.php` | rate limiter contatti + composer view globale | config antispam, SeoContact | **alto** | anti-flood e dati contatto globali |
| `app/Support/SeoLayoutLinkedData.php` | OG route-based + JSON-LD globale | config seo, layout | **molto alto** | danni SEO cross-site |
| `app/Support/SeoContact.php` | normalizza contatti/maps/sameAs per view | config seo, footer/nav/contatti | alto | link/mail/tel/maps errati |
| `app/Support/SitemapLastmod.php` | calcola `lastmod` sitemap | routes sitemap | medio | segnali sitemap non affidabili |
| `app/Support/SpamDetector.php` | filtro euristico testo spam | submit contatti | medio | falsi positivi/negativi |

### Views complete (`resources/views/`)

| Percorso | Ruolo concreto | Dipendenze principali | Rischio modifiche |
|---|---|---|---|
| `components/layout.blade.php` | struttura HTML globale + head SEO + schema + asset | SeoLayoutLinkedData, seoContact, vite | **altissimo** |
| `components/nav.blade.php` | header desktop/mobile + offcanvas | nav-menu, config seo, JS offcanvas | alto |
| `components/nav-menu.blade.php` | voci navigazione + stato active | route names | medio-alto |
| `components/footer.blade.php` | footer contatti/sedi/link | seoContact | alto |
| `home.blade.php` | homepage commerciale | seoContact, strategic_faqs | alto |
| `chi-sono.blade.php` | pagina profilo professionale | seoContact | medio-alto |
| `aree.blade.php` | griglia aree | `$areas` | medio |
| `area-show.blade.php` | dettaglio area + schema specifico | `$area`, faq schema, layout ogImage | **alto SEO/UI** |
| `primo-colloquio.blade.php` | landing informativa conversione + FAQ schema | seoContact | alto conversione |
| `contatti.blade.php` | pagina contatti/form/maps/faq/modal | antispam config, seoContact, session/errors | **altissimo** |
| `testimonianze.blade.php` | lista testimonianze + form invio | `$testimonials`, validation errors | medio |
| `privacy.blade.php` | informativa privacy | seo config, seoContact | medio legale |
| `sitemap.blade.php` | XML sitemap output | route sitemap | medio SEO |
| `partials/strategic-faq-answer.blade.php` | render risposta faq plain/html | strategic_faqs placeholders | medio |
| `admin/partials/nav.blade.php` | nav interna admin | route admin | basso |
| `admin/contacts/index.blade.php` | tabella richieste | paginazione richieste | medio |
| `admin/contacts/show.blade.php` | dettaglio richiesta | singolo record | medio |
| `admin/testimonials/index.blade.php` | tabella testimonianze | paginazione testimonials | medio |
| `admin/testimonials/show.blade.php` | dettaglio testimonianza | singolo record | medio |
| `emails/layout.blade.php` | shell HTML email | mailable templates | medio |
| `emails/contact-request.blade.php` | corpo mail admin | ContactRequest | medio |
| `emails/contact-confirm.blade.php` | corpo mail utente | ContactRequest | medio |

### Config complete (`config/`)

| File | Ruolo nel progetto specifico | Rischio |
|---|---|---|
| `config/seo.php` | metadati statici + anagrafica professionista + sedi | **SEO e trust globale** |
| `config/strategic_faqs.php` | FAQ condivise home/contatti + testo schema | mismatch html/schema |
| `config/antispam.php` | honeypot + limiti anti-flood | flood o blocchi eccessivi |
| `config/security.php` | toggle CSP/HSTS/CORP/Trusted Types | rottura asset esterni |
| `config/mail.php` | destinatario modulo e provider | mancato invio mail |
| `config/app.php` | base URL, locale, debug | URL/meta/env incoerenti |
| `config/database.php` | connessioni DB | errori connessione/migrazioni |
| `config/cache.php` | cache store e prefix | cache stale/collisioni |
| `config/session.php` | session policy | problemi login/sessione |
| `config/auth.php` | guard/provider | non critico ora, utile futuro |
| `config/filesystems.php` | dischi locali/cloud | upload/path errati |
| `config/queue.php` | connessioni queue | job mail/async non eseguiti |
| `config/services.php` | credenziali servizi terzi | integrazioni mancanti |
| `config/logging.php` | canali log | debug incident limitato |

### Migrazioni complete (`database/migrations/`)

| File | Crea/modifica | Note operative |
|---|---|---|
| `0001_01_01_000000_create_users_table.php` | users, password_reset_tokens, sessions | standard Laravel |
| `0001_01_01_000001_create_cache_table.php` | cache, cache_locks | usato da cache store database |
| `0001_01_01_000002_create_jobs_table.php` | jobs, job_batches, failed_jobs | standard queue |
| `2026_02_28_142002_create_contact_requests_table.php` | contact_requests | form contatti core |
| `2026_03_26_163327_add_is_read_to_contact_requests_table.php` | aggiunge `is_read` | workflow admin |
| `2026_04_08_111111_create_testimonials_table.php` | testimonials | workflow moderazione |

### Test completi (`tests/`)

| File | Validazione reale che protegge | Se lo rimuovi/perdi |
|---|---|---|
| `tests/Feature/SeoTest.php` | contratto SEO/meta/schema/sitemap | alto rischio regressioni SEO invisibili |
| `tests/Feature/PublicSiteTest.php` | pagine pubbliche, form, admin unauthorized | regressioni funzionali base |
| `tests/Feature/SecurityHeadersTest.php` | presenza CSP/HSTS/COOP/CORP | hardening non verificato |
| `tests/Unit/SeoContactTest.php` | costruzione map embed/contact data | link map rotti non intercettati |
| `tests/Concerns/ParsesHtmlMeta.php` | helper parsing html nei test | test SEO più verbosi/fragili |
| `tests/Feature/ExampleTest.php` | smoke GET `/` | copertura minima |
| `tests/Unit/ExampleTest.php` | placeholder | irrilevante dominio |
| `tests/TestCase.php` | base test class | struttura suite |

---

# 4. Struttura delle pagine

| URL/Route | File | Layout | Dati | Script/Stili | SEO |
|---|---|---|---|---|---|
| `/` (`home`) | `home.blade.php` | `<x-layout>` | arrays interni + `$seoContact` | hero, trust, faq accordion | da `config/seo.php` |
| `/chi-sono` | `chi-sono.blade.php` | `<x-layout>` | meta da controller + `$seoContact` | card profilo/sidebar | `about` + `ProfilePage` |
| `/aree` | `aree.blade.php` | `<x-layout>` | `$areas` da controller | cards area | `areas` |
| `/aree/{slug}` | `area-show.blade.php` | `<x-layout :ogImage ...>` | `$area` da getAreas | hero area + content html + accordion FAQ | meta dinamico + schema Service/Article/FAQ |
| `/primo-colloquio` | `primo-colloquio.blade.php` | `<x-layout>` | FAQ interne | card + accordion + CTA | `firstInterview` + FAQPage |
| `/contatti` | `contatti.blade.php` | `<x-layout>` | faq config + contact data | form, mappe, modal feedback, FAQ accordion | `contacts` + FAQPage |
| `/testimonianze` | `testimonianze.blade.php` | `<x-layout>` | testimonials DB | list + form | `testimonials` |
| `/privacy-policy` | `privacy.blade.php` | `<x-layout>` | privacy seo config | sezione legale | `privacy` |

## Comportamento rilevante
- Home, Primo colloquio, Contatti sono le pagine di conversione.
- Contatti è pagina critica: validazione server + honeypot + rate limit + invio doppia mail.
- Area detail combina contenuto commerciale, internal linking e schema semantico.

---

# 5. Layout globale del sito

## Struttura principale (`components/layout.blade.php`)
- `<head>` centralizza title, meta description, canonical, hreflang, OG, Twitter, favicon.
- Preload condizionali:
  - css/js vite in produzione (manifest)
  - font heading woff2
  - immagine hero home.
- `<body>`:
  - `<x-nav />`
  - `<main>{{ $slot }}</main>`
  - `<x-footer />`
  - floating WhatsApp
  - script JSON-LD globale
  - bundle JS.

## Header / navbar
- Desktop: nav classica + menu `components/nav-menu`.
- Mobile: offcanvas complesso, con blocco intro, nav centrale scrollabile, footer CTA.
- Stato `html.nav-offcanvas-open` per blocco scroll pagina sottostante.

## Footer
- Tre colonne principali:
  - identità professionale
  - sedi/modalità
  - contatti e quick links.

## Griglie e container
- Bootstrap grid + classi custom.
- Ampio uso `card` come unità modulare.
- Sticky sidebar in desktop su alcune pagine (`about`, `testimonials`, contatti form).

## Breakpoint principali
- `>=1400`, `>=992`, `<992`, `<768`, `<576`, oltre a query `orientation: landscape` e `max-height`.

---

# 6. CSS/SCSS/Stile completo

## Ordine caricamento stili
1. Font `@fontsource/playfair-display`.
2. Bootstrap split:
   - `_bootstrap-a-config.scss`
   - `_bootstrap-b-components.scss`
   - `_bootstrap-c-tail.scss`
3. Tema custom `style.scss` che importa:
   - `style.tokens.scss`
   - `style.base.scss`
   - `style.navbar.scss`
   - `style.components.scss`
   - `style.forms.scss`
   - `style.sections.scss`
   - `style.responsive.scss`.

## Gerarchia e responsabilità file
- `style.tokens.scss`: palette, spacing, radius, shadow, variabili brand.
- `style.base.scss`: fondazioni tipografiche/layout, zebra section backgrounds.
- `style.navbar.scss`: navbar/offcanvas/hamburger/stati mobile.
- `style.components.scss`: bottoni globali, card base, badge, area links.
- `style.forms.scss`: form controls + modal feedback + accordion FAQ.
- `style.sections.scss`: file più grande, stili pagina-sezione.
- `style.responsive.scss`: override responsive e casi speciali.

## Variabili principali (estratto)
- Colori:
  - `--color-salvia` (primario azione)
  - `--color-oro` (titoli/accento)
  - `--sfondo-body`, `--sfondo-soft`, etc.
- Ombre:
  - `--ombra-soft`, `--ombra-hover`, `--ombra-navbar`.
- Font:
  - `--font-titoli`: Playfair Display
  - `--font-testo`: system stack.

## Utility e pattern
- `.shadow-soft`, `.surface-soft`, `.badge-soft`.
- Forte skin sui bottoni tramite `$btn-selectors`.

## Classi delicate (alta attenzione)
1. `$btn-selectors` con `!important` in `style.components.scss` (impatto globale su tutti i bottoni).
2. `.navbar-offcanvas__*` (molto accoppiata al markup e al JS).
3. `.area-hero-illustrata` (mix background inline Blade + CSS desktop/mobile).
4. `.contact-feedback-modal*` (modal custom senza import completo Bootstrap modal SCSS).
5. `main > section.section:nth-of-type(...)` (dipende dall’ordine reale delle section nel DOM).
6. `.home-page` body class (override pesanti solo home).

## Responsive design (meccanica reale)
- Mobile landscape: c’è tuning specifico per rendere il menu navigabile (`max-height`, `orientation`).
- Per `<1400` la hero area passa da bg desktop a immagine mobile separata.
- CTA vengono forzate al centro in molti breakpoint.

## Come modificare CSS senza fare danni
1. Parti da `style.tokens.scss` per colori/spazi globali.
2. Evita di modificare subito `style.sections.scss` senza grep/ricerca classe.
3. Se tocchi offcanvas:
   - verifica portrait + landscape + viewport bassa.
4. Se tocchi bottoni:
   - controlla home, contatti, area page, admin.
5. Prima del deploy builda in produzione (PurgeCSS può eliminare classi non viste).
6. Quando aggiungi classi dinamiche JS, mettile in `purge-safelist.txt`.

---

# 7. Design system del sito

## Palette e ruoli

| Ruolo | Colore |
|---|---|
| Primario UI | verde salvia (`--color-salvia`) |
| Accent/headings | oro (`--color-oro`) |
| Sfondo base | crema/avorio (`--sfondo-body`) |
| Superfici card | bianco caldo gradiente |
| Testo | verde-grigio scuro (`--testo-principale`) |

## Tipografia
- Titoli principali: Playfair Display (impronta editoriale/professionale).
- Testi e UI: font system (leggibilità e performance).

## Componenti visuali ricorrenti
- Card con gradienti + ombre morbide.
- CTA con pulsanti primario/secondario coerenti.
- Badge pill.
- Accordion FAQ.
- Hero informativa con points e CTA.

## Pattern grafici usati
- Gradient overlay leggeri su sfondi/sezioni.
- Ombre stratificate per profondità.
- Bordi semi-trasparenti per separazione “morbida”.

---

# 8. Componenti riutilizzabili

| Componente | File | Parametri | Dove usato | Rischio modifiche |
|---|---|---|---|---|
| Layout globale | `views/components/layout.blade.php` | `metaTitle`, `metaDescription`, `ogImage`, `ogImageAlt` | tutte pagine | altissimo impatto SEO e rendering |
| Navbar | `views/components/nav.blade.php` | nessuno pubblico | tutte pagine | navigazione globale |
| Menu navbar | `views/components/nav-menu.blade.php` | `navExtraClass` | desktop+offcanvas | route active/UX |
| Footer | `views/components/footer.blade.php` | usa `$seoContact` | tutte pagine | contatti globali |
| FAQ answer partial | `views/partials/strategic-faq-answer.blade.php` | `faq` | home + contatti | rottura HTML FAQ se placeholders errati |

---

# 9. JavaScript / logica interattiva

## File JS reali
- `resources/js/app.js`
  - importa `bootstrap/js/dist/collapse`
  - importa `./main`.
- `resources/js/main.js`
  - offcanvas behavior + scroll locking
  - reveal animation via IntersectionObserver
  - navbar scroll state throttled
  - modal feedback contatti
  - smooth scroll anchor
  - tracking data attributes.
- `resources/js/bootstrap.js`
  - axios su `window` (attualmente non importato da `app.js`).

## Dipendenze selettori
- Offcanvas dipende da:
  - `#navOffcanvas`
  - classi `navbar-offcanvas__*`
  - classe html `nav-offcanvas-open`.
- Modal feedback dipende da `#contactFormFeedbackModal`.
- Tracking dipende da `[data-track]` e `[data-track-submit]`.

## Rischi se cambi classi/id
- Se rinomini id/classi in Blade senza aggiornare JS:
  - menu non si chiude
  - lock scroll resta attivo
  - popup feedback non appare
  - tracking eventi sparisce.

---

# 10. Framework / librerie / dipendenze

## Composer (runtime)
- `laravel/framework`
- `laravel/tinker`

## NPM
- Bootstrap, Vite, Sass, PurgeCSS, LightningCSS, Fontsource.
- `axios` presente ma non in uso attuale nel bundle.

## Osservazioni
- Progetto leggero, dipendenze frontend essenziali.
- Possibile pulizia: rimuovere axios se non previsto uso.

## Rischi aggiornamento
- Bootstrap major updates possono rompere override SCSS ad alta specificità.
- Vite/PostCSS/PurgeCSS: attenzione a regressioni build produzione.

---

# 11. Routing e generazione delle pagine

## Sistema routing
- Definito in `routes/web.php`.
- Route nominali usate ovunque con `route(...)`.
- Route dinamica principale: `/aree/{slug}`.

## Flusso didattico URL -> HTML
1. URL match su route.
2. Controller recupera dati (`config`, DB, array hardcoded aree).
3. Passaggio a view Blade.
4. View renderizza in `<x-layout>`.
5. Layout aggiunge meta/schema e asset.
6. Risposta HTML finale.

## Middleware
- `throttle:contact-form-submit` solo su POST contatti.
- `basic.auth` su gruppo `/admin`.
- `SecurityHeaders` appeso al middleware web globale.

---

# 12. Gestione contenuti

## Dove si modificano testi
- Home: `resources/views/home.blade.php`.
- Chi sono: `resources/views/chi-sono.blade.php`.
- Contatti: `resources/views/contatti.blade.php`.
- FAQ strategiche condivise: `config/strategic_faqs.php`.
- Aree (titoli/preview/body): `PublicController::getAreas()`.

## Dove si modificano immagini
- File fisici: `public/img/*`.
- Richiamo hero/home/nav/footer via Blade o config.

## Dove si modificano link/CTA
- Navbar: `components/nav-menu.blade.php`.
- Footer: `components/footer.blade.php`.
- CTA pagina: rispettiva view.

## Tabella pratica: “se voglio modificare X”

| Obiettivo | File da toccare |
|---|---|
| Cambiare logo navbar | `components/nav.blade.php` + `public/img/logo.webp/.jpg` |
| Cambiare hero home | `views/home.blade.php` + `style.sections.scss` |
| Cambiare elenco aree home | `views/home.blade.php` (`$aree`) |
| Cambiare contenuti aree singole | `PublicController.php` (`getAreas`) |
| Cambiare colori globali | `style.tokens.scss` |
| Cambiare navbar mobile | `style.navbar.scss` + `main.js` |
| Cambiare footer | `components/footer.blade.php` + `style.sections.scss` |
| Cambiare meta title/description statiche | `config/seo.php` |
| Cambiare OG fallback per route | `SeoLayoutLinkedData::ogImageForRoute` |
| Cambiare FAQ Home/Contatti condivise | `config/strategic_faqs.php` |

---

# 13. Immagini, asset e media

## Posizione file
- `public/img/` contiene asset principali:
  - webp + jpg per social compatibility.

## Naming reale
- esempi: `stress.webp`, `stress.jpg`, `cristina-296.webp`, `og-image.jpg`, `logo.webp/logo.jpg`.

## Uso SEO/social
- Static pages OG image da `config/seo.php`.
- Area pages OG image derivata da immagine area `.jpg` in `area-show.blade.php`.

## Favicon
- `public/favicon.ico`, `public/apple-touch-icon.png`, `public/img/favicon-32x32.png`, `favicon-48x48.png`.

## Possibili criticità
- Assenza pipeline immagini responsive avanzata (`srcset` esteso solo in area mobile picture).
- Alcuni asset duplicati webp/jpg richiedono disciplina di sincronizzazione.

---

# 14. SEO completa del sito

## Impianto SEO tecnico
- Titoli e description statiche: `config/seo.php`.
- Meta rendering: `components/layout.blade.php`.
- OG/Twitter coerenti da stesso set dati.
- JSON-LD globale: `SeoLayoutLinkedData::graph`.
- JSON-LD pagina-specifico:
  - aree: Service + Article + FAQ
  - contatti/primo colloquio: FAQPage.

## Sitemap e robots
- `/sitemap.xml` generata da route closure + view `sitemap.blade.php`.
- `/robots.txt` con `Disallow: /admin` e link sitemap.

## Tabella pagina -> meta SEO (statiche)

| Pagina | Chiave config | Title | OG image |
|---|---|---|---|
| Home | `home` | definito in `config/seo.php` | `img/og-image.jpg` |
| Chi sono | `about` | definito | `img/cristina.jpg` |
| Aree | `areas` | definito | `img/stress.jpg` |
| Primo colloquio | `firstInterview` | definito | `img/cristina.jpg` |
| Contatti | `contacts` | definito | `img/logo.jpg` |
| Testimonianze | `testimonials` | definito | `img/og-image.jpg` |
| Privacy | `privacy` | definito | fallback psychologist og |

## Area pages SEO
- keyword target per area implicita nel titolo/slug.
- meta title/description direttamente dentro `getAreas()`.
- canonical su URL corrente.
- OG image specifica area (jpg).

## Punti forti SEO
- buon livello tecnico (canonical/hreflang/og/twitter/schema/sitemap/test automatici).
- internal linking tra aree.
- local SEO presente (Tivoli, sedi, sameAs GBP).

## Punti deboli SEO reali
1. **Contenuti aree nel controller** (manutenzione fragile, rischio inconsistenze).
2. **Duplicazione slug** tra controller, sitemap route array e altri punti.
3. `og:type` settato `article` per quasi tutto (non sempre semanticamente ideale).
4. JSON-LD multipli nelle aree con potenziale ridondanza.

## Keyword/intento (stima ragionata)

| Pagina | Keyword principale probabile | Intento |
|---|---|---|
| Home | psicologa Tivoli | navigazionale + local service |
| Chi sono | psicologa Tivoli chi sono | trust/e-e-a-t |
| Aree | psicologa ansia tivoli / aree intervento | informativo-commerciale |
| Primo colloquio | primo colloquio psicologico tivoli | conversione |
| Contatti | contatti psicologa tivoli | conversione diretta |
| Testimonianze | testimonianze psicologa tivoli | trust proof |

---

# 15. Accessibilità

## Buone pratiche presenti
- H1 generalmente unico per pagina (coperto da test).
- Label form presenti.
- aria-label su diversi controlli.
- focus-visible curato in CSS.
- accordion bootstrap con attributi aria.

## Criticità/migliorabili
- Contrasto da verificare puntualmente su alcune combinazioni oro/crema.
- Honeypot è hidden visualmente (ok), ma sempre bene testarlo con screen reader reali.
- Alcuni blocchi densi possono essere migliorati con landmark aggiuntivi.

---

# 16. Performance e ottimizzazione

## Stato attuale
- SSR Blade: ottimo TTFB percepito su pagine semplici.
- CSS/JS bundling Vite.
- PurgeCSS solo produzione.
- preload risorse critiche nel layout.

## Criticità principali
1. CSS molto esteso (`style.sections.scss` + `style.responsive.scss` grandi).
2. PublicController molto pesante (contenuti HTML inline).
3. Possibili regressioni PurgeCSS se classi dinamiche non safelistate.

## Interventi prioritari
1. Spostare contenuti aree da controller a file strutturati (DB/markdown/blade partials).
2. Spezzare SCSS monolitico sezioni/responsive per dominio pagina.
3. Pulire dipendenze JS inutilizzate (axios se davvero non usato).

---

# 17. Sicurezza e robustezza

## Presidi presenti
- CSRF forms.
- validazione robusta lato server.
- honeypot + spam detector + rate limit contatti.
- security headers + CSP nonce.
- HSTS su HTTPS.

## Fragilità
- Admin protetto solo da Basic Auth con credenziali env (niente session auth, niente lockout).
- POST testimonianze senza throttle/honeypot come contatti.
- `trustProxies('*')` molto permissivo.

## Dati sensibili / env
- `ADMIN_USER`, `ADMIN_PASS`, `MAIL_*`, `CONTACT_TO_*`, `GOOGLE_BUSINESS_PROFILE_URL`.
- `.env.example` non documenta `ADMIN_*`: da migliorare.

---

# 18. Modifiche pratiche guidate

## Cambiare testi (pagina)
1. Apri view pagina (`resources/views/...`).
2. Cerca sezione card/hero.
3. Modifica testo.
4. Controlla impatto mobile.

## Cambiare colori globali
1. `style.tokens.scss`.
2. Aggiorna variabili.
3. Verifica bottoni/card/navbar/footer.

## Aggiungere nuova area
1. Aggiungi blocco area in `PublicController::getAreas()`.
2. Aggiorna slug in sitemap (`routes/web.php` array `$areaSlugs`).
3. Aggiorna eventualmente home list aree (`home.blade.php`).
4. Verifica test SEO/feature.

## Modificare meta SEO pagina statica
1. `config/seo.php` -> `pages.<chiave>`.
2. Controlla title/description/og_image_alt.
3. Verifica rendering head.

## Cambiare form contatti
1. `contatti.blade.php` (markup).
2. `PublicController::submit` (validazione/logica).
3. `config/antispam.php` (se rate/honeypot).
4. Testare errori/success/warning modal.

## Cosa NON toccare alla cieca
- regex FAQ in `PublicController` senza capire markup.
- classi offcanvas senza aggiornare JS.
- layout meta tags (rischio SEO globale).

---

# 19. Mappa delle dipendenze

## Nodi centrali
1. `components/layout.blade.php`
2. `PublicController.php`
3. `routes/web.php`
4. `style.sections.scss`
5. `style.navbar.scss`
6. `SeoLayoutLinkedData.php`

## Modifiche ad impatto ampio
- Cambiare token colore -> impatta quasi tutto.
- Cambiare nav-menu -> impatta desktop+mobile+active states.
- Cambiare struttura section in home -> impatta zebra/background alternation.
- Cambiare key route names -> rompe links/meta/schema/tests.

---

# 20. Errori, debito tecnico e miglioramenti

## Cose fatte bene
- SEO tecnico sopra media per sito vetrina.
- Test feature utili e specifici.
- Protezioni form contatti ben implementate.
- Coerenza visuale curata.

## Debito tecnico
- **P1:** contenuti area hardcoded nel controller.
- **P1:** duplicazione slug/mapping in più file.
- **P2:** SCSS monolitico e duplicazioni responsive.
- **P2:** admin auth minimale.
- **P3:** dipendenze JS non usate/documentazione README non customizzata.

## Refactor consigliati
1. estrarre aree in repository/config dedicata.
2. centralizzare slug in unica source of truth.
3. split SCSS per pagina e ridurre override incrociati.
4. introdurre auth admin con guard/session.
5. introdurre test end-to-end minimi su nav/offcanvas/form.

---

# 21. Spiegazione didattica finale

## Come “ragiona” questo sito
- È un **Laravel SSR orientato contenuto+conversione**:
  - contenuto professionale
  - CTA contatto
  - supporto SEO locale
  - interattività minima ma efficace.

## Colonne portanti da studiare per prime
1. `routes/web.php`
2. `PublicController.php`
3. `components/layout.blade.php`
4. `config/seo.php`
5. `contatti.blade.php`
6. `style.tokens.scss` + `style.sections.scss` + `style.navbar.scss`.

## Ordine consigliato di apprendimento
1. Routing -> Pagine -> Layout.
2. SEO config + SEO renderer.
3. Form contatti end-to-end.
4. Sistema SCSS.
5. Admin mini-backoffice.
6. Test suite.

## Esercizi pratici per padroneggiarlo
1. Cambiare titolo/description/og di una pagina e verificare output HTML.
2. Aggiungere una FAQ strategica condivisa Home+Contatti.
3. Aggiungere una nuova area completa.
4. Rifinire un componente card mantenendo coerenza mobile.
5. Aggiungere un test feature mirato.

---

# 22. Allegati utili

## A) Tabella “file -> funzione”

| File | Funzione sintetica |
|---|---|
| `routes/web.php` | mappa URL e endpoint |
| `PublicController.php` | logica pagine pubbliche e form |
| `layout.blade.php` | shell globale/meta/schema/assets |
| `config/seo.php` | contenuti SEO statici + entity data |
| `SeoLayoutLinkedData.php` | JSON-LD e og-image per route |
| `contatti.blade.php` | pagina conversione primaria |
| `main.js` | interazioni front-end principali |
| `style.tokens.scss` | design tokens |
| `style.navbar.scss` | navbar/offcanvas |
| `style.sections.scss` | stili sezioni/pagine |

## B) Tabella “modifica desiderata -> file da toccare”

| Modifica desiderata | File |
|---|---|
| Nuova voce menu | `components/nav-menu.blade.php` |
| Cambiare CTA footer | `components/footer.blade.php` |
| Cambiare OG home | `config/seo.php` (`pages.home.og_image`) |
| Cambiare blocchi FAQ condivise | `config/strategic_faqs.php` |
| Cambiare copy area specifica | `PublicController::getAreas()` |
| Cambiare look bottoni globali | `style.components.scss` |
| Cambiare comportamento offcanvas | `style.navbar.scss` + `main.js` |

## C) Tabella “pagina -> meta SEO”

| Pagina | Meta source |
|---|---|
| Home | `config/seo.php -> pages.home` |
| Chi sono | `pages.about` |
| Aree | `pages.areas` |
| Primo colloquio | `pages.firstInterview` |
| Contatti | `pages.contacts` |
| Testimonianze | `pages.testimonials` |
| Privacy | `pages.privacy` |
| Area dettaglio | `PublicController::getAreas()` + fallback suffix config |

## D) Tabella “componenti -> dove usati”

| Componente | Utilizzo |
|---|---|
| `<x-layout>` | tutte le pagine pubbliche e admin |
| `<x-nav>` | incluso nel layout |
| `<x-footer>` | incluso nel layout |
| `components.nav-menu` | navbar desktop + offcanvas |
| `partials.strategic-faq-answer` | accordion Home/Contatti |

## E) Checklist finale per chi mette mano al progetto

- [ ] Ho capito se la modifica è globale o locale?  
- [ ] Ho identificato file CSS/JS/Blade dipendenti?  
- [ ] Ho verificato mobile portrait + landscape?  
- [ ] Ho controllato head meta/canonical/og se tocco pagine?  
- [ ] Ho verificato form errors/success se tocco contatti?  
- [ ] Ho considerato PurgeCSS in build produzione?  
- [ ] Ho controllato test SEO/feature principali?  

---

## Nota finale

Questa documentazione è costruita sul codice reale presente nel repository al momento dell’analisi.  
Le parti indicate come “stima/intento probabile” (es. keyword target) sono inferenze ragionate basate su struttura URL, copy e metadati.

