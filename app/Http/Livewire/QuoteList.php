<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Quotation;
use Livewire\Component;

class QuoteList extends Component
{
    protected $quotes = [];

    public function mount()
    {
        // Get quotes from the database
        $this->quotes = Quotation::paginate(10);

        foreach($this->quotes as $quote) {
            $quote->client = Client::find($quote['client_id'])->name;
            $quote->amount = 'Rp ' . number_format($quote['amount']);
        }
    }

    public function render()
    {
        return view('livewire.quote-list', [
            'quotes' => $this->quotes,
        ]);
    }
}
