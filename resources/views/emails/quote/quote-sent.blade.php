@component('mail::message')
# Paradisestore.id just sent you a quote!

Please refer to the attachment for the quote.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
