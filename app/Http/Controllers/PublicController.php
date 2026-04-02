<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestConfirmMail;
use App\Mail\ContactRequestMail;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('chi-sono');
    }

    public function areas()
    {
        $areas = $this->getAreas();

        return view('aree', compact('areas'));
    }

    public function areaShow(string $slug)
    {
        $area = collect($this->getAreas())->firstWhere('slug', $slug);

        abort_if(! $area, 404);

        return view('area-show', compact('area'));
    }

    public function contact()
    {
        return view('contatti');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s]+$/u'],
                'email' => ['required', 'email', 'max:150'],
                'phone' => ['required', 'regex:/^\+?[0-9]+$/', 'min:8', 'max:15'],
                'message' => ['required', 'string', 'min:10', 'max:2000'],
                'privacy' => ['accepted'],
            ],
            [
                'name.required' => 'Inserisci nome e cognome.',
                'name.min' => 'Il nome deve avere almeno :min caratteri.',
                'name.max' => 'Il nome non può superare :max caratteri.',
                'name.regex' => 'Il nome può contenere solo lettere e spazi.',

                'email.required' => 'Inserisci la tua email.',
                'email.email' => 'Inserisci un indirizzo email valido.',
                'email.max' => 'L’email non può superare :max caratteri.',

                'phone.required' => 'Inserisci un numero di telefono.',
                'phone.min' => 'Il numero di telefono deve avere almeno :min caratteri.',
                'phone.max' => 'Il numero di telefono non può superare :max caratteri.',
                'phone.regex' => 'Il numero di telefono può contenere solo cifre (e facoltativamente + iniziale).',

                'message.required' => 'Scrivi un breve messaggio.',
                'message.min' => 'Il messaggio deve avere almeno :min caratteri.',
                'message.max' => 'Il messaggio non può superare :max caratteri.',

                'privacy.accepted' => 'Per inviare la richiesta è necessario accettare il consenso al trattamento dei dati.',
            ]
        );

        $contact = ContactRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'consent_privacy' => true,
        ]);

        Mail::to(config('mail.contact.address'), config('mail.contact.name'))
            ->send(new ContactRequestMail($contact));

        Mail::to($contact->email, $contact->name)
            ->send(new ContactRequestConfirmMail($contact));

        return redirect()
            ->route('contacts')
            ->with('success', 'Richiesta inviata correttamente. Ti ricontatterò il prima possibile.');
    }

    private function getAreas(): array
    {
        return [
            [
                'slug' => 'ansia-e-gestione-dello-stress',
                'title' => 'Ansia e gestione dello stress',
                'preview' => 'Supporto nella comprensione e gestione di stati ansiosi, tensioni e periodi di cambiamento.',
                'image' => '/img/stress.jpg',
                'intro' => 'L’ansia può manifestarsi in modi diversi e con intensità differenti, influenzando il benessere quotidiano, le relazioni e la capacità di affrontare impegni, responsabilità o momenti di cambiamento.',
                'manifestazioni' => [
                    'pensieri ricorrenti e preoccupazioni difficili da interrompere',
                    'agitazione, tensione fisica o difficoltà a rilassarsi',
                    'senso di sovraccarico emotivo e mentale',
                    'difficoltà di concentrazione, irritabilità o affaticamento',
                ],
                'supporto' => 'Un supporto psicologico può essere utile quando l’ansia o lo stress diventano persistenti, interferiscono con la vita quotidiana o rendono più difficile affrontare studio, lavoro, relazioni e scelte personali.',
                'come_lavoro' => 'Il percorso si costruisce a partire dalla comprensione del vissuto della persona, delle situazioni che generano maggiore fatica e delle risorse già presenti. Il lavoro è orientato a sviluppare una maggiore consapevolezza emotiva, a riconoscere i segnali interni e a costruire modalità più efficaci e sostenibili di gestione.',
                'chiusura' => 'Ogni intervento viene definito insieme, nel rispetto della storia, dei tempi e dei bisogni della persona.',
            ],
            [
                'slug' => 'umore-basso',
                'title' => 'Umore basso',
                'preview' => 'Sostegno nei momenti di tristezza, demotivazione o perdita di energia emotiva.',
                'image' => '/img/umoreBasso.jpg',
                'intro' => 'I momenti di umore basso possono influenzare la percezione di sé, la motivazione, le relazioni e la capacità di affrontare la quotidianità con serenità.',
                'manifestazioni' => [
                    'senso di tristezza o vuoto persistente',
                    'stanchezza emotiva e perdita di energia',
                    'difficoltà a trovare motivazione nelle attività quotidiane',
                    'sensazione di sentirsi bloccati o distanti da sé stessi',
                ],
                'supporto' => 'Un supporto psicologico può aiutare a dare significato a ciò che si sta vivendo, a comprendere i bisogni emotivi coinvolti e a ritrovare gradualmente equilibrio e direzione.',
                'come_lavoro' => 'Il lavoro si sviluppa in uno spazio di ascolto autentico, in cui la persona può sentirsi accolta e accompagnata nel riconoscere vissuti, fragilità e risorse. L’obiettivo è favorire una maggiore consapevolezza di sé e costruire modalità più sostenibili di stare in relazione con il proprio mondo interno.',
                'chiusura' => 'Il percorso viene costruito in modo condiviso, con attenzione ai tempi della persona e al suo modo unico di vivere il disagio.',
            ],
            [
                'slug' => 'difficolta-relazionali',
                'title' => 'Difficoltà relazionali',
                'preview' => 'Percorsi per migliorare comunicazione e qualità delle relazioni familiari, scolastiche o lavorative.',
                'image' => '/img/relazionali.jpg',
                'intro' => 'Le difficoltà relazionali possono emergere in diversi contesti della vita: nella coppia, in famiglia, con i figli, a scuola, nel lavoro o nelle amicizie.',
                'manifestazioni' => [
                    'incomprensioni frequenti o conflitti ripetuti',
                    'fatica nell’esprimere bisogni, emozioni o limiti',
                    'sensazione di non sentirsi compresi o riconosciuti',
                    'difficoltà nel creare o mantenere relazioni soddisfacenti',
                ],
                'supporto' => 'Un supporto psicologico può essere utile per comprendere meglio le dinamiche che generano sofferenza, migliorare la comunicazione e sviluppare modalità relazionali più consapevoli e autentiche.',
                'come_lavoro' => 'Il percorso aiuta a leggere con maggiore chiarezza il proprio modo di stare nelle relazioni, a riconoscere schemi ricorrenti e a costruire strumenti più efficaci per comunicare, ascoltare e posizionarsi nelle relazioni in modo più stabile e rispettoso di sé.',
                'chiusura' => 'L’intervento viene definito sulla base della storia e dei bisogni della persona, con attenzione alla qualità delle relazioni presenti nella sua vita.',
            ],
            [
                'slug' => 'autostima',
                'title' => 'Autostima',
                'preview' => 'Percorsi per rafforzare fiducia in sé e consapevolezza delle proprie risorse.',
                'image' => '/img/autostima.jpg',
                'intro' => 'L’autostima riguarda il modo in cui una persona percepisce sé stessa, il proprio valore e le proprie capacità nelle diverse aree della vita.',
                'manifestazioni' => [
                    'tendenza a svalutarsi o a sentirsi “mai abbastanza”',
                    'insicurezza nelle relazioni o nelle scelte',
                    'difficoltà a riconoscere i propri punti di forza',
                    'timore del giudizio e forte autocritica',
                ],
                'supporto' => 'Un percorso psicologico può aiutare a comprendere come si è costruita l’immagine di sé nel tempo e a sviluppare una percezione più equilibrata, solida e rispettosa del proprio valore.',
                'come_lavoro' => 'Il lavoro si orienta al riconoscimento delle risorse personali, alla comprensione dei meccanismi di autosvalutazione e alla costruzione di un rapporto più autentico e stabile con sé stessi.',
                'chiusura' => 'Ogni percorso viene definito tenendo conto delle caratteristiche della persona e dei contesti in cui questa fatica emerge maggiormente.',
            ],
            [
                'slug' => 'difficolta-scolastiche',
                'title' => 'Difficoltà scolastiche',
                'preview' => 'Supporto a bambini e adolescenti per studio, motivazione e gestione delle difficoltà.',
                'image' => '/img/scuola.jpg',
                'intro' => 'Le difficoltà scolastiche possono riguardare l’apprendimento, la concentrazione, l’organizzazione, il metodo di studio oppure il vissuto emotivo legato all’esperienza scolastica.',
                'manifestazioni' => [
                    'fatica nello studio e nella gestione dei compiti',
                    'demotivazione o senso di inadeguatezza a scuola',
                    'difficoltà di concentrazione e organizzazione',
                    'vissuti di ansia o frustrazione legati al contesto scolastico',
                ],
                'supporto' => 'Un supporto può essere utile per comprendere i fattori che influenzano il rendimento e il benessere scolastico, valorizzando le risorse del bambino o dell’adolescente e costruendo strategie adeguate.',
                'come_lavoro' => 'L’intervento viene costruito in base alle caratteristiche del minore, tenendo conto degli aspetti cognitivi, emotivi e relazionali coinvolti. Quando necessario, il lavoro può integrare sostegno psicologico, potenziamento e confronto con la famiglia.',
                'chiusura' => 'L’obiettivo è favorire un’esperienza scolastica più serena, sostenibile e coerente con i bisogni della persona.',
            ],
            [
                'slug' => 'disturbi-del-neurosviluppo',
                'title' => 'Disturbi del neurosviluppo',
                'preview' => 'Interventi dedicati con attenzione ai bisogni della persona e della famiglia.',
                'image' => '/img/neuro.jpg',
                'intro' => 'I disturbi del neurosviluppo richiedono un’attenzione specifica alle caratteristiche cognitive, emotive, comportamentali e relazionali della persona, oltre che al contesto familiare e scolastico in cui cresce.',
                'manifestazioni' => [
                    'difficoltà di apprendimento o regolazione emotiva',
                    'fatiche attentive, organizzative o comportamentali',
                    'bisogno di una lettura più chiara del funzionamento del minore',
                    'necessità di un supporto condiviso con la famiglia',
                ],
                'supporto' => 'Il supporto psicologico può aiutare a comprendere il funzionamento della persona in modo più chiaro, individuare i bisogni specifici e costruire interventi mirati, sostenibili e rispettosi della sua unicità.',
                'come_lavoro' => 'Il percorso integra l’attenzione agli aspetti cognitivi con una lettura emotiva e relazionale del vissuto del minore. Il lavoro può comprendere valutazione, sostegno, potenziamento e confronto con i genitori, in un’ottica di collaborazione e chiarezza.',
                'chiusura' => 'Ogni intervento viene costruito in modo personalizzato, con l’obiettivo di favorire il benessere della persona e del suo contesto di vita.',
            ],
            [
                'slug' => 'genitorialita',
                'title' => 'Genitorialità',
                'preview' => 'Sostegno ai genitori nelle diverse fasi evolutive dei figli e nelle dinamiche familiari.',
                'image' => '/img/genitori.jpg',
                'intro' => 'La genitorialità può portare con sé domande, dubbi, fatiche e momenti di disorientamento, soprattutto quando i figli attraversano fasi delicate di crescita o presentano difficoltà specifiche.',
                'manifestazioni' => [
                    'fatica nella gestione quotidiana delle dinamiche familiari',
                    'dubbi educativi o difficoltà nel comprendere i bisogni dei figli',
                    'senso di stanchezza, frustrazione o incertezza nel ruolo genitoriale',
                    'necessità di uno spazio di confronto e orientamento',
                ],
                'supporto' => 'Un percorso di sostegno alla genitorialità offre ai genitori uno spazio protetto in cui riflettere sulle difficoltà presenti, comprendere meglio il funzionamento del figlio e costruire modalità educative più consapevoli e sostenibili.',
                'come_lavoro' => 'Il lavoro si sviluppa attraverso ascolto, confronto e valorizzazione delle risorse genitoriali già presenti. L’obiettivo non è offrire soluzioni standard, ma accompagnare la famiglia nella ricerca di un equilibrio più adatto alla propria storia e ai propri bisogni.',
                'chiusura' => 'Il sostegno viene costruito in modo condiviso, nel rispetto della specificità di ogni famiglia e della fase evolutiva che sta attraversando.',
            ],
            [
                'slug' => 'valutazioni-psicodiagnostiche',
                'title' => 'Valutazioni psicodiagnostiche',
                'preview' => 'Percorso di approfondimento per comprendere il funzionamento cognitivo, emotivo e degli apprendimenti della persona.',
                'image' => '/img/valutazione.jpg',
                'intro' => 'Le valutazioni psicodiagnostiche rappresentano un percorso fondamentale per comprendere in modo approfondito il funzionamento cognitivo, emotivo e degli apprendimenti della persona.',
                'manifestazioni' => [
                    'bisogno di chiarire eventuali difficoltà di apprendimento o attenzione',
                    'necessità di comprendere meglio il profilo cognitivo ed emotivo della persona',
                    'richiesta di un inquadramento più preciso rispetto a fatiche scolastiche o quotidiane',
                    'esigenza di orientare in modo più mirato il percorso di supporto o intervento',
                ],
                'supporto' => 'Attraverso l’utilizzo di strumenti standardizzati e colloqui clinici, è possibile individuare eventuali difficoltà, come Disturbi Specifici dell’Apprendimento, difficoltà attentive o aspetti emotivi che incidono sul benessere e sul funzionamento quotidiano.',
                'come_lavoro' => 'La valutazione viene svolta con attenzione e gradualità, integrando osservazione clinica, colloqui e strumenti specifici per delineare un profilo chiaro e completo della persona. L’obiettivo è restituire una comprensione utile, concreta e condivisa, che possa orientare eventuali interventi successivi.',
                'chiusura' => 'Il percorso di valutazione fornisce indicazioni utili sia in ambito scolastico sia nella vita quotidiana, sostenendo la persona e la famiglia nella scelta del percorso più adeguato.',

            ],
            [
                'slug' => 'potenziamento-funzioni-esecutive',
                'title' => 'Potenziamento delle funzioni esecutive',
                'preview' => 'Intervento mirato al rafforzamento dei processi cognitivi che regolano comportamento, organizzazione e autoregolazione.',
                'image' => '/img/funzioni.jpg',
                'intro' => 'Il potenziamento delle funzioni esecutive è un intervento mirato al rafforzamento dei processi cognitivi che regolano il comportamento e l’organizzazione delle attività quotidiane.',
                'manifestazioni' => [
                    'difficoltà di attenzione e concentrazione',
                    'fatica nella pianificazione e nell’organizzazione dei compiti',
                    'difficoltà nella memoria di lavoro',
                    'impulsività o scarsa capacità di autoregolazione',
                ],
                'supporto' => 'L’intervento può essere utile quando emergono difficoltà nella gestione delle richieste quotidiane, scolastiche o relazionali, soprattutto nei casi in cui la persona fatica a organizzarsi, mantenere l’attenzione o adattarsi in modo flessibile alle situazioni.',
                'come_lavoro' => 'Si lavora su attenzione, memoria di lavoro, pianificazione, flessibilità cognitiva e controllo dell’impulsività, con l’obiettivo di migliorare la capacità di autoregolazione, la gestione dei compiti e l’adattamento alle richieste quotidiane. Il percorso viene definito in modo personalizzato sulla base delle caratteristiche e dei bisogni della persona.',
                'chiusura' => 'L’obiettivo è favorire un funzionamento più efficace e stabile nella vita quotidiana, scolastica e relazionale.',

            ],
            [
                'slug' => 'potenziamento-abilita-scolastiche',
                'title' => 'Potenziamento delle abilità scolastiche',
                'preview' => 'Percorso finalizzato al miglioramento dei processi implicati negli apprendimenti scolastici, come lettura, scrittura e calcolo.',
                'image' => '/img/scolastiche.jpg',
                'intro' => 'Il potenziamento delle abilità scolastiche è un percorso finalizzato al miglioramento dei processi coinvolti negli apprendimenti, con particolare attenzione a lettura, scrittura e calcolo.',
                'manifestazioni' => [
                    'difficoltà nella lettura, scrittura o calcolo',
                    'lentezza o scarsa accuratezza nelle attività scolastiche',
                    'fatica nel gestire i compiti in autonomia',
                    'bisogno di strategie più efficaci nello studio',
                ],
                'supporto' => 'Questo intervento può essere utile quando il bambino o l’adolescente incontra difficoltà nel rendimento scolastico o fatica a sviluppare modalità funzionali e stabili nell’affrontare le richieste della scuola.',
                'come_lavoro' => 'L’intervento si concentra sull’efficienza e sull’accuratezza delle prestazioni, supportando lo sviluppo di strategie più funzionali nell’affrontare le richieste scolastiche. Il lavoro viene adattato in base al profilo della persona, con attenzione sia agli aspetti cognitivi sia alla fiducia nelle proprie capacità.',
                'chiusura' => 'L’obiettivo è favorire apprendimenti più solidi, una maggiore autonomia e un rapporto più sereno con l’esperienza scolastica.',
            ],
            [
                'slug' => 'intervento-di-gruppo-Area-emotiva-relazionale',
                'title' => 'Intervento in gruppo – Area emotiva e relazionale',
                'preview' => 'Percorsi di gruppo per sviluppare competenze sociali, sicurezza personale e capacità di relazione con i pari.',
                'image' => '/img/gruppo.jpg',
                'intro' => 'Il lavoro di gruppo rappresenta uno spazio protetto in cui bambini e ragazzi possono sperimentarsi nella relazione con i pari, sviluppando maggiore consapevolezza di sé e degli altri.',
                'manifestazioni' => [
                    'difficoltà nelle relazioni con i coetanei',
                    'insicurezza nelle situazioni sociali o di gruppo',
                    'fatica nel gestire emozioni e conflitti interpersonali',
                    'bisogno di rafforzare autostima e competenze sociali',
                ],
                'supporto' => 'Il gruppo offre un contesto strutturato e guidato in cui è possibile sperimentare nuove modalità relazionali, sentirsi accolti e confrontarsi con esperienze simili. L’intervento può essere utile quando emergono difficoltà nelle dinamiche sociali o nel rapporto con sé stessi e con gli altri.',
                'come_lavoro' => 'Attraverso attività esperienziali e guidate, si interviene su autostima, senso di autoefficacia, competenze sociali e abilità relazionali. Il gruppo diventa un contesto attivo di apprendimento, in cui è possibile allenare nuove modalità di espressione, comunicazione e regolazione emotiva.',
                'chiusura' => 'Il percorso favorisce una maggiore sicurezza personale e una migliore gestione delle dinamiche interpersonali, con ricadute concrete nella vita quotidiana e scolastica.',
            ],
            [
                'slug' => 'tutor-dsa-bes-adhd',
                'title' => 'Tutor DSA, BES e ADHD',
                'preview' => 'Supporto allo studio per bambini e ragazzi con DSA, BES e difficoltà attentive e di autoregolazione.',
                'image' => '/img/dsa.jpg',
                'intro' => 'Il servizio è rivolto a bambini e ragazzi con Disturbi Specifici dell’Apprendimento, Bisogni Educativi Speciali e difficoltà attentive e di autoregolazione.',
                'manifestazioni' => [
                    'fatica nello studio e nell’organizzazione dei compiti',
                    'difficoltà nell’uso di un metodo di studio efficace',
                    'bisogno di strategie personalizzate e strumenti compensativi',
                    'fatiche attentive, esecutive e di autoregolazione',
                ],
                'supporto' => 'L’intervento può essere utile quando il bambino o il ragazzo incontra difficoltà nel gestire in autonomia lo studio, nel pianificare il lavoro scolastico o nel mantenere attenzione e continuità nelle attività richieste.',
                'come_lavoro' => 'Il percorso è orientato allo sviluppo di un metodo di studio efficace e personalizzato, all’acquisizione di strategie funzionali e all’utilizzo consapevole degli strumenti compensativi. Particolare attenzione viene dedicata agli aspetti esecutivi e attentivi, come organizzazione, gestione del tempo e pianificazione, con l’obiettivo di aumentare l’autonomia, ridurre la fatica nello studio e migliorare l’efficacia nelle attività scolastiche.',
                'chiusura' => 'Il lavoro si svolge in collaborazione con la famiglia e, quando necessario, con la scuola, per favorire coerenza e continuità negli interventi.',
            ],
        ];
    }
}
