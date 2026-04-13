@php
    $html = $faq['answer_html'] ?? null;
    if ($html !== null) {
        $html = str_replace(
            ['__AREAS__', '__CONTATTI__'],
            [e(route('areas')), e(route('contacts'))],
            $html
        );
    }
@endphp
@if ($html !== null)
    <div class="accordion-body">{!! $html !!}</div>
@else
    <div class="accordion-body">{{ $faq['answer'] }}</div>
@endif
