@component('mail::message')
# Paradisestore.id just sent you a quote!

Click the button below to view the quote.

@component('mail::button', ['url' => $downloadLink])
View Quote
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
