@php
    $brand = config('credit.brand', config('app.name'));
@endphp

<x-mail::layout>
{{-- Header --}}
@isset($header)
<x-slot:header>
{!! $header !!}
</x-slot:header>
@else
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ $brand }}
</x-mail::header>
</x-slot:header>
@endisset

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
@isset($footer)
<x-slot:footer>
{!! $footer !!}
</x-slot:footer>
@else
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ $brand }}.<br>
Votre demande est traitée avec confidentialité.
</x-mail::footer>
</x-slot:footer>
@endisset
</x-mail::layout>
