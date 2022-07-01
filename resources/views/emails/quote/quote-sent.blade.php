
@component('mail::message')
@component('mail::panel')
This is an official email from {{ $senderOrg }}.
For any enquiries, please use **Reply All** when replying to this email.
@endcomponent
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

Thanks and best regards,<br>
{{ $senderOrg }}
@endcomponent
