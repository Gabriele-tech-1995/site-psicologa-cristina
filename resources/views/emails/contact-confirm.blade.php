<h2 style="margin-bottom: 12px;">
    Richiesta ricevuta correttamente
</h2>

<p>
    Gentile {{ $contactRequest->name }},
</p>

<p>
    La ringrazio per avermi contattato.
    Ho ricevuto la sua richiesta e la ricontatterò il prima possibile
    utilizzando i recapiti indicati.
</p>

<p>
    Nel frattempo, se desidera aggiungere ulteriori informazioni
    o comunicare eventuali disponibilità orarie,
    può rispondere direttamente a questa email.
</p>

<hr style="margin: 20px 0;">

<p><strong>Riepilogo dei dati inviati:</strong></p>

<p>
    <strong>Telefono:</strong> {{ $contactRequest->phone }}<br>
    <strong>Email:</strong> {{ $contactRequest->email }}
</p>

<p style="margin-top: 24px;">
    Cordiali saluti,<br>
    <strong>Dott.ssa Cristina Pacifici</strong><br>
    Psicologa
</p>
