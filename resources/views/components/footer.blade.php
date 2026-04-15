<footer class="footer-minimal border-top">
    <div class="container footer-minimal__container py-5">
        <h2 class="visually-hidden">Piè di pagina</h2>
        <div class="row gy-4">

            <div class="col-md-4">
                <h3 class="footer-title">Dott.ssa Cristina Pacifici – Psicologa</h3>
                <p class="small mb-1">
                    Specializzanda in psicoterapia
                    umanistico-esperienziale @if ($seoContact['aspic_url'] !== '')
                        — <a href="{{ $seoContact['aspic_url'] }}" target="_blank" rel="noopener noreferrer">ASPIC</a>
                    @else
                        — ASPIC
                    @endif
                </p>
                <p class="small mb-0">
                    @if ($seoContact['albo_registration_url'] !== '')
                        <a href="{{ $seoContact['albo_registration_url'] }}" target="_blank" rel="noopener noreferrer">Iscrizione Albo Psicologi del Lazio n. 32019</a>
                    @else
                        Iscrizione Albo Psicologi del Lazio n. 32019
                    @endif
                </p>
            </div>

            <div class="col-md-4">
                <h3 class="footer-title">Ricevo</h3>
                <p class="small mb-1">Online e in presenza su appuntamento</p>
                <p class="small mb-1">Ricevo personalmente presso Centro Imago e Centro Empathia (Tivoli), Centro Liberamente (Villanova)</p>
                <p class="small mb-1">Dal lunedì al venerdì</p>
                <p class="small mb-0">Durata seduta: 50 minuti</p>
            </div>

            <div class="col-md-4">
                <h3 class="mb-0">
                    <a href="{{ route('contacts') }}" class="footer-title-link">
                        <span class="footer-title">Contatti</span>
                    </a>
                </h3>
                <p class="small mb-1">
                    <a href="{{ $seoContact['mailto'] }}">
                        {{ $seoContact['email'] }}
                    </a>
                </p>
                <p class="small mb-1">
                    <a href="{{ $seoContact['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer">
                        {{ $seoContact['telephone_display_spaced'] }}
                    </a>
                </p>
                <div class="d-flex flex-column mt-2">
                    <a class="area-link" href="{{ route('contacts') }}#richiesta-colloquio">Richiedi il primo colloquio →</a>
                    <a class="area-link" href="{{ $seoContact['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer">Scrivimi su WhatsApp →</a>
                </div>
                <p class="small mb-0">
                    Cancellazione entro 24 ore
                </p>
            </div>

        </div>

        <div class="footer-bottom text-center mt-4 pt-3">
            © {{ date('Y') }} Dott.ssa Cristina Pacifici · Tutti i diritti riservati
            <span class="mx-2">·</span>
            <a href="{{ route('privacy') }}">Privacy Policy</a>
        </div>
    </div>
</footer>
