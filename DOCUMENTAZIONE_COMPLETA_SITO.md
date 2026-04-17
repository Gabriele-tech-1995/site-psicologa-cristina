# DOCUMENTAZIONE COMPLETA SITO — HANDOVER TECNICO ESTESO

> Progetto: sito professionale Dott.ssa Cristina Pacifici  
> Repository: `/workspace`  
> Data analisi: ambiente cloud Linux, branch di lavoro dedicato  
> Scopo documento: trasferire know-how tecnico completo a chi deve mantenere, evolvere e governare il progetto.

---

## Premessa metodologica

Questa documentazione è basata sulla lettura diretta del codice sorgente (backend, Blade, SCSS, JS, config, migrazioni, test).  
Quando trovi note del tipo **“inferenziale”**, significa che il comportamento non è esplicitamente commentato nel codice ma è dedotto in modo ragionato da struttura e dipendenze.

---

# 1. PANORAMICA GENERALE DEL PROGETTO

## 1.1 Nome e scopo
- Il repository nasce da skeleton Laravel (`laravel/laravel`) ma implementa un sito reale di psicologia clinica.
- Obiettivi concreti del sito:
  1. presentare identità professionale;
  2. descrivere aree di intervento;
  3. acquisire richieste dal form contatti;
  4. pubblicare testimonianze moderate;
  5. mantenere una base SEO tecnica forte (meta, schema, sitemap, robots, OG/Twitter).

## 1.2 Tipologia del sito
- **Sito vetrina professionale local SEO oriented**.
- Non è e-commerce, non è SaaS, non è blog CMS dinamico classico.
- C’è un piccolo backoffice operativo su `/admin` per moderazione contenuti utente.

## 1.3 Stack tecnologico
- **PHP 8.2+**
- **Laravel 12**
- **Blade Components**
- **Vite 7** (bundling assets)
- **Bootstrap 5.3** (componenti base)
- **SCSS custom esteso** (design system proprietario)
- **PostCSS + PurgeCSS (solo produzione)**
- **MySQL / SQLite** (config standard Laravel)

## 1.4 Architettura generale
- Monolite Laravel server-rendered.
- No API pubbliche, no frontend framework SPA.
- Flusso request-response tradizionale:
  - route -> controller -> view -> layout -> risposta HTML.

## 1.5 Filosofia costruttiva
- Forte controllo editoriale sul contenuto (molto copy direttamente in Blade/PHP).
- SEO e semantica strutturata integrate in modo nativo lato server.
- Riduzione complessità JS al minimo indispensabile per UX.
- Coerenza visuale curata attraverso token CSS e macro-file SCSS.

## 1.6 Flusso generale di funzionamento
1. HTTP entra in `public/index.php`.
2. Bootstrap app in `bootstrap/app.php`.
3. Route matching in `routes/web.php`.
4. Controller genera dati/metadati.
5. Blade page usa `<x-layout>`.
6. Layout emette head completo, schema, nav/footer.
7. JS enhancement (menu offcanvas, reveal, tracking, modale feedback form).

## 1.7 Organizzazione codice
- **Centro logico pubblico:** `app/Http/Controllers/PublicController.php`
- **Centro SEO:** `config/seo.php` + `app/Support/SeoLayoutLinkedData.php`
- **Centro UI globale:** `resources/views/components/layout.blade.php`
- **Centro stile:** `resources/css/style.sections.scss` + `style.responsive.scss`

---

# 2. STRUTTURA COMPLETA DEL PROGETTO

## 2.1 Albero cartelle/file principali

```text
/workspace
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   ├── ContactRequestController.php
│   │   │   │   └── TestimonialController.php
│   │   │   ├── Controller.php
│   │   │   └── PublicController.php
│   │   └── Middleware
│   │       ├── BasicAuth.php
│   │       └── SecurityHeaders.php
│   ├── Mail
│   │   ├── ContactRequestConfirmMail.php
│   │   └── ContactRequestMail.php
│   ├── Models
│   │   ├── ContactRequest.php
│   │   ├── Testimonial.php
│   │   └── User.php
│   ├── Providers
│   │   └── AppServiceProvider.php
│   └── Support
│       ├── SeoContact.php
│       ├── SeoLayoutLinkedData.php
│       ├── SitemapLastmod.php
│       └── SpamDetector.php
├── bootstrap/app.php
├── config
│   ├── antispam.php
│   ├── seo.php
│   ├── security.php
│   ├── strategic_faqs.php
│   └── ...config Laravel standard...
├── database/migrations
├── public
│   ├── index.php
│   ├── favicon.ico
│   ├── apple-touch-icon.png
│   └── img/*
├── resources
│   ├── css/*
│   ├── js/*
│   └── views/*
├── routes/web.php
├── tests/*
├── composer.json
├── package.json
├── postcss.config.cjs
└── vite.config.js
```

