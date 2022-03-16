<?php

namespace App\Http\Controllers;

use App\Library\PDF\PDF;
use App\Mail\QuoteSent;
use App\Models\Client;
use App\Models\Division;
use App\Models\Quotation;
use App\Models\Sender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    public function index()
    {
        // Check currently logged in user's role
        if (auth()->user()->role_id == 1) {
            $quotes = Quotation::latest()->paginate(10);
        } else if (auth()->user()->role_id == 2) {
            $quotes = Quotation::where('div', Division::withTrashed()->find(auth()->user()->division_id)->abbreviation)->latest()->paginate(10);
        } else {
            $quotes = Quotation::where('user_id', auth()->user()->id)->latest()->paginate(10);
        }


        foreach ($quotes as $quote) {
            $quote->client = Client::withTrashed()->find($quote['client_id'])->name;
            $quote->amount = 'Rp ' . number_format($quote['amount']);
            $quote->createdBy = User::withTrashed()->find($quote['user_id'])->name_abbreviation;
        }

        // Get all clients for quote filtering purposes
        $clients = Client::latest()->get();

        return view('quote.index', [
            'quotes' => $quotes,
            'clients' => $clients,
            'filter' => false,
        ]);
    }

    public function query(Request $request)
    {
        // Check if input date is empty or not completed.
        // Both value for startDate and endDate must be present if one of them is present.
        $this->validate($request, [
            'startDate' => 'required_with:endDate',
            'endDate' => 'required_with:startDate',
        ]);

        if ($request->startDate && $request->endDate) {
            // Validate if input date is valid
            $this->validate($request, [
                'startDate' => 'date',
                'endDate' => 'date|after_or_equal:startDate',
            ]);

            $start = Carbon::parse($request->startDate);
            $end = Carbon::parse($request->endDate);

            if ($request->client) {
                // Check currently logged in user's role
                if (auth()->user()->role_id == 1) {
                    $quotes = Quotation::whereDate('quote_date', '<=', $end)
                        ->whereDate('quote_date', '>=', $start)
                        ->where('client_id', $request->client)
                        ->latest()->paginate(10);
                } else if (auth()->user()->role_id == 2) {
                    $quotes = Quotation::whereDate('quote_date', '<=', $end)
                        ->whereDate('quote_date', '>=', $start)
                        ->where('div', Division::withTrashed()->find(auth()->user()->division_id)->abbreviation)
                        ->where('client_id', $request->client)
                        ->latest()->paginate(10);
                } else {
                    $quotes = Quotation::whereDate('quote_date', '<=', $end)
                        ->whereDate('quote_date', '>=', $start)
                        ->where('user_id', auth()->user()->id)
                        ->where('client_id', $request->client)
                        ->latest()->paginate(10);
                }
            } else {
                // Check currently logged in user's role
                if (auth()->user()->role_id == 1) {
                    $quotes = Quotation::whereDate('quote_date', '<=', $end)
                        ->whereDate('quote_date', '>=', $start)
                        ->latest()->paginate(10);
                } else if (auth()->user()->role_id == 2) {
                    $quotes = Quotation::whereDate('quote_date', '<=', $end)
                        ->whereDate('quote_date', '>=', $start)
                        ->where('div', Division::withTrashed()->find(auth()->user()->division_id)->abbreviation)
                        ->latest()->paginate(10);
                } else {
                    $quotes = Quotation::whereDate('quote_date', '<=', $end)
                        ->whereDate('quote_date', '>=', $start)
                        ->where('user_id', auth()->user()->id)
                        ->latest()->paginate(10);
                }
            }
        } else if ($request->client) {  // Get all quotes quoted to the selected client
            // Check currently logged in user's role
            if (auth()->user()->role_id == 1) {
                $quotes = Quotation::where('client_id', $request->client)
                    ->latest()->paginate(10);
            } else if (auth()->user()->role_id == 2) {
                $quotes = Quotation::where('div', Division::withTrashed()->find(auth()->user()->division_id)->abbreviation)
                    ->where('client_id', $request->client)
                    ->latest()->paginate(10);
            } else {
                $quotes = Quotation::where('user_id', auth()->user()->id)
                    ->where('client_id', $request->client)
                    ->latest()->paginate(10);
            }
        } else {    // Get all quotes
            // Check currently logged in user's role
            if (auth()->user()->role_id == 1) {
                $quotes = Quotation::latest()->paginate(10);
            } else if (auth()->user()->role_id == 2) {
                $quotes = Quotation::where('div', Division::withTrashed()->find(auth()->user()->division_id)->abbreviation)->latest()->paginate(10);
            } else {
                $quotes = Quotation::where('user_id', auth()->user()->id)->latest()->paginate(10);
            }
        }

        // Build quote query result (get name, amount, created by)
        // Because after fetching the result, a quote object only has ID for client name and created by. We need to fetch the details about those IDs
        // The amount needs to be formatted too, for better viewing experience
        foreach ($quotes as $quote) {
            $quote->client = Client::withTrashed()->find($quote['client_id'])->name;
            $quote->amount = 'Rp ' . number_format($quote['amount']);
            $quote->createdBy = User::withTrashed()->find($quote['user_id'])->name_abbreviation;
        }

        // Get all clients for quote filtering purposes
        $clients = Client::latest()->get();

        return view('quote.index', [
            'quotes' => $quotes,
            'clients' => $clients,
            'filter' => true,
            'startDate' => $request->startDate ? $request->startDate : 'any start date',
            'endDate' => $request->endDate ? $request->endDate : 'any end date',
            'client' => Client::find($request->client) ? Client::find($request->client)->name : 'any client',
        ]);
    }

    public function show(Quotation $quote)
    {
        return view('quote.edit', [
            'quote' => $quote,
        ]);
    }

    public function duplicate(Quotation $quote)
    {
        return view('quote.copy', [
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

        // Include soft deleted records when looking for sender information
        $senderPerson = User::withTrashed()->find($quote->user_id);
        $senderOrg = Sender::withTrashed()->find($quote->sender_id);
        $sender = [
            'person' => $senderPerson->name,
            'name' => $senderOrg->name,
            'addr' => $senderOrg->address,
            'phone' => $senderPerson->phone,
            'email' => $senderPerson->email,
        ];

        // Include soft deleted records when looking for client information
        $recipientObject = Client::withTrashed()->find($quote->client_id);
        $recipient = [
            'name' => $recipientObject->name,
            'addr' => $recipientObject->address,
            'phone' => $recipientObject->phone,
            'email' => $recipientObject->email,
        ];

        // Items
        $items = [];
        foreach ($quote->items as $item) {
            $items[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        // Tax
        $tax = $quote->tax;

        // Terms and conditions
        $termsConditions = [];
        foreach ($quote->terms_conditions as $term) {
            $termsConditions[] = $term;
        }

        // Bank details
        $bank = [
            'bank_institution' => $senderOrg->bank_institution,
            'bank_account_name' =>$senderOrg->bank_account_name,
            'bank_account_number' => $senderOrg->bank_account_number,
        ];

        // Attachment
        $attachment = $quote->getMedia('attachments');
        $attachmentPath = null;
        if (!$attachment->isEmpty()) {
            $attachmentPath = $attachment[0]->getPath();
        }

        // Create PDF
        PDF::create($quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions, $bank, $attachmentPath);
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

    public function storeDuplicate(Request $request, Quotation $quote)
    {
        // Validate input
        $this->validate($request, [
            'date' => 'required|after:today',
            'tax' => 'required|integer|min:0|max:100',
        ]);

        // Create new quote
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

        // Save to database
        $request->user()->quotes()->create([
            'div' => $quote->div,
            'sales_person' => $quote->sales_person,
            'number' => $quote->number + 1,
            'quote_date' => $request->date,
            'sender_id' => $quote->sender_id,
            'client_id' => $quote->client_id,
            'items' => $items,
            'tax' => $request->tax,
            'terms_conditions' => $termsConditions,
            'amount' => $amount,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('quotes')->with('success', 'Quote duplicated successfully');
    }

    public function sendEmail(Quotation $quote)
    {
        $user = auth()->user();

        Mail::to('jasonandrea14@gmail.com')->send(new QuoteSent(route('quote.download', $quote)));

        return back()->with('success', 'Email sent successfully');
    }
}
