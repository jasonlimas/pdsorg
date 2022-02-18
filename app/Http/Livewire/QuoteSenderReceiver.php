<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sender;
use Livewire\Component;

class QuoteSenderReceiver extends Component
{
    public $sender = Sender::class;
    public $senderName = '';
    public $senderAddress = '';
    public $clients = [];
    public $selectedClient = '';
    public $clientDetails = '';

    public function mount()
    {
        // Get senders and clients from the database
        $this->sender = Sender::find(auth()->user()->sender_id);
        $this->clients = Client::latest()->get();
    }

    public function render()
    {

        // Update the selected client address box to display the selected client's address
        if ($this->selectedClient != '') {
            $this->clientDetails = Client::find($this->selectedClient)->address . ' - ' .
                Client::find($this->selectedClient)->email . ' - ' .
                Client::find($this->selectedClient)->phone;
        }

        else $this->clientAddress = '';

        return view('livewire.quote-sender-receiver');
    }
}