## 2.2 Cartelle importanti e ruolo

| Cartella | Perché è importante |
|---|---|
| `app/Http/Controllers` | contiene la logica business del sito |
| `app/Support` | ospita servizi chiave SEO/anti-spam/sitemap |
| `resources/views` | output HTML reale del sito |
| `resources/css` | identità visiva e responsive |
| `resources/js` | interazioni progressive |
| `config` | parametri di comportamento globale |
| `routes` | mappa URL -> handler |
| `tests` | rete di sicurezza regressioni |

## 2.3 File indispensabili vs secondari

### Indispensabili
- `routes/web.php`
- `app/Http/Controllers/PublicController.php`
- `resources/views/components/layout.blade.php`
- `config/seo.php`
- `resources/css/style.sections.scss`
- `resources/css/style.responsive.scss`

### Secondari
- `routes/console.php` (solo comando inspire)
- `tests/*ExampleTest.php` (placeholder)
- `README.md` (non customizzato, boilerplate Laravel)

## 2.4 File “governo globale”

| File | Governa |
|---|---|
| `components/layout.blade.php` | head/meta/schema/caricamento assets |
| `SecurityHeaders.php` | CSP e hardening HTTP |
| `AppServiceProvider.php` | rate limit contatti + dati contatto globali in view |
| `style.tokens.scss` | palette/design token |
| `SeoLayoutLinkedData.php` | JSON-LD globale e OG route-based |

## 2.5 Mappa collegamenti file
- `routes/web.php` chiama `PublicController`.
- `PublicController` passa dati a `resources/views/*.blade.php`.
- Le view usano sempre `<x-layout>`.
- `<x-layout>` usa:
  - `SeoLayoutLinkedData`
  - `$seoContact` da `View::composer`
  - `@vite`.
- `@vite` monta `resources/css/app.scss` e `resources/js/app.js`.
- `app.js` importa `main.js`.

---

# 3. ANALISI FILE PER FILE

> In questa sezione trovi la lettura “operativa”: dove, cosa fa, dipendenze, cosa rompi se modifichi male.

## 3.1 Backend (controller, middleware, support, model)

### `app/Http/Controllers/PublicController.php`
- **Dove:** `app/Http/Controllers/PublicController.php`
- **Serve a:** gestire praticamente tutto il sito pubblico.
- **Contiene:**
  - metodi pagina (`home`, `about`, `areas`, `areaShow`, `firstInterview`, `contact`, `testimonials`)
  - submit contatti con validazione, honeypot, spam check, invio mail
  - submit testimonianze
  - `getAreas()` con contenuti area hardcoded
  - parser FAQ area (`extractAreaFaqPairs`, `formatAreaFaqAsAccordion`)
- **Dipende da:** `config/seo.php`, `SpamDetector`, `ContactRequest`, `Testimonial`, `Mail`.
- **È centrale?** Sì, massimamente.
- **Se modifichi qui:**
  - impatti contenuti SEO, form, rendering aree, schema FAQ.
- **Errori tipici da evitare:**
  1. cambiare struttura HTML FAQ nelle aree senza adeguare regex;
  2. aggiungere area in `getAreas()` ma dimenticare sitemap/slug altrove;
  3. introdurre validazioni incompatibili con UX mobile.

### `app/Http/Controllers/Admin/ContactRequestController.php`
- Index/show/mark read/destroy richieste.
- Rischio basso-medio: impatta gestione interna, non frontend pubblico.

### `app/Http/Controllers/Admin/TestimonialController.php`
- Index/show/approve/unapprove/destroy testimonianze.
- Rischio medio: può alterare moderazione e pubblicazione.

### `app/Http/Middleware/SecurityHeaders.php`
- Aggiunge:
  - X-Frame-Options
  - X-Content-Type-Options
  - Referrer-Policy
  - Permissions-Policy
  - COOP/CORP
  - HSTS (solo HTTPS)
  - CSP con nonce.
- Rischio alto: direttive CSP sbagliate bloccano script/embed/mappe.

### `app/Http/Middleware/BasicAuth.php`
- Protegge `/admin` via credenziali basic da env.
- Fragile per sicurezza enterprise (niente lockout, niente hash dedicato).

### `app/Support/SeoLayoutLinkedData.php`
- `ogImageForRoute()` mappa route->immagine.
- `graph()` costruisce `@graph` globale (WebSite, Person, Psychologist, WebPage + breadcrumb).
- Gestisce `mainEntity` su route `about`.
- Cache nodi statici 1h.
- Rischio SEO alto se mapping route incoerente.

### `app/Support/SeoContact.php`
- Normalizza email/tel/whatsapp.
- Genera embed maps (`maps_embed_src`) da URL o geocoding query.
- Inietta dati globali usati da nav/footer/contatti.

