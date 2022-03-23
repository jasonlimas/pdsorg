@component('mail::message')
# You received a quote from {{ $senderOrg }}!

Hi {{ $recipient }}

Thank you for contacting us. {{ $senderOrg }} sent you a quote for the item(s) below:

@foreach ($quote->items as $item)
- {{ $item['name'] }}
@endforeach

Amount (incl. tax): **Rp. {{ number_format($quote->amount) }}**

Click the button below for more details about the quote.
@component('mail::button', ['url' => $downloadLink, 'color' => 'primary'])
View Quote
@endcomponent

@component('mail::panel')
Please do not reply here as we are not monitoring this email.
For any enquiries, please contact:<br>
**{{ $contact['name'] }}**<br>
**{{ $contact['email'] }}**<br>
**{{ $contact['phone'] }}**
@endcomponent

Thanks and best regards,<br>
{{ $senderOrg }}
@endcomponent
