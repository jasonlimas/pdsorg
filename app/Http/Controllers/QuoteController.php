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

        foreach($quotes as $quote) {
            $quote->client = Client::find($quote['client_id'])->name;
            $quote->amount = 'Rp ' . number_format($quote['amount']);
        }

        return view('quote.index', [
            'quotes' => $quotes,
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
    }

    // Delete a quote from the database. Called when clicking the delete quote button
    public function destroy(Quotation $quote)
    {
        $this->authorize('delete', Quotation::class); // Check permission first
        $quote->delete();           // Delete the quote

        // Redirect back with success message
        return back()->with('status', 'Quote deleted successfully');
    }
}
