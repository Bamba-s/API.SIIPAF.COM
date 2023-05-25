@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="public/images/logo.png" class="logo" alt="siipaf Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
