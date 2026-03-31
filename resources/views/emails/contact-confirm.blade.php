<h2>Richiesta ricevuta</h2>

<p>Ciao {{ $contactRequest->name }},</p>

<p>
    Grazie per avermi scritto. Ho ricevuto la tua richiesta e ti ricontatterò il prima possibile.
</p>

<hr>

<p><strong>Riepilogo:</strong></p>
<p><strong>Telefono:</strong> {{ $contactRequest->phone }}</p>
<p><strong>Email:</strong> {{ $contactRequest->email }}</p>

<p style="margin-top:16px;">
    Dott.ssa Cristina Pacifici
</p>
