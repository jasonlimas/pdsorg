<?php

namespace App\Mail;

use App\Models\Sender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class QuoteSent extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient;
    public $quote;
    public $senderOrg;
    public $downloadLink;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $quote, $downloadLink, $contact)
    {
        $this->recipient = $recipient;
        $this->quote = $quote;
        $this->downloadLink = $downloadLink;
        $this->contact = $contact;
        $this->senderOrg = Sender::withTrashed()->find($contact['sender_id'])->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.quote.quote-sent')
            ->from(config('mail.from.address'), $this->senderOrg)
            ->subject('You received a quote from ' . $this->senderOrg);
    }
}
