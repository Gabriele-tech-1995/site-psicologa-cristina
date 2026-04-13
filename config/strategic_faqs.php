<?php

/**
 * FAQ strategiche condivise tra home (solo HTML) e contatti (+ JSON-LD FAQPage).
 * - `answer`: testo piano per JSON-LD (nessun HTML).
 * - `answer_html` (opzionale): versione per accordion con placeholder __AREAS__, __CONTATTI__.
 *
 * @var list<array{question: string, answer: string, answer_html?: string}>
 */
return [
    [
        'question' => 'Come si svolge il primo colloquio?',
        'answer' => 'Il primo colloquio dura circa 50 minuti ed è pensato per darle tempo di essere ascoltata e di dire cosa la porta qui. Insieme si possono chiarire esigenze, obiettivi e modalità del percorso, senza fretta. Non è un impegno sulla durata di un eventuale percorso: è un incontro per vedere se può esserle utile proseguire.',
    ],
    [
        'question' => 'Riceve anche online?',
        'answer' => 'Sì. Oltre agli appuntamenti in presenza a Tivoli e in zona, può scegliere anche la modalità online quando è per lei più comoda. Insieme si trova il modo più adatto nel colloquio conoscitivo, in base a distanza, tempi e preferenze.',
    ],
    [
        'question' => 'A chi si rivolge?',
        'answer' => 'La Dott.ssa Pacifici offre supporto psicologico a bambini, adolescenti, adulti e genitori, con particolare esperienza su ansia e stress, umore basso, difficoltà relazionali, autostima, ambito scolastico, disturbi del neurosviluppo e genitorialità. L’elenco delle aree di intervento, con brevi schede descrittive, è nella sezione dedicata del sito.',
        'answer_html' => 'La Dott.ssa Pacifici offre supporto psicologico a bambini, adolescenti, adulti e genitori, con particolare esperienza su ansia e stress, umore basso, difficoltà relazionali, autostima, ambito scolastico, disturbi del neurosviluppo e genitorialità. Se le è utile orientarsi, nella sezione <a href="__AREAS__">Aree di intervento</a> trova l’elenco completo e qualche dettaglio in più su ciascun percorso.',
    ],
    [
        'question' => 'In quali aree offre supporto?',
        'answer' => 'Le principali aree includono ansia e gestione dello stress, umore basso, difficoltà relazionali, autostima, difficoltà scolastiche, disturbi del neurosviluppo, sostegno alla genitorialità, valutazioni psicodiagnostiche, potenziamento delle funzioni esecutive e delle abilità scolastiche, percorsi di gruppo e tutoraggio DSA/BES/ADHD. L’elenco aggiornato e le schede descrittive sono nella sezione Aree di intervento del sito.',
        'answer_html' => 'Le principali aree includono ansia e gestione dello stress, umore basso, difficoltà relazionali, autostima, difficoltà scolastiche, disturbi del neurosviluppo, sostegno alla genitorialità, valutazioni psicodiagnostiche, potenziamento delle funzioni esecutive e delle abilità scolastiche, percorsi di gruppo e tutoraggio DSA/BES/ADHD. L’elenco aggiornato, con le schede descrittive, è nella sezione <a href="__AREAS__">Aree di intervento</a>: può leggerla con calma, quando le è comodo.',
    ],
    [
        'question' => 'Come può richiedere un primo contatto?',
        'answer' => 'Può utilizzare la pagina Contatti del sito: modulo, indirizzo email e WhatsApp (stesso numero di telefono). Di solito riceve una risposta entro 24 ore lavorative (lunedì–venerdì); nei periodi di maggiore richiesta i tempi possono allungarsi leggermente.',
        'answer_html' => 'Il modo più semplice è passare dalla <a href="__CONTATTI__">pagina Contatti</a>: lì può lasciare un messaggio con il modulo, scrivere una mail o scrivermi su WhatsApp (è lo stesso numero che trova sul sito). Di solito rispondo entro 24 ore lavorative, dal lunedì al venerdì; nei periodi di maggiore richiesta può capitare che serva qualche giorno in più.',
    ],
];
