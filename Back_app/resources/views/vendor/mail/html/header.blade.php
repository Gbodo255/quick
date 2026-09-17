@props(['url'])

<tr>
<td class="header">
<a href="{{ $url }}" class="brand-link">
<img src="{{ asset('images/brand/logo-email-header.png') }}" width="205" height="31" alt="{{ config('credit.brand', config('app.name')) }}" class="brand-logo">
</a>
</td>
</tr>