### `app/Support/SitemapLastmod.php`
- Associa route a “sorgenti file” e calcola `lastmod` via mtime max.
- Limite: tutte le aree condividono le stesse fonti, quindi stesso `lastmod`.

### `app/Support/SpamDetector.php`
- Euristiche keyword/URL shortener/contatti “promozionali”.
- Buona barriera anti-spam, ma euristica = mai perfetta.

### Modelli
- `ContactRequest`: tabella `contact_requests`.
- `Testimonial`: tabella `testimonials`.
- `User`: standard Laravel (attualmente non al centro del flusso admin).

## 3.2 Frontend server-rendered (Blade)

### `resources/views/components/layout.blade.php`
- Shell globale.
- Parametri: `metaTitle`, `metaDescription`, `ogImage`, `ogImageAlt`.
- Sezione `<head>` estremamente importante.
- Inserisce schema JSON-LD globale.
- Carica nav/footer e assets.
- Se rompi questo file, rompi tutto il sito.

### `components/nav.blade.php`
- Header desktop + mobile offcanvas.
- Offcanvas include CTA rapide e contatti.
- Accoppiato con `style.navbar.scss` e `resources/js/main.js`.

### `components/footer.blade.php`
- Footer a 3 colonne, link rapidi, privacy link.
- Usa `$seoContact` iniettato globalmente.

### Pagine
- `home.blade.php`: funnel principale con hero, proof, FAQ.
- `chi-sono.blade.php`: pagina autorevolezza.
- `aree.blade.php`: listing semplificato aree.
- `area-show.blade.php`: template più complesso SEO/content.
- `primo-colloquio.blade.php`: orientata conversione con FAQ.
- `contatti.blade.php`: form core, mappe, FAQ, modal feedback.
- `testimonianze.blade.php`: list + form UGC.
- `privacy.blade.php`: policy legale.

## 3.3 Config

### `config/seo.php`
- Cuore SEO statico.
- Definisce:
  - defaults title suffix
  - anagrafica professionista + sameAs + sedi
  - meta statiche pagine.
- Rischio: incoerenza copy/route/og se modificato senza verifica.

### `config/strategic_faqs.php`
- FAQ condivise home/contatti.
- Supporta `answer` (schema plain) e `answer_html` (accordion render).

### `config/antispam.php`
- Honeypot field name.
- limiti per minute/hour/hour per email.

### `config/security.php`
- Toggle globali hardening.
- include commenti utili per gestione environment.

### `config/mail.php`
- destinazione modulo (`mail.contact.*`) e provider mail.

## 3.4 JS e SCSS

### JS
- `resources/js/main.js` = logica client completa.
- `resources/js/app.js` = entrypoint.
- `resources/js/bootstrap.js` = axios helper (non importato ora).

### SCSS
- `app.scss` e `admin.scss` entry.
- Tema in `style.scss` e moduli.
- File “fragile” principale: `style.sections.scss` (ampio, cross-page).

## 3.5 Migrazioni

| Migrazione | Oggetto |
|---|---|
| `create_contact_requests_table` | form contatti |
| `add_is_read_to_contact_requests` | stato lettura admin |
| `create_testimonials_table` | testimonianze UGC |
| 3 migrazioni `0001_*` | users/cache/jobs standard Laravel |

## 3.6 Test

- `SeoTest.php`: eccellente rete regressioni SEO.
- `PublicSiteTest.php`: smoke + form + anti-spam + auth admin.
- `SecurityHeadersTest.php`: verifica header sicurezza.

---

# 4. STRUTTURA DELLE PAGINE

## 4.1 Home (`/`)
- **File:** `resources/views/home.blade.php`
- **Layout:** `<x-layout>`
- **Componenti:** hero, trust strip, local proof, formazione, FAQ.
- **Dati:** aree principali hardcoded in view + FAQ da config + `$seoContact`.
- **Script rilevanti:** reveal, tracking click CTA, smooth anchors.
- **Stili dominanti:** `style.sections.scss` + responsive.
- **SEO:** meta statiche `seo.pages.home`, JSON-LD globale + FAQ HTML (schema FAQ solo in contatti).
- **Come modificarla:**
  - contenuti: nella view
  - CTA: stessa view
  - look: sections/responsive SCSS
  - attenzione a non perdere coerenza CTA con altre pagine.

## 4.2 Chi sono (`/chi-sono`)
- **File:** `chi-sono.blade.php`
- **Obiettivo:** authority/profilo + trust legale-formativo.
- **Schema:** `ProfilePage` (da `SeoLayoutLinkedData`).
- **Rischio:** mismatch tono/coerenza link interni.

