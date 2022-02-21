<?php

namespace App\Http\Controllers;

use App\Library\PDF\PDF;
use App\Models\Client;
use App\Models\Quotation;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quotation::latest()->paginate(10);

        foreach ($quotes as $quote) {
            $quote->client = Client::find($quote['client_id'])->name;
            $quote->amount = 'Rp ' . number_format($quote['amount']);
        }

        return view('quote.index', [
            'quotes' => $quotes,
        ]);
    }

    public function show(Quotation $quote)
    {
        return view('quote.edit', [
            'quote' => $quote,
        ]);
    }

    // Create a new quote PDF file based on the data saved in the database. Called when clicking the download quote button
    public function download(Quotation $quote)
    {
        $quoteNumber = [
            'year' => substr($quote->quote_date, 0, 4),
            'division' => $quote->div,
            'sales' => $quote->sales_person,
            'month' => substr($quote->quote_date, 5, 2),
            'number' => $quote->number,
        ];

        $date = $quote->quote_date;

        $sender = [
            'person' => User::find($quote->user_id)->name,
            'name' => Sender::find($quote->sender_id)->name,
            'addr' => Sender::find($quote->sender_id)->address,
            'phone' => User::find($quote->user_id)->phone,
            'email' => User::find($quote->user_id)->email,
        ];

        $recipient = [
            'name' => Client::find($quote->client_id)->name,
            'addr' => Client::find($quote->client_id)->address,
            'phone' => Client::find($quote->client_id)->phone,
            'email' => Client::find($quote->client_id)->email,
        ];

        $items = [];
        foreach ($quote->items as $item) {
            $items[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        $tax = $quote->tax;

        $termsConditions = [];
        foreach ($quote->terms_conditions as $term) {
            $termsConditions[] = $term;
        }

        // Create PDF
        PDF::create($quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions);
    }

    // Update a quote from the database. Called when clicking the edit quote button
    public function update(Request $request, Quotation $quote)
    {
        // Check permission first
        $this->authorize('edit', Quotation::class);

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

        // Calculate amount again, but with tax
        $amount = $amount + ($amount * $request->tax / 100);

        $termsConditions = [];
        foreach ($request->termsConditions as $term) {
            $termsConditions[] = $term;
        }

        // Update quote
        $quote->update([
            'div' => $quote->div,                   // Remains unchanged
            'sales_person' => $quote->sales_person, // Remains unchanged
            'number' => $request->numberNumber,
            'quote_date' => $request->date,
            'sender_id' => $request->sender,
            'client_id' => $request->receiver,
            'items' => $items,
            'tax' => $request->tax,
            'terms_conditions' => $termsConditions,
            'amount' => $amount,
            'user_id' => $quote->user_id,           // Remains unchanged
        ]);

        return redirect()->route('quotes')->with('success', 'Quote updated successfully');
    }

    // Delete a quote from the database. Called when clicking the delete quote button
    public function destroy(Quotation $quote)
    {
        $this->authorize('delete', Quotation::class); // Check permission first
        $quote->delete();           // Delete the quote

        // Redirect back with success message
        return back()->with('success', 'Quote deleted successfully');
    }
}
