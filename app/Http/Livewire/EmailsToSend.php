<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EmailsToSend extends Component
{
    public $emails = []; // Store email inputs

    public function mount()
    {
        //
    }

    public function render()
    {
        return view('livewire.emails-to-send');
    }

    // Add email input line
    public function addEmail()
    {
        $this->emails[] = "";
    }
}
