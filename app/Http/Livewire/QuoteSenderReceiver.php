<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sender;
use Livewire\Component;

class QuoteSenderReceiver extends Component
{
    public $senders = [];
    public $clients = [];
    public $selectedSender = '';
    public $selectedClient = '';
    public $senderAddress = '';
    public $clientAddress = '';

    public function mount()
    {
        // Get senders and clients from the database
        $this->senders = Sender::all();
        $this->clients = Client::all();
    }

    public function render()
    {
        // Update the selected sender address box to display the selected sender's address
        if ($this->selectedSender != '')
            $this->senderAddress = Sender::find($this->selectedSender)->address;
        else $this->senderAddress = '';

        // Do the same for client address
        if ($this->selectedClient != '')
            $this->clientAddress = Client::find($this->selectedClient)->address;
        else $this->clientAddress = '';

        return view('livewire.quote-sender-receiver');
    }
}