## 4.3 Aree listing (`/aree`)
- **File:** `aree.blade.php`
- **Dati:** `$areas` dal controller.
- **Comportamento:** cards con link a dettaglio.
- **Rischio:** se `getAreas()` cambia e card non gestisce nuovi campi.

## 4.4 Area dettaglio (`/aree/{slug}`)
- **File:** `area-show.blade.php`
- **Dati:** area selezionata da `getAreas()`.
- **SEO/social:** passa `:ogImage="$areaImageJpg"` al layout.
- **Schema extra:** BreadcrumbList + Service + Article + FAQPage opzionale.
- **Comportamenti:** body area + FAQ convertita in accordion.
- **Rischio alto:** modifiche markup body possono rompere parser FAQ/schema.

## 4.5 Primo colloquio (`/primo-colloquio`)
- **File:** `primo-colloquio.blade.php`
- **Target:** rassicurare + convertire.
- **Schema:** FAQPage locale.

## 4.6 Contatti (`/contatti`)
- **File:** `contatti.blade.php`
- **Dati:** faq config + seoContact + old input/errors/session.
- **Comportamenti chiave:**
  - honeypot hidden field
  - validazione server + redirect con fragment
  - modal feedback success/warning
  - mappe embed per sedi.
- **Rischio alto:** ogni regressione qui impatta lead generation.

## 4.7 Testimonianze (`/testimonianze`)
- list pubblicate + form invio.
- Form con consenso pubblicazione e moderazione successiva.

## 4.8 Privacy (`/privacy-policy`)
- informativa legale server-rendered.
- ultimo aggiornamento usa `now()->format(...)` (data dinamica runtime).

---

# 5. LAYOUT GLOBALE DEL SITO

## 5.1 Struttura layout principale
- `head`:
  - meta base
  - canonical/hreflang
  - OG/Twitter complete
  - preload (font/css/js/hero image)
  - favicon set.
- `body`:
  - nav
  - main slot
  - footer
  - floating whatsapp
  - schema
  - js bundle.

## 5.2 Header / navbar
- Desktop:
  - brand + nav links inline.
- Mobile:
  - toggler custom hamburger
  - offcanvas con:
    - intro persona
    - menu principale
    - blocco contatti/CTA
    - azione chiusura.

## 5.3 Footer
- Sezioni:
  1. identità e albo/ASPIC
  2. modalità di ricezione
  3. contatti e quick links.

## 5.4 Container, spacing, max width
- Base Bootstrap `.container`.
- molte card con padding custom.
- spacing pilotato da token + regole sezione.

## 5.5 Breakpoint e coerenza visiva
- sistema multi-breakpoint e query orientamento/altezza.
- coerenza ottenuta da:
  - token cromatici
  - bottoni globali
  - card style coerenti
  - CTA patterns ripetuti.

---

# 6. CSS / SCSS / STILE COMPLETO

## 6.1 Entry e build CSS
- Entry pubblica: `resources/css/app.scss`
- Entry admin: `resources/css/admin.scss`
- Entrambe importano bootstrap split + `style.scss`.

## 6.2 Bootstrap split (perché importante)
- `_bootstrap-a-config.scss`: foundations grid/reboot/type.
- `_bootstrap-b-components.scss`: componenti scelti.
- `_bootstrap-c-tail.scss`: helpers/utilities api.
- Vantaggio: controllo granulare e bundle più governabile.

## 6.3 Design token (`style.tokens.scss`)
- Variabili root:
  - palette
  - font family
  - ombre
  - bordi
  - scale spazi.
- Variabile SCSS `$btn-selectors`: usata per skin bottoni globali.

## 6.4 Base styles (`style.base.scss`)
- Sfondo body multistrato con gradienti/radiali.
- regole tipografiche globali.
- zebra alternation sezioni con `nth-of-type`.
- focus-visible standardizzati.

## 6.5 Navbar styles (`style.navbar.scss`)
- navbar sticky glassmorphism/warm.
- mobile brand grid centering complesso.
- offcanvas full module:
  - header/body/fill/intro/nav/footer/finale.
- media queries dedicate a landscape piccolo.

## 6.6 Component styles (`style.components.scss`)
- Bottoni:
  - gradienti, bordi, ombre, hover/focus/active.
  - usa `!important` (decisione forte).
- card globali:
  - look depth + pseudo-elementi.
- badge/area links.

## 6.7 Form styles (`style.forms.scss`)
- input/select/checkbox custom look.
- honeypot invisibile.
- modale feedback contatti (custom shell).
- accordion FAQ look and feel.

## 6.8 Section styles (`style.sections.scss`)
- cuore visuale di tutte le pagine:
  - home intro/hero/trust/local-proof
  - about
  - area page
  - contatti
  - testimonianze
  - admin tables/cards
  - footer, toast, whatsapp float, privacy.

