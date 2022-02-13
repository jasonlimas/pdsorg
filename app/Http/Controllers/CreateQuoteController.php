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
        $validateMe = [
            // Quote number
            'numberYear' => 'required',
            'numberDivision' => 'required',
            'numberSales' => 'required',
            'numberMonth' => 'required',
            'numberNumber' => 'required',

            // Quote date
            'date' => 'required',

            // Sender & receiver
            'sender' => 'required',
            'receiver' => 'required',

            // Tax
            'tax' => 'required',

            // Items and Terms & Conditions are validated separately
        ];

        // * Input validation
        $this->validate($request, $validateMe);

        // Validate items
        foreach ($request->items as $item) {
            if (in_array(null, $item, true)) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'items' => ['One or more values are missing'],
                ]);

                throw $error;
            }
        }

        // Validate terms and conditions
        if (in_array(null, $request->termsConditions, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'termsConditions' => ['One or more values are missing'],
            ]);

            throw $error;
        }

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

        return back();
    }
}
