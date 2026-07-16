@props(['url'])
@php
    $brand = trim((string) $slot) ?: config('credit.brand', config('app.name'));
    $brandPrefix = $brand === 'Quickcredit' ? 'Quick' : $brand;
    $brandAccent = $brand === 'Quickcredit' ? 'credit' : '';
    $initial = strtoupper(substr($brand, 0, 1));
@endphp

<tr>
<td class="header">
<a href="{{ $url }}" class="brand-link">
<span class="brand-symbol">{{ $initial }}</span>
<span class="brand-name">{{ $brandPrefix }}@if($brandAccent)<span class="brand-accent">{{ $brandAccent }}</span>@endif</span>
</a>
<div class="brand-tagline">Demande de crédit en ligne</div>
</td>
</tr>