## 6.9 Responsive styles (`style.responsive.scss`)
- override per:
  - area hero desktop/mobile
  - sticky sidebar
  - centering CTA su breakpoints
  - mobile typography harmonization
  - footer compact
  - prefers-reduced-motion.

## 6.10 Stati hover/focus/active
- bottoni: definiti in components.
- nav-link active/hover.
- card hover con elevazione.
- focus-visible su elementi interattivi.

## 6.11 Z-index e layer
- navbar/offcanvas/modal/floating whatsapp sono i principali layer sensibili.
- offcanvas e modal hanno gestioni z-index specifiche.

## 6.12 Gestione immagini/background
- area hero usa background inline + image-set webp/jpg.
- mobile area usa `<picture>` separato.
- attenzione a `background-repeat/size`.

## 6.13 “Come mettere mano al CSS senza fare danni”
1. tocca prima `style.tokens.scss` (se cambi design system).
2. cerca classe in `sections` e `responsive` insieme (non in uno solo).
3. se tocchi navbar/offcanvas, testa:
   - mobile portrait
   - mobile landscape
   - viewport bassa.
4. se tocchi bottoni globali, fai check su:
   - home
   - contatti
   - admin
   - area actions.
5. ricordati PurgeCSS in produzione.

---

# 7. DESIGN SYSTEM DEL SITO

## 7.1 Palette

| Token | Ruolo |
|---|---|
| `--color-salvia` | azione primaria, identità professionale |
| `--color-oro` | heading/accenti premium |
| `--sfondo-body` | base calda/avorio |
| `--sfondo-soft*` | superfici morbide |
| `--testo-principale` | corpo testo |

## 7.2 Tipografia
- Titoli: Playfair Display (600/700).
- Corpo: stack system.
- gerarchie gestite da H1-H5 + classi (`page-title`, `page-lead`, ecc.).

## 7.3 Bottoni
- pattern primario/secondario condiviso.
- altissima coerenza visiva ma alta accoppiatura (skin globale unica).

## 7.4 Card e superfici
- card come unità base ricorrente.
- gradient + border + shadow = profondità.

## 7.5 Form
- style custom uniforme.
- attenzione a validazione visiva error states.

## 7.6 Hero e CTA
- Hero home + hero area come pattern dominanti.
- CTA doppia ricorrente:
  - richiedi primo colloquio
  - whatsapp.

---

# 8. COMPONENTI RIUTILIZZABILI

## 8.1 Elenco componenti principali

| Nome | File | Props/Varianti | Usato dove |
|---|---|---|---|
| Layout | `components/layout.blade.php` | `metaTitle`, `metaDescription`, `ogImage`, `ogImageAlt` | tutte le pagine |
| Nav | `components/nav.blade.php` | n/a | tutte |
| Nav Menu | `components/nav-menu.blade.php` | `navExtraClass` | navbar desktop+offcanvas |
| Footer | `components/footer.blade.php` | n/a (usa `seoContact`) | tutte |
| Strategic FAQ Answer | `partials/strategic-faq-answer.blade.php` | `faq` | home+contatti |

## 8.2 Rischi per componente
- Layout: rischio globale massimo.
- Nav/Menu: rischio navigazione e accessibilità.
- Footer: rischio contatti incoerenti.
- FAQ partial: rischio mismatch schema/render.

---

# 9. JAVASCRIPT / LOGICA INTERATTIVA

## 9.1 Cosa fa davvero JS
- Non gestisce routing o stato app.
- Fa enhancement UX su pagine SSR:
  - offcanvas
  - reveal
  - navbar shrink behavior
  - modal feedback
  - smooth anchor
  - tracking.

## 9.2 Ordine esecuzione
- `app.js` -> `main.js`.
- main.js registra listener su `DOMContentLoaded`.
- per modal contatti gestisce anche caso documento già caricato (`readyState`).

## 9.3 Event listener chiave
- click delegato su offcanvas per close.
- scroll/resize con RAF throttling.
- submit/click tracking via data attributes.

## 9.4 Dipendenze da selettori
- Se cambi id/class in Blade, aggiorna JS.
- Se aggiungi CTA da tracciare, metti `data-track`.

## 9.5 Se c’è poco JS?
- Sì: volutamente “poco ma utile”, coerente con sito vetrina SSR.

---

# 10. FRAMEWORK / LIBRERIE / DIPENDENZE

## 10.1 Framework principali
- Laravel 12
- Bootstrap 5.3
- Vite 7
- Sass

## 10.2 Perché usati
- Laravel: struttura backend + Blade + config/test.
- Bootstrap: componenti e grid robusti.
- SCSS custom: branding forte.
- Vite: pipeline moderna build asset.

## 10.3 Dipendenze potenzialmente inutili
- `axios` presente ma non usato in bundle attuale (bootstrap.js non importato).

