<!DOCTYPE html>
<html lang="it">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('email_title', 'Messaggio dal sito')</title>
    <style type="text/css">
        @media only screen and (max-width: 620px) {
            .email-shell {
                width: 100% !important;
            }

            .email-inner {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
        }
    </style>
</head>

<body
    style="margin:0;padding:0;background-color:#edf2ee;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color:#edf2ee;border-collapse:collapse;mso-table-lspace:0;mso-table-rspace:0;">
        <tr>
            <td align="center" style="padding:28px 14px;">
                <table role="presentation" class="email-shell" width="560" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:560px;width:100%;border-collapse:collapse;background-color:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #dce5df;box-shadow:0 8px 28px rgba(31,42,36,0.06);">
                    <tr>
                        <td style="background-color:#4f7665;padding:22px 28px;border-bottom:3px solid #b89a5a;">
                            <p
                                style="margin:0 0 6px;font-family:Georgia,'Times New Roman',serif;font-size:11px;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.78);">
                                @yield('email_kicker', 'Dott.ssa Cristina Pacifici')
                            </p>
                            <h1
                                style="margin:0;font-family:Georgia,'Times New Roman',serif;font-size:22px;font-weight:600;line-height:1.25;color:#ffffff;">
                                @yield('email_heading')
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-inner"
                            style="padding:28px 28px 32px;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:1.55;color:#1f2a24;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:18px 28px;background-color:#f4f7f5;border-top:1px solid #e3ebe4;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;font-size:13px;line-height:1.5;color:#5a6b60;">
                            @hasSection('footer')
                                @yield('footer')
                            @else
                                <p style="margin:0;">
                                    Dott.ssa Cristina Pacifici — Psicologa a Tivoli<br>
                                    <span style="color:#7a8a80;">Messaggio generato dal modulo contatti del sito.</span>
                                </p>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
