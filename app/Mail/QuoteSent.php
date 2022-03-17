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

    public $downloadLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($downloadLink)
    {
        $this->downloadLink = $downloadLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.quote.quote-sent')->subject('You received a quote from ' . Sender::withTrashed()->find(auth()->user()->sender_id)->name);
    }
}
