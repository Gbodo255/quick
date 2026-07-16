@php
    $plain = function ($value) {
        $text = strip_tags(html_entity_decode((string) $value, ENT_QUOTES, 'UTF-8'));
        $text = preg_replace('/^\s{0,3}#{1,6}\s+/m', '', $text);
        $text = preg_replace('/(\*\*|__)(.*?)\1/s', '$2', $text);
        $text = preg_replace("/[ \t]+\n/", "\n", $text);

        return trim($text);
    };
@endphp

{!! $plain($header ?? '') !!}

{!! $plain($slot) !!}
@isset($subcopy)

{!! $plain($subcopy) !!}
@endisset

{!! $plain($footer ?? '') !!}
