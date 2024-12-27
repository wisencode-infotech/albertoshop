@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if(__setting('email_header_logo'))
<img src="{{ asset(__setting('email_header_logo')) }}" class="logo app-logo-as-img" alt="{{ config('app.name') }}">
@elseif (trim($slot) === 'Laravel')
<img src="{{ asset(__setting('header_logo')) }}" class="logo app-logo-as-img" alt="{{ config('app.name') }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
