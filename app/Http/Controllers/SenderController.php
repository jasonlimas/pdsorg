<?php

namespace App\Http\Controllers;

use App\Models\Sender;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;

class SenderController extends Controller
{
    // Create Sender Organization Profile page
    public function index()
    {
        return view('sender.create');
    }

    // Store Sender Organization Profile
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        // Validate bank details
        if (in_array(null, $request->banks, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'banksError' => ['One or more values are invalid'],
            ]);

            throw $error;
        }

        // Put all inputs into an array
        $banks = [];
        foreach ($request->banks as $bank) {
            $banks[] = $bank;
        }

        // Create Sender Organization Profile
        $sender = Sender::create([
            'name' => $request->name,
            'address' => $request->address,
            'bank_info' => $banks,
        ]);

        // Deal with logo
        $attachmentRequest = strtok($request->logo, '<'); // Using strtok() is probably a stupid fix but it works anyway
        $temporaryFile = TemporaryFile::where('folder', $attachmentRequest)->first();
        if ($temporaryFile) {
            $sender->addMedia(storage_path('app/image/sender/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->filename))
                ->toMediaCollection('logo');
            rmdir(storage_path('app/image/sender/tmp/' . $attachmentRequest));
            $temporaryFile->delete();
        }

        // Redirect back with success message
        return redirect()->route('admin')->with('success', 'Sender Organization Profile created successfully');
    }

    // Show Sender Organization Profile
    public function show(Sender $sender)
    {
        return view('sender.edit', [
            'sender' => $sender
        ]);
    }

    // Update Sender Organization Profile
    public function update(Request $request, Sender $sender)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

        // Validate bank details
        if (in_array(null, $request->banks, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'banksError' => ['One or more values are invalid'],
            ]);

            throw $error;
        }

        // Put all inputs into an array
        $banks = [];
        foreach ($request->banks as $bank) {
            $banks[] = $bank;
        }

        // Update Sender Organization Profile
        $sender->update([
            'name' => $request->name,
            'address' => $request->address,
            'bank_info' => $banks,
        ]);

        // Redirect back with success message
        return redirect()->route('admin')->with('success', 'Sender Organization Profile updated successfully');
    }

    // Destroy Sender Organization Profile
    public function destroy(Sender $sender)
    {
        //$this->authorize('delete', $sender);    // Make sure the user is authorized to delete the client
        $sender->delete();                      // Delete Sender Organization Profile

        // Redirect back with success message
        return back()->with('success', 'Sender Organization Profile deleted successfully');
    }
}
