<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class QuoteItems extends Component
{
    public $items = [];
    public $tax = 0;
    public $subTotal = 0;
    public $grandTotal = 0;
    public $quote;

    public function mount()
    {
        if ($this->quote) {
            foreach ($this->quote->items as $item) {
                $this->items[] = [
                    'name' => $item['name'],
                    'quantity' => intval($item['quantity']),
                    'unitPrice' => floatval($item['price']),
                    'totalPrice' => 0.00,              // This will be calculated later
                    'formattedTotalPrice' => '',    // Same for this one
                ];
            }

            $this->tax = $this->quote->tax;
        } else {
            // Get the tax from the database
            $this->tax = DB::table('app_settings')->where('setting_name', 'tax')->first()->setting_value;
            $this->items = [
                ['name' => '', 'quantity' => 1, 'unitPrice' => 0, 'totalPrice' => 0.00, 'formattedTotalPrice' => ''],
            ];
        }
    }

    public function render()
    {
        // Calculate total price for each item (quantity * unitPrice)
        foreach ($this->items as $index => $item) {
            $this->items[$index]['totalPrice'] = intval($item['quantity']) * floatval($item['unitPrice']);
            $this->items[$index]['formattedTotalPrice'] = 'Rp. ' . number_format($this->items[$index]['totalPrice'], 2);
        }

        // Calculate sub total: Sum of all total prices
        $tempSubTotal = array_sum(array_column($this->items, 'totalPrice'));
        $this->subTotal = 'Rp. ' . number_format($tempSubTotal, 2);

        // Calculate the grand total: sub total + tax
        $this->grandTotal = 'Rp. ' . number_format(floatval($tempSubTotal + ($tempSubTotal * (floatval($this->tax) / 100))), 2);

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
