@component('mail::message')
# You received a quote from {{ $senderOrg }}!

Hi {{ $recipient }}

Thank you for contacting us. {{ $senderOrg }} sent you a quote for the item(s) below:

@foreach ($quote->items as $item)
- {{ $item['name'] }}
@endforeach

Amount (incl. tax): **Rp. {{ number_format($quote->amount) }}** <br>
Quote Number: **{{ substr($quote->quote_date, 0, 4) .'/' .$quote->div .'/' .$quote->sales_person .'/' .substr($quote->quote_date, 5, 2) .'/' .$quote->number }}**

Click the button below for more details about the quote.
@component('mail::button', ['url' => $downloadLink, 'color' => 'primary'])
Download Quote
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
