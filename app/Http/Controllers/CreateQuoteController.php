<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Sender;
use Illuminate\Http\Request;
use App\Library\PDF\pdf;
use App\Models\Division;
use App\Models\Quotation;
use App\Models\QuoteCounter;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

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
        $sender = Sender::withTrashed()->find($quote->sender_id)->name;
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
            // Quote date
            'date' => 'required|after_or_equal:today',

            // Receiver
            'receiver' => 'required|exists:clients,id',

            // Validate language input
            'language' => 'required'

            // Items and Terms & Conditions are validated separately
        ]);

        // Generate quote number
        $year = substr($request->date, 0, 4);   // Get the year from the input date
        $counter = QuoteCounter::where('year', $year)->first();
        if ($counter) { // If the counter for the year exists, increment the counter
            $counter->count++;
            $counter->save();
        } else {    // If the counter for the year does not exist, create a new counter starting at 1
            $counter = new QuoteCounter();
            $counter->year = $year;
            $counter->count = 1;
            $counter->save();
        }

        $number = $counter->count;  // Make the counter to be the quote number

        // Validate terms and conditions
        if (in_array(null, $request->termsConditions, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'termsConditions' => ['One or more values are missing'],
            ]);

            throw $error;
        }

        // Get tax from the database
        $tax = DB::table('app_settings')->where('setting_name', 'tax')->first()->setting_value;

        $items = [];
        $amount = 0;
        foreach ($request->items as $item) {
            $items[] = [
                'name' => $item['name'],
                'pn' => $item['pn'],
                'quantity' => $item['quantity'],
                'quantityUnit' => $item['quantityUnit'],
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
        $amount = $amount + ($amount * $tax / 100);

        $termsConditions = [];
        foreach ($request->termsConditions as $term) {
            $termsConditions[] = $term;
        }

        // Get language
        $languageIsIndonesia = 0;
        if ($request->language == 'indonesia') {
            $languageIsIndonesia = 1;
        }

        // Save to database
        $newQuote = $request->user()->quotes()->create([
            'div' => Division::withTrashed()->find(auth()->user()->division_id)->abbreviation,
            'sales_person' => auth()->user()->name_abbreviation,
            'number' => $number,
            'quote_date' => $request->date,
            'sender_id' => $request->sender,
            'client_id' => $request->receiver,
            'items' => $items,
            'tax' => $tax,
            'terms_conditions' => $termsConditions,
            'amount' => $amount,
            'user_id' => auth()->user()->id,
            'status_id' => 1, // Default status. 1 is "Not sent"
            'hash_of_id' => 0, // Will be replaced after this
            'language_is_indonesia' => $languageIsIndonesia,
        ]);

        // Generate hash based on the quote id
        $newQuote->update(['hash_of_id' => md5($newQuote->id)]);

        // Store temporary file in the database
        $attachmentRequest = strtok($request->attachment, '<'); // Using strtok() is probably a stupid fix but it works anyway
        $temporaryFile = TemporaryFile::where('folder', $attachmentRequest)->first();
        if ($temporaryFile) {
            $newQuote->addMedia(storage_path('app/attachments/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->filename))
                ->toMediaCollection('attachments');
            rmdir(storage_path('app/attachments/tmp/' . $attachmentRequest));
            $temporaryFile->delete();
        }

        return redirect()->route('quotes.create.finalize');
    }

    // Function to download the quote as PDF
    public function download(Quotation $quote)
    {
        // Number
        $quoteNumber = [
            'year' => substr($quote->quote_date, 0, 4),
            'division' => $quote->div,
            'sales' => $quote->sales_person,
            'month' => substr($quote->quote_date, 5, 2),
            'number' => $quote->number,
        ];

        // Date
        $date = $quote->quote_date;

        // Sender data
        $senderPerson = User::find($quote->user_id);
        $senderOrg = Sender::find($quote->sender_id);
        $sender = [
            'person' => $senderPerson->name,
            'name' => $senderOrg->name,
            'addr' => $senderOrg->address,
            'phone' => $senderPerson->phone,
            'email' => $senderPerson->email,
        ];

        // Client data
        $recipientObject = Client::find($quote->client_id);
        $recipient = [
            'name' => $recipientObject->name . ' - ' . $recipientObject->pic,
            'addr' => $recipientObject->address,
            'phone' => $recipientObject->phone,
            'email' => $recipientObject->email,
        ];

        // Items
        $items = [];
        foreach ($quote->items as $item) {
            $items[] = [
                'name' => $item['name'],
                'pn' => $item['pn'],
                'quantity' => $item['quantity'],
                'quantityUnit' => $item['quantityUnit'],
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

        // Language
        $languageIsIndonesia = $quote->language_is_indonesia;

        // Create PDF
        pdf::create($logoPath, $quoteNumber, $date, $sender, $recipient, $items, $tax, $termsConditions, $banks, $attachmentPath, $languageIsIndonesia);
    }

    // Admin only section
    public function indexManual()
    {
        return view('quote.create-manual');
    }

    public function storeManual(Request $request)
    {
        // Input validation
        $this->validate($request, [
            // Quote number
            'numberDivision' => 'required|string|max:5',
            'numberSales' => 'required|string|max:5',
            'numberNumber' => 'required|integer|min:0',

            // Quote date
            'date' => 'required|date',

            // Sender and Receiver
            'sender' => 'required|exists:senders,id',
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
                'pn' => $item['pn'],
                'quantity' => $item['quantity'],
                'quantityUnit' => $item['quantityUnit'],
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
            'div' => $request->numberDivision,
            'sales_person' => $request->numberSales,
            'number' => $request->numberNumber,
            'quote_date' => $request->date,
            'sender_id' => $request->sender,
            'client_id' => $request->receiver,
            'items' => $items,
            'tax' => $request->tax,
            'terms_conditions' => $termsConditions,
            'amount' => $amount,
            'user_id' => auth()->user()->id,
            'status_id' => 1, // Default status. 1 is "Not sent"
        ]);

        // Store temporary file in the database
        $attachmentRequest = strtok($request->attachment, '<'); // Using strtok() is probably a stupid fix but it works anyway
        $temporaryFile = TemporaryFile::where('folder', $attachmentRequest)->first();
        if ($temporaryFile) {
            $newQuote->addMedia(storage_path('app/attachments/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->filename))->toMediaCollection('attachments');
            rmdir(storage_path('app/attachments/tmp/' . $attachmentRequest));
            $temporaryFile->delete();
        }

        // Redirect to finalize quote page
        return redirect()->route('quotes.create.finalize');
    }
}
