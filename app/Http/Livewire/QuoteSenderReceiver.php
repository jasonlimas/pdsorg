<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sender;
use Livewire\Component;

class QuoteSenderReceiver extends Component
{
    public $senders = Sender::class;
    public $selectedSender = '';
    public $senderDetails = '';
    public $senderAddress = ''; // Only for normal quote create, not for manual create
    public $clients = [];
    public $selectedClient = '';
    public $clientDetails = '';
    public $quote;
    public $isCopied = false;
    public $isManual = false;

    public function mount()
    {
        // Get sender from the database
        if ($this->isManual) {
            $this->senders = Sender::latest()->get();
        } else {
            $this->senders = Sender::withTrashed()->find(auth()->user()->sender_id);
            $this->senderAddress = $this->senders->address;
        }

        if (auth()->user()->role_id == 1) {
            // Get all clients from the database
            $this->clients = Client::latest()->get();
        } else {
            // If user is not admin, then only show clients created from their division
            $this->clients = Client::where('division_id', auth()->user()->division_id)->latest()->get();
        }

        // If user is editing a copied quote, get the copied quote client
        if ($this->quote) {
            $this->selectedClient = $this->quote->client_id;
        }
    }

    public function render()
    {
        // Update the selected client address box to display the selected client's address
        if ($this->selectedClient != '') {
            $this->clientDetails = Client::withTrashed()->find($this->selectedClient)->address . ' - ' .
                Client::withTrashed()->find($this->selectedClient)->email . ' - ' .
                Client::withTrashed()->find($this->selectedClient)->phone;
        } else $this->clientDetails = '';

        // Same but for the sender
        if ($this->selectedSender != '') {
            $this->senderDetails = Sender::withTrashed()->find($this->selectedSender)->address;
        } else $this->senderDetails = '';

        return view('livewire.quote-sender-receiver');
    }
}
