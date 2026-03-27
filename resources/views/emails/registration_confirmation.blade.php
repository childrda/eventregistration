@if($htmlBody)
{!! $htmlBody !!}
@else
<pre style="white-space: pre-wrap; font-family: Arial, sans-serif;">{{ $textBody }}</pre>
@endif

