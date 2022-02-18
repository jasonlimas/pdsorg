<?php

namespace App\Http\Livewire;

use App\Models\Division;
use Livewire\Component;

class QuoteNumberAndDate extends Component
{
    public $divisionAbbreviation = '';
    public $userAbbreviation = '';

    public function mount()
    {
        // Get logged in user's division and abbreviation
        $this->divisionAbbreviation = Division::find(auth()->user()->division_id)->abbreviation;
        $this->userAbbreviation = auth()->user()->name_abbreviation;
    }

    public function render()
    {
        return view('livewire.quote-number-and-date');
    }
}
