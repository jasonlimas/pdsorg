<?php

namespace App\Http\Livewire;

use Livewire\Component;

class QuoteItems extends Component
{
    public $items = [];
    public $tax = 0;
    public $subTotal = 0;
    public $grandTotal = 0;

    public function mount()
    {
        $this->items = [
            ['name' => '', 'quantity' => 1, 'unitPrice' => 0, 'totalPrice' => 0],
        ];
    }

    public function render()
    {
        // Calculate total price for each item (quantity * unitPrice)
        foreach ($this->items as $index => $item) {
            $this->items[$index]['totalPrice'] = intval($item['quantity']) * intval($item['unitPrice']);
        }

        // Calculate sub total: Sum of all total prices
        $tempSubTotal = array_sum(array_column($this->items, 'totalPrice'));
        $this->subTotal = 'Rp. ' . number_format($tempSubTotal);

        // Calculate the grand total: sub total + tax
        $this->grandTotal = 'Rp. ' . number_format(intval($tempSubTotal + ($tempSubTotal * (intval($this->tax) / 100))));

        return view('livewire.quote-items');
    }

    // Add item row to the table in the form
    public function addItem()
    {
        $this->items[] = ['name' => '', 'quantity' => 1, 'unitPrice' => 0];
    }

    // Remove item row from the table in the form
    public function removeItem($index)
    {
        // Check if there are more than one element in $items
        // If yes, let the user remove the element. Otherwise, do nothing.
        // This is to keep the array of $items at least one element.
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }
}
