<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SenderBankDetails extends Component
{
    public $banks = [[]];
    public $sender; // Variable that is only used when editing a sender profile

    public function mount()
    {
        if ($this->sender) {
            $this->banks = $this->sender->bank_info;
        } else {
            $this->banks = [
                ['institution' => '', 'accountName' => '', 'accountNumber' => ''],
            ];
        }
    }

    public function render()
    {
        return view('livewire.sender-bank-details');
    }

    // Add bank details line
    public function addBank()
    {
        $this->banks[] = [];
    }

    // Function to remove a bank details line
    public function removeBank($index)
    {
        // Check if there are more than one element in $banks
        // If yes, let the user remove the element. Otherwise, do nothing.
        // This is to keep the array of $termsConditions at least one element.
        if (count($this->banks) > 1) {
            unset($this->banks[$index]);
            $this->banks = array_values($this->banks);
        }
    }
}