## 10.4 Rischi aggiornamento
- Bootstrap update può rompere override CSS molto specifici.
- PurgeCSS pattern/safelist da mantenere.

---

# 11. ROUTING E GENERAZIONE DELLE PAGINE

## 11.1 Rotte principali
- `GET /` home
- `GET /chi-sono`
- `GET /aree`
- `GET /aree/{slug}`
- `GET /primo-colloquio`
- `GET /contatti`
- `POST /contatti` (throttle)
- `GET /testimonianze`
- `POST /testimonianze`
- `GET /privacy-policy`
- `GET /sitemap.xml`
- `GET /robots.txt`
- gruppo `/admin/*` con `basic.auth`.

## 11.2 Parametri URL e slug
- Slug area in route dinamica.
- Lista slug è duplicata in sitemap closure (punto fragile).

## 11.3 Middleware e flusso
- security headers globali web.
- throttle solo su submit contatti.
- basic auth su admin.

---

# 12. GESTIONE CONTENUTI

## 12.1 Testi
- Quasi tutti in Blade + blocchi area in controller.
- FAQ condivise in config dedicata.

## 12.2 Immagini
- fisiche in `public/img`.
- richiamo da Blade o config SEO.

## 12.3 Link e bottoni
- menu in `nav-menu`.
- CTA in pagine e footer.

## 12.4 Hardcoded e duplicazioni
- aree hardcoded nel controller.
- slug replicati in più punti.
- home ha lista aree sintetica separata.

## 12.5 Tabella pratica “SE VOGLIO MODIFICARE X”

| Voglio modificare | File |
|---|---|
| Logo | `components/nav.blade.php`, `public/img/logo.*` |
| Navbar menu | `components/nav-menu.blade.php` |
| Hero homepage | `home.blade.php` |
| Card aree home | `home.blade.php` |
| Card aree listing | `aree.blade.php` |
| Contenuto area singola | `PublicController::getAreas()` |
| Colori globali | `style.tokens.scss` |
| Footer | `components/footer.blade.php` |
| Meta title/description statiche | `config/seo.php` |
| FAQ strategiche | `config/strategic_faqs.php` |
| Form contatti validazione | `PublicController::submit()` |

---

# 13. IMMAGINI, ASSET E MEDIA

## 13.1 Dove sono
- `public/img/*`
- root public per favicon/apple-touch.

## 13.2 Tipologie
- decorative (hero, profile)
- funzionali SEO/social (og images jpg)
- icone/favicon.

## 13.3 Naming
- generalmente semantico per area (`stress`, `autostima`, `dsa`).
- presenza doppio formato `.webp` e `.jpg`.

## 13.4 OG/social preview
- statiche da config seo.
- aree da `area-show` jpg.

## 13.5 Criticità asset
- niente pipeline automatica variant responsive.
- mantenimento manuale doppio formato.

---

# 14. SEO COMPLETA DEL SITO

## 14.1 Meta e social tags
- Centralizzati in layout:
  - title
  - description
  - canonical
  - hreflang
  - og fields
  - twitter fields.

## 14.2 URL structure
- pulita, semantica, senza query necessarie.
- aree in `/aree/{slug}`.

## 14.3 Headings
- test coprono H1 singolo per pagine principali + aree.

## 14.4 Internal linking
- forte link interno tra aree correlate.
- link da home/chi sono/contatti verso aree e primo colloquio.

## 14.5 Structured data
- globale: WebSite/Person/Psychologist/WebPage + breadcrumb route-based.
- locale:
  - area: Service + Article + FAQPage.
  - contatti/primo colloquio: FAQPage.

## 14.6 Robots e sitemap
- robots: allow public + disallow admin.
- sitemap: route XML con `lastmod`, `priority`.

## 14.7 SEO per pagina (forza/debolezza)

| Pagina | Punti forti | Punti deboli |
|---|---|---|
| Home | copy locale + CTA + schema globale | densità contenuto alta, manutenzione manuale |
| Chi sono | trust signals (albo/formazione) + ProfilePage | pagina lunga: attenzione leggibilità mobile |
| Aree | cluster semantico servizi | dipende da qualità contenuti getAreas |
| Area detail | meta specifiche + og per area + schema ricco | parser FAQ fragile |
| Primo colloquio | conversione + FAQ schema | mantenere coerenza CTA con resto sito |
| Contatti | conversione forte + faq + sedi/maps | pagina complessa, facile regressione UI |
| Testimonianze | social proof | niente aggregate rating schema (scelta prudente) |

## 14.8 Opportunità SEO realistiche
1. Centralizzare contenuti area in sorgente più manutenibile.
2. Unificare source slug.
3. Valutare miglioramento `og:type` per pagine non article.
4. Consolidare JSON-LD in grafo unico per pagina (opzionale evolutivo).

