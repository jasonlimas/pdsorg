<?php

namespace App\Http\Controllers;

use App\Library\PDF\pdf;
use App\Mail\QuoteSent;
use App\Models\Client;
use App\Models\Division;
use App\Models\Quotation;
use App\Models\QuoteStatus;
use App\Models\Sender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

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
            $quote->status = QuoteStatus::find($quote['status_id'])->name;
            //dd($quote->items);
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
            $quote->status = QuoteStatus::find($quote['status_id'])->name;
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

    public function view(Quotation $quote)
    {
        // Status of quote in text, because the data stored in database is status ID
        $quote->status_text = QuoteStatus::find($quote->status_id)->name;

        // Make date to be more readable
        $brokenDate = explode('-', $quote->quote_date);
        $quote->formatted_date = date('l, d F Y', mktime(0, 0, 0, $brokenDate[1], $brokenDate[2], $brokenDate[0]));

        // Get client info
        $quote->client = Client::withTrashed()->find($quote->client_id)->name;

        return view('quote.view', [
            'quote' => $quote,
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
        $banks = [];
        foreach ($senderOrg->bank_info as $bank) {
            $banks[] = $bank;
        }

        // Logo path
        $logo = $senderOrg->getMedia('logo');
        $logoPath = null;
        if (!$logo->isEmpty()) {
            $logoPath = $logo[0]->getPath();
            Image::load($logoPath)->fit(Manipulations::FIT_MAX, 180, 60)->save();
        }

        // Attachment path
        $attachment = $quote->getMedia('attachments');
        $attachmentPath = null;
        if (!$attachment->isEmpty()) {
            $attachmentPath = $attachment[0]->getPath();
        }

        // Create PDF
        pdf::create($logoPath, $quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions, $banks, $attachmentPath);
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
            'status_id' => $quote->status_id,       // Remains unchanged
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
            'date' => 'required|after_or_equal:today',
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
            'status_id' => 1, // Status 1 = "Not sent"
        ]);

        return redirect()->route('quotes.create.finalize')->with('success', 'Quote duplicated successfully');
    }

    public function sendEmail(Quotation $quote)
    {
        // Get client's email
        $client = Client::withTrashed()->find($quote->client_id)->only(['name', 'email']);

        // Array to store emails to be CC'd
        $emailToCC = [config('mail.from.address')];

        // Quote creator
        $creator = User::find($quote->user_id)->only(['name', 'email', 'phone', 'sender_id']);
        $emailToCC[] = $creator['email'];    // Put creator's email in CC

        // Leaders of the division
        $leaders = User::where('division_id', User::find($quote->user_id)->division_id)->where('role_id', 2)->get();
        foreach ($leaders as $leader) { // Put all leaders' emails in CC
            if ($leader->email != $creator) {
                $emailToCC[] = $leader->email;
            }
        }

        // Send the email to the client and all emails in $emailToCC (Creator and division leader(s))
        Mail::to($client['email'])
            ->cc($emailToCC)
            ->send(new QuoteSent($client['name'], $quote, route('quote.download', $quote), $creator));

        // Change quote status to "Sent"
        $quote->update([
            'status_id' => 2,
        ]);

        return redirect()->route('quotes')->with('success', 'Email sent successfully');
    }
}
