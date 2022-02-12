<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sender;
use Livewire\Component;

class TermsConditions extends Component
{
    public $senders = [];
    public $clients = [];
    public $termsConditions = [""];

    public function mount()
    {
        // Get senders and clients from the database
        $this->senders = Sender::all();
        $this->clients = Client::all();
    }

    public function render()
    {
        return view('livewire.terms-conditions');
    }

    // Add terms and conditions line
    public function addTermsCondition()
    {
        $this->termsConditions[] = "";
    }

    // Function to remove a terms condition line
    public function removeTermsCondition($index)
    {
        // Check if there are more than one element in $termsConditions
        // If yes, let the user remove the element. Otherwise, do nothing.
        // This is to keep the array of $termsConditions at least one element.
        if (count($this->termsConditions) > 1) {
            unset($this->termsConditions[$index]);
            $this->termsConditions = array_values($this->termsConditions);
        }
    }
}
