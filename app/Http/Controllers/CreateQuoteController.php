<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use Illuminate\Http\Request;
use App\Library\PDF\pdf;
use App\Models\Division;
use App\Models\Quotation;
use App\Models\TemporaryFile;
use App\Models\User;

class CreateQuoteController extends Controller
{
    public function index()
    {
        return view('quote.create');
    }

    // Page that shows buttons to download/create new/view all/email quote. Called when clicking the create quote button, after the quote is stored in the database
    public function finalize()
    {
        $quote = Quotation::find(auth()->user()->quotes()->latest()->first()->id);
        $sender = Sender::find($quote->sender_id)->name;
        $client = Client::find($quote->client_id)->name;

        return view('quote.finalize', [
            'quote' => $quote,
            'sender' => $sender,
            'client' => $client,
        ]);
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
        $newQuote = $request->user()->quotes()->create([
            'div' => Division::find(auth()->user()->division_id)->abbreviation,
            'sales_person' => auth()->user()->name_abbreviation,
            'number' => $request->numberNumber,
            'quote_date' => $request->date,
            'sender_id' => $request->sender,
            'client_id' => $request->receiver,
            'items' => $items,
            'tax' => $request->tax,
            'terms_conditions' => $termsConditions,
            'amount' => $amount,
            'user_id' => auth()->user()->id,
        ]);

        // Store temporary file in the database
        $attachmentRequest = strtok($request->attachment, '<'); // Using strtok() is probably a stupid fix but it works anyway
        $temporaryFile = TemporaryFile::where('folder', $attachmentRequest)->first();
        if ($temporaryFile) {
            $newQuote->addMedia(storage_path('app/attachments/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->filename))->toMediaCollection('attachments');
            rmdir(storage_path('app/attachments/tmp/' . $attachmentRequest));
            $temporaryFile->delete();
        }

        return redirect()->route('quotes.create.finalize');
    }

    // Function to download the quote as PDF
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

        // Attachment
        $attachment = $quote->getMedia('attachments');
        $attachmentPath = null;
        if (!$attachment->isEmpty()) {
            $attachmentPath = $attachment[0]->getPath();
        }

        // Create PDF
        pdf::create($quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions, $attachmentPath);
    }

    // Admin only section
    public function indexManual()
    {
        return view('quote.create-manual');
    }

    public function storeManual(Request $request)
    {
        dd($request);
    }
}
