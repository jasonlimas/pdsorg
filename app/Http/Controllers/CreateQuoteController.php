<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use Illuminate\Http\Request;
use App\Library\PDF\pdf;

class CreateQuoteController extends Controller
{
    public function index()
    {
        return view('quote.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        // Variables
        $quoteNumber = [
            'year' => $request->numberYear,
            'division' => $request->numberDivision,
            'sales' => $request->numberSales,
            'month' => $request->numberMonth,
            'number' => $request->numberNumber,
        ];

        $date = $request->date;

        $sender = [
            'name' => Sender::find($request->sender)->name,
            'addr' => Sender::find($request->sender)->address,
            'phone' => auth()->user()->phone,
            'email' => auth()->user()->email,
        ];

        $recipient = [
            'name' => Client::find($request->receiver)->name,
            'addr' => Client::find($request->receiver)->address,
            'phone' => Client::find($request->receiver)->phone,
            'email' => Client::find($request->receiver)->email,
        ];

        $items = [];
        foreach ($request->items as $item) {
            $items[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['unitPrice'],
            ];
        }
        $tax = $request->tax;

        $termsConditions = [];
        foreach ($request->termsConditions as $term) {
            $termsConditions[] = $term;
        }

        // Create PDF
        pdf::create($quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions);

        // Validate input, make sure there is no blank input

        return back()->with('status', 'Quote created successfully');
    }
}
