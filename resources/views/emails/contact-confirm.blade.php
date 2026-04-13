@extends('emails.layout')

@section('email_title', 'Richiesta ricevuta')

@section('email_kicker', 'Conferma invio')

@section('email_heading')
    Richiesta ricevuta correttamente
@endsection

@section('content')
    <p style="margin:0 0 16px;">
        Gentile <strong style="color:#3a584b;">{{ $contactRequest->name }}</strong>,
    </p>

    <p style="margin:0 0 16px;">
        La ringrazio per avermi contattato. Ho ricevuto la sua richiesta e le risponderò appena possibile,
        ai recapiti che ha indicato.
    </p>

    <p style="margin:0 0 22px;padding:14px 16px;background-color:#f5eedf;border-left:4px solid #b89a5a;border-radius:0 8px 8px 0;font-size:15px;line-height:1.55;color:#3d4d43;">
        Nel frattempo, se desidera aggiungere un dettaglio o indicare qualche preferenza di orario,
        può rispondere tranquillamente a questa email.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="margin:0;border-collapse:collapse;background-color:#f4f7f5;border-radius:10px;border:1px solid #e3ebe4;">
        <tr>
            <td style="padding:18px 20px;">
                <p
                    style="margin:0 0 12px;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#4f7665;">
                    Riepilogo recapiti inviati
                </p>
                <p style="margin:0 0 10px;">
                    <strong style="font-size:12px;color:#3a584b;">Telefono</strong><br>
                    <span style="color:#1f2a24;">{{ $contactRequest->phone }}</span>
                </p>
                <p style="margin:0;">
                    <strong style="font-size:12px;color:#3a584b;">Email</strong><br>
                    <span style="color:#1f2a24;">{{ $contactRequest->email }}</span>
                </p>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0;padding-top:20px;border-top:1px solid #e3ebe4;font-family:Georgia,'Times New Roman',serif;font-size:17px;line-height:1.5;color:#1f2a24;">
        Cordiali saluti,<br>
        <strong style="color:#4f7665;">Dott.ssa Cristina Pacifici</strong><br>
        <span style="font-size:15px;color:#5a6b60;">Psicologa</span>
    </p>
@endsection

@section('footer')
    <p style="margin:0;">
        <a href="{{ config('app.url', 'https://psicologacristinapacifici.it') }}"
            style="color:#4f7665;font-weight:600;text-decoration:underline;">Visita di nuovo il sito</a>
        <span style="color:#7a8a80;"> — Tivoli, colloqui in presenza e online.</span>
    </p>
@endsection
