@props([
    'metaTitle' => 'Dott.ssa Cristina Pacifici | Psicologa a Tivoli',
    'metaDescription' =>
        'Psicologa a Tivoli per supporto su ansia, stress, difficoltà relazionali e genitorialità. Colloqui in presenza e online.',
])

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/og-image.jpg') }}">
    <meta property="og:site_name" content="Dott.ssa Cristina Pacifici">
    <meta property="og:locale" content="it_IT">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ asset('img/og-image.jpg') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <x-nav />

    <main>
        {{ $slot }}
    </main>

    <x-footer />

    <a href="https://wa.me/393441122785" target="_blank" class="whatsapp-float" aria-label="Scrivimi su WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M13.601 2.326A7.854 7.854 0 0 0 8.017 0C3.588 0 .007 3.582.007 8.013c0 1.412.37 2.79 1.073 4.003L0 16l4.087-1.066a7.978 7.978 0 0 0 3.93 1.003h.003c4.428 0 8.01-3.582 8.01-8.013a7.96 7.96 0 0 0-2.429-5.598zM8.02 14.54a6.49 6.49 0 0 1-3.312-.91l-.237-.14-2.426.633.648-2.365-.155-.244a6.486 6.486 0 0 1-.994-3.462c0-3.584 2.915-6.5 6.5-6.5a6.45 6.45 0 0 1 4.59 1.903 6.447 6.447 0 0 1 1.91 4.597c0 3.584-2.915 6.5-6.5 6.5zm3.546-4.864c-.194-.097-1.148-.567-1.326-.632-.178-.065-.308-.097-.438.097-.13.194-.502.632-.615.762-.113.13-.226.146-.42.049-.194-.097-.82-.302-1.563-.963-.578-.515-.969-1.151-1.082-1.345-.113-.194-.012-.298.085-.394.087-.086.194-.226.291-.339.097-.113.13-.194.194-.323.065-.13.032-.243-.016-.34-.049-.097-.438-1.056-.6-1.446-.158-.38-.32-.328-.438-.334l-.373-.007c-.13 0-.34.049-.518.243-.178.194-.68.664-.68 1.617 0 .953.697 1.874.794 2.003.097.13 1.37 2.094 3.322 2.934.465.2.828.32 1.11.41.466.148.89.127 1.225.077.374-.056 1.148-.469 1.31-.922.162-.453.162-.84.113-.922-.049-.081-.178-.13-.373-.226z" />
        </svg>
    </a>

</body>

</html>
