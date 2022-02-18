<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sender;
use Livewire\Component;

class QuoteSenderReceiver extends Component
{
    public $senderId = '';
    public $senderName = '';
    public $senderAddress = '';
    public $clients = [];
    public $selectedClient = '';
    public $clientAddress = '';

    public function mount()
    {
        // Get senders and clients from the database
        $this->senderId = Sender::find(auth()->user()->sender_id)->id;
        $this->senderName = Sender::find(auth()->user()->sender_id)->name;
        $this->senderAddress = Sender::find(auth()->user()->sender_id)->address;
        $this->clients = Client::latest()->get();
    }

    public function render()
    {
        // Update the selected client address box to display the selected client's address
        if ($this->selectedClient != '')
            $this->clientAddress = Client::find($this->selectedClient)->address;
        else $this->clientAddress = '';

        return view('livewire.quote-sender-receiver');
    }
}
