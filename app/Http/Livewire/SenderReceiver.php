<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sender;
use Livewire\Component;

class SenderReceiver extends Component
{
    public $senders = [];
    public $clients = [];

    public function mount()
    {
        // Get senders and clients from the database
        $this->senders = Sender::all();
        $this->clients = Client::all();
    }

    public function render()
    {
        return view('livewire.sender-receiver');
    }
}
