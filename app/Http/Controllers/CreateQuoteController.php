<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use Illuminate\Http\Request;
use App\Library\PDF\pdf;
use App\Models\Division;

class CreateQuoteController extends Controller
{
    public function index()
    {
        return view('quote.create');
    }

    public function store(Request $request)
    {
        // Input validation
        $this->validate($request, [
            // Quote number
            'numberNumber' => 'required|integer|min:0',

            // Quote date
            'date' => 'required|after:today',

            // Receiver
            'receiver' => 'required|exists:clients,id',

            // Tax
            'tax' => 'required|integer|min:0|max:100',

            // Items and Terms & Conditions are validated separately
        ]);

        // Validate terms and conditions
        if (in_array(null, $request->termsConditions, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'termsConditions' => ['One or more values are missing'],
            ]);

            throw $error;
        }

        // Variables
        $quoteNumber = [
            'year' => substr($request->date, 0, 4),
            'division' => Division::find(auth()->user()->division_id)->abbreviation,
            'sales' => auth()->user()->name_abbreviation,
            'month' => substr($request->date, 5, 2),
            'number' => $request->numberNumber,
        ];

        $date = $request->date;

        $sender = [
            'name' => Sender::find(auth()->user()->sender_id)->name,
            'addr' => Sender::find(auth()->user()->sender_id)->address,
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
        $amount = 0;
        foreach ($request->items as $item) {
            $items[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['unitPrice'],
            ];

            // Validate items
            if (in_array(null, $item, true) || $item['quantity'] < 1 || $item['unitPrice'] < 0) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'items' => ['One or more values are not valid'],
                ]);

                throw $error;
            }

            $amount += $item['quantity'] * $item['unitPrice'];
        }

        $tax = $request->tax;

        // Calculate amount again, but with tax
        $amount = $amount + ($amount * $tax / 100);

        $termsConditions = [];
        foreach ($request->termsConditions as $term) {
            $termsConditions[] = $term;
        }

        // Save to database
        $request->user()->quotes()->create([
            'div' => $quoteNumber['division'],
            'sales_person' => $quoteNumber['sales'],
            'number' => $quoteNumber['number'],
            'quote_date' => $date,
            'sender_id' => $request->sender,
            'client_id' => $request->receiver,
            'items' => $items,
            'tax' => $tax,
            'terms_conditions' => $termsConditions,
            'amount' => $amount,
        ]);

        // Create PDF
        pdf::create($quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions);

        return back();
    }
}
