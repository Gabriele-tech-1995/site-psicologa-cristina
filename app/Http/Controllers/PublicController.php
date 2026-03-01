<?php

namespace App\Http\Controllers;

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
        $areas = [
            [
                'title' => 'Ansia e gestione dello stress',
                'description' => 'Supporto nella comprensione e gestione di stati ansiosi, tensioni e periodi di cambiamento.',
            ],
            [
                'title' => 'Umore basso',
                'description' => 'Sostegno nei momenti di tristezza, demotivazione o perdita di energia emotiva.',
            ],
            [
                'title' => 'Difficoltà relazionali',
                'description' => 'Percorsi per migliorare comunicazione e qualità delle relazioni familiari, scolastiche o lavorative.',
            ],
            [
                'title' => 'Autostima',
                'description' => 'Percorsi per rafforzare fiducia in sé e consapevolezza delle proprie risorse.',
            ],
            [
                'title' => 'Difficoltà scolastiche',
                'description' => 'Supporto a bambini e adolescenti per studio, motivazione e gestione delle difficoltà.',
            ],
            [
                'title' => 'Disturbi del neurosviluppo',
                'description' => 'Interventi dedicati con attenzione ai bisogni della persona e della famiglia.',
            ],
            [
                'title' => 'Genitorialità',
                'description' => 'Sostegno ai genitori nelle diverse fasi evolutive dei figli e nelle dinamiche familiari.',
            ],
        ];

        return view('aree', compact('areas'));
    }

    public function services()
    {
        $services = [
            [
                'title' => 'Sostegno individuale',
                'description' => 'Percorsi personalizzati rivolti ad adolescenti e adulti.',
            ],
            [
                'title' => 'Sostegno di gruppo',
                'description' => 'Spazi condivisi per confrontarsi e crescere insieme.',
            ],
            [
                'title' => 'Supporto per stress e ansia',
                'description' => 'Percorsi orientati alla gestione dello stress e di stati ansiosi.',
            ],
            [
                'title' => 'Sviluppo dell’autostima',
                'description' => 'Supporto per rafforzare la fiducia in sé e valorizzare le proprie risorse.',
            ],
            [
                'title' => 'Autonomia personale',
                'description' => 'Percorsi per favorire crescita e indipendenza.',
            ],
            [
                'title' => 'Supporto nelle difficoltà lavorative',
                'description' => 'Accompagnamento nella gestione di stress e cambiamenti professionali.',
            ],
            [
                'title' => 'Sostegno alla genitorialità',
                'description' => 'Supporto ai genitori nella gestione delle dinamiche familiari.',
            ],
            [
                'title' => 'Valutazioni psicodiagnostiche',
                'description' => 'Valutazioni specifiche per approfondire bisogni e difficoltà.',
            ],
            [
                'title' => 'Potenziamenti cognitivi',
                'description' => 'Interventi mirati a rafforzare abilità cognitive e scolastiche.',
            ],
        ];

        return view('servizi', compact('services'));
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

        // 1) Salvo sul DB
        $contact = ContactRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'consent_privacy' => true,
        ]);

        // 2) Invio email (in dev con MAIL_MAILER=log finisce nei log)
        Mail::to('Dott.ssapacifici24@gmail.com')->send(new ContactRequestMail($contact));

        return redirect()
            ->route('contacts')
            ->with('success', 'Richiesta inviata correttamente. Ti ricontatterò il prima possibile.');
    }
}