---

# 15. ACCESSIBILITÀ

## 15.1 Stato attuale
- label form presenti.
- focus-visible definito.
- aria in accordion/offcanvas/modal presenti.
- heading structure abbastanza curata.

## 15.2 Verifiche consigliate
- contrast ratio su combinazioni oro/crema in tutte le card.
- navigazione tastiera completa su offcanvas mobile.
- test screen reader su modale feedback contatti.

## 15.3 Miglioramenti consigliati
- aggiungere audit automatico axe/lighthouse CI.
- verificare semantic landmarks su alcune sezioni dense.

---

# 16. PERFORMANCE E OTTIMIZZAZIONE

## 16.1 Stato
- SSR efficiente.
- preload risorse critiche.
- bundle css/js ottimizzati.
- PurgeCSS attivo in produzione.

## 16.2 Collo di bottiglia probabili
- CSS grande e centralizzato.
- PublicController molto voluminoso.
- immagini senza pipeline automatica advanced.

## 16.3 Priorità intervento
1. modularizzare contenuti aree.
2. modularizzare SCSS sections/responsive.
3. ridurre codice/asset non usati.

---

# 17. SICUREZZA E ROBUSTEZZA

## 17.1 Sicurezza implementata
- CSRF.
- validazione server.
- honeypot + spam detection + rate limiting contatti.
- CSP nonce + hardening headers.

## 17.2 Rischi
- admin basic auth semplice.
- submit testimonianze meno protetto rispetto contatti.
- trust proxies wildcard.

## 17.3 Suggerimenti robustezza
1. hardening admin (session auth + rate limit).
2. applicare anti-spam analogo su testimonianze.
3. allineare credenziali admin su config gestita e documentata.

---

# 18. MODIFICHE PRATICHE GUIDATE

## 18.1 Cambiare testi
- Vai nella view della pagina, modifica blocco interessato, verifica responsive.

## 18.2 Cambiare colori globali
- Aggiorna `style.tokens.scss`, verifica nav/card/cta/footer.

## 18.3 Cambiare font
- aggiorna import in `app.scss/admin.scss` e token font family.

## 18.4 Cambiare immagini
- sostituisci in `public/img`, aggiorna riferimenti Blade/config seo.

## 18.5 Modificare card
- struttura in Blade + style in sections/components/responsive.

## 18.6 Aggiungere nuova pagina
1. crea view blade;
2. aggiungi route in `web.php`;
3. metodo controller (se serve);
4. chiave seo in `config/seo.php`;
5. link nav/footer se necessario;
6. test smoke/seo.

## 18.7 Modificare meta SEO
- statiche: `config/seo.php`.
- dinamiche area: `getAreas`.
- globale renderer: `layout` + `SeoLayoutLinkedData`.

## 18.8 Cambiare header/footer
- header: `components/nav*` + `style.navbar.scss`.
- footer: `components/footer.blade.php` + stili sections/responsive.

## 18.9 Sistemare mobile
- primary files:
  - `style.responsive.scss`
  - `style.navbar.scss`
  - `style.sections.scss`.

## 18.10 Cambiare form contatti
- markup: `contatti.blade.php`
- validazione/logica: `PublicController::submit`
- anti-spam/rate: `config/antispam.php` + `AppServiceProvider`.

---

# 19. MAPPA DELLE DIPENDENZE

## 19.1 File dipendono da file

| Nodo | Dipende da |
|---|---|
| `layout.blade.php` | SeoLayoutLinkedData, seoContact, vite manifest |
| `nav.blade.php` | nav-menu, config seo, main.js, navbar.scss |
| `footer.blade.php` | seoContact |
| `contatti.blade.php` | strategic_faqs, antispam config, session, main.js/forms.scss |
| `area-show.blade.php` | area data, faq schema, layout og props, sections/responsive |
| `SeoLayoutLinkedData.php` | config seo, route name, cache |
| `AppServiceProvider.php` | antispam config + SeoContact |

## 19.2 Nodi centrali
- `PublicController`
- `layout.blade.php`
- `config/seo.php`
- `style.sections.scss`
- `style.navbar.scss`

## 19.3 File pericolosi da toccare senza contesto
- `PublicController.php`
- `layout.blade.php`
- `style.responsive.scss`
- `style.navbar.scss`
- `routes/web.php`

---

# 20. ERRORI, DEBITO TECNICO E MIGLIORAMENTI

## 20.1 Cose fatte bene
- base SEO tecnica forte
- test feature utili
- UI responsive curata
- contatti abbastanza robusti lato anti-spam

## 20.2 Fragilità tecniche
1. contenuti area monolitici nel controller.
2. duplicazione fonti slug.
3. CSS molto grande e intrecciato.
4. admin auth minimale.

