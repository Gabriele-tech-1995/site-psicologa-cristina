<h2 style="margin-bottom: 16px;">
    Nuova richiesta dal sito
</h2>

<p>
    È stata inviata una nuova richiesta dal modulo contatti del sito.
</p>

<hr style="margin: 20px 0;">

<p><strong>Nome:</strong> {{ $contactRequest->name }}</p>
<p><strong>Email:</strong> {{ $contactRequest->email }}</p>
<p><strong>Telefono:</strong> {{ $contactRequest->phone }}</p>

<hr style="margin: 20px 0;">

<p><strong>Messaggio:</strong></p>
<p style="white-space: pre-line;">{{ $contactRequest->message }}</p>

<hr style="margin: 20px 0;">

<p style="font-size: 12px; color: #777;">
    Messaggio inviato dal sito web della Dott.ssa Cristina Pacifici.
</p>
