<?php

namespace App\Http\Livewire;

use App\Models\Division;
use App\Models\User;
use Livewire\Component;

class QuoteNumber extends Component
{
    public $divisionAbbreviation = '';
    public $userAbbreviation = '';
    public $quoteNumber;
    public $quote;
    public $isCopied = false;
    public $isManual = false;

    public function mount()
    {
        // Get logged in user's division and abbreviation
        if ($this->quote) {
            $this->divisionAbbreviation = $this->quote->div;
            $this->userAbbreviation = $this->quote->sales_person;
            $this->quoteNumber = $this->quote->number;
        } else {
            $this->divisionAbbreviation = Division::withTrashed()->find(auth()->user()->division_id)->abbreviation;
            $this->userAbbreviation = auth()->user()->name_abbreviation;
        }
    }

    public function render()
    {
        return view('livewire.quote-number');
    }
}
