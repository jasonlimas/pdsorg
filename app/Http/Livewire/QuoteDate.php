<?php

namespace App\Http\Livewire;

use Livewire\Component;

class QuoteDate extends Component
{
    public $quote;
    public $savedDate;

    public function mount()
    {
        if ($this->quote) {
            $this->savedDate = $this->quote->quote_date;
        }
    }

    public function render()
    {
        return view('livewire.quote-date');
    }
}
