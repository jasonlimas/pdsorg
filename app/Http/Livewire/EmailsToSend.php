<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class EmailsToSend extends Component
{
    public $emails = []; // Store email inputs
    public $clientId = '';

    public function mount()
    {
        // Get client email of selected quote to be sent
        $this->emails[] = Client::find($this->clientId)->email;
    }

    public function render()
    {
        return view('livewire.emails-to-send');
    }

    // Add email input line
    public function addEmail()
    {
        $this->emails[] = '';
    }

    // Remove an email input line
    public function removeEmail($index)
    {
        // Check if there are more than one element in $emails
        // If yes, let the user remove the element. Otherwise, do nothing.
        // This is to keep the array of $emails at least one element.
        if (count($this->emails) > 1) {
            unset($this->emails[count($this->emails) - 1]);
            $this->emails = array_values($this->emails);
        }
    }
}
