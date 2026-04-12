@extends('emails.layout')

@section('email_title', 'Nuova richiesta dal sito')

@section('email_kicker', 'Modulo contatti')

@section('email_heading')
    Nuova richiesta di contatto
@endsection

@section('content')
    <p style="margin:0 0 20px;">
        È stata inviata una nuova richiesta dal modulo contatti del sito web.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="margin:0 0 20px;border-collapse:collapse;background-color:#f4f7f5;border-radius:10px;border:1px solid #e3ebe4;">
        <tr>
            <td style="padding:18px 20px;">
                <p
                    style="margin:0 0 14px;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#4f7665;">
                    Recapiti
                </p>
                <p style="margin:0 0 12px;padding-bottom:12px;border-bottom:1px solid #dce5df;">
                    <strong style="display:block;font-size:12px;color:#3a584b;margin-bottom:4px;">Nome</strong>
                    <span style="color:#1f2a24;">{{ $contactRequest->name }}</span>
                </p>
                <p style="margin:0 0 12px;padding-bottom:12px;border-bottom:1px solid #dce5df;">
                    <strong style="display:block;font-size:12px;color:#3a584b;margin-bottom:4px;">Email</strong>
                    <a href="mailto:{{ $contactRequest->email }}"
                        style="color:#2a5540;text-decoration:underline;">{{ $contactRequest->email }}</a>
                </p>
                <p style="margin:0;">
                    <strong style="display:block;font-size:12px;color:#3a584b;margin-bottom:4px;">Telefono</strong>
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $contactRequest->phone) }}"
                        style="color:#1f2a24;text-decoration:none;">{{ $contactRequest->phone }}</a>
                </p>
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="margin:0;border-collapse:collapse;background-color:#ffffff;border-radius:10px;border:1px solid #e3ebe4;">
        <tr>
            <td style="padding:18px 20px;">
                <p
                    style="margin:0 0 10px;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#4f7665;">
                    Messaggio
                </p>
                <p style="margin:0;white-space:pre-line;color:#1f2a24;font-size:15px;line-height:1.6;">
                    {{ $contactRequest->message }}</p>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    <p style="margin:0;">
        <strong style="color:#3a584b;">Dott.ssa Cristina Pacifici</strong> — notifica automatica dal sito.<br>
        <span style="color:#7a8a80;">Rispondendo a questa email scrivi direttamente a {{ $contactRequest->name }}
            (indirizzo impostato come destinatario delle risposte).</span>
    </p>
@endsection
