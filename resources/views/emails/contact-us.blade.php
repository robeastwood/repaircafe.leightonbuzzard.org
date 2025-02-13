<x-mail::message>
# Dear Repair Shop

Just a quick message to let you know that <strong>{{ $content['name'] }} ({{ $content['email'] }})</strong> has sent you a message from the website.

<strong>Message:</strong>
{{ $content['message'] }}
<br>
<br>
Please could you reply to them as soon as possible.
<br>
<br>
Thanks,
<br>
{{ config('app.name') }}
</x-mail::message>