## 20.3 Refactor consigliati (ordinati)
1. estrazione contenuti aree da controller.
2. source of truth unica per slug aree.
3. hardening admin.
4. armonizzazione protezioni submit testimonianze.
5. modularizzazione SCSS in layer per pagina.

---

# 21. SPIEGAZIONE DIDATTICA FINALE

## 21.1 Come ragiona questo sito
Questo progetto è pensato come **sistema SSR orientato fiducia + conversione**:
- fiducia: profilo, sedi, iscrizione albo, testimonianze, schema person/practice;
- conversione: CTA ripetute, pagina primo colloquio, pagina contatti robusta;
- reperibilità: SEO tecnica integrata in layout/config/support.

## 21.2 File da imparare per primi
1. `routes/web.php`
2. `PublicController.php`
3. `components/layout.blade.php`
4. `config/seo.php`
5. `contatti.blade.php`
6. `style.sections.scss` + `style.navbar.scss` + `style.responsive.scss`.

## 21.3 Ordine di studio consigliato
1. routing e mappa pagine;
2. layout head/meta/schema;
3. funnel contatti;
4. area detail (contenuto + schema + og);
5. design system SCSS;
6. test automatici.

## 21.4 Esercizi guidati
- esercizio A: cambia meta home e verifica output.
- esercizio B: aggiungi FAQ condivisa.
- esercizio C: aggiungi area nuova end-to-end.
- esercizio D: modifica offcanvas e valida landscape mobile.
- esercizio E: aggiungi test feature su nuovo comportamento.

---

# 22. ALLEGATI UTILI

## 22.1 Tabella “file -> funzione”

| File | Funzione |
|---|---|
| `routes/web.php` | routing completo + sitemap/robots + admin |
| `PublicController.php` | logica pubblica e contenuti aree |
| `layout.blade.php` | head/meta/schema/nav/footer/assets |
| `config/seo.php` | contenuti SEO statici + dati persona |
| `SeoLayoutLinkedData.php` | schema globale + og per route |
| `contatti.blade.php` | pagina lead principale |
| `main.js` | comportamento UI client |
| `style.tokens.scss` | design tokens |
| `style.sections.scss` | stile pagine |
| `style.responsive.scss` | responsive overrides |

## 22.2 Tabella “modifica desiderata -> file da toccare”

| Modifica | File |
|---|---|
| Nuova route pagina | `routes/web.php` + view + eventuale controller |
| Meta SEO statica | `config/seo.php` |
| Meta SEO area | `PublicController::getAreas()` |
| OG fallback globale | `SeoLayoutLinkedData::ogImageForRoute` |
| Nuovo blocco Home | `home.blade.php` + `style.sections.scss` |
| Nuovo campo form contatti | `contatti.blade.php` + `PublicController::submit` + migration/model |
| Nuova voce menu | `components/nav-menu.blade.php` |
| Nuovo link footer | `components/footer.blade.php` |
| Cambio stile bottone globale | `style.components.scss` |
| Fix offcanvas | `style.navbar.scss` + `resources/js/main.js` |

## 22.3 Tabella “pagina -> meta SEO”

| Pagina | Source |
|---|---|
| Home | `seo.pages.home` |
| Chi sono | `seo.pages.about` |
| Aree | `seo.pages.areas` |
| Primo colloquio | `seo.pages.firstInterview` |
| Contatti | `seo.pages.contacts` |
| Testimonianze | `seo.pages.testimonials` |
| Privacy | `seo.pages.privacy` |
| Area dettaglio | `getAreas()` + suffix config |

## 22.4 Tabella “componenti -> dove usati”

| Componente | Usato in |
|---|---|
| `<x-layout>` | quasi tutte le view |
| `<x-nav>` | layout |
| `<x-footer>` | layout |
| `components.nav-menu` | nav desktop + offcanvas |
| `partials.strategic-faq-answer` | home + contatti |

## 22.5 Checklist finale operativa
- [ ] Ho capito se la modifica è locale o globale?
- [ ] Ho cercato tutte le dipendenze Blade + SCSS + JS?
- [ ] Ho verificato mobile portrait/landscape?
- [ ] Ho verificato meta/canonical/OG se tocco pagine?
- [ ] Ho verificato form success/error se tocco contatti?
- [ ] Ho considerato effetti PurgeCSS in produzione?
- [ ] Ho aggiornato/aggiunto test dove serve?

---

## Chiusura

Questa è la base completa per governare il progetto con consapevolezza tecnica.  
Per un passaggio successivo (se vuoi), posso produrre anche:
1. versione “runbook manutenzione ordinaria”;
2. versione “runbook emergenze” (SEO down, form down, deploy regressione);
3. checklist QA pre-release pronta da usare ad ogni pubblicazione.

