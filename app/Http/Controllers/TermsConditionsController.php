<?php

namespace App\Http\Controllers;

use App\Models\TermsConditions;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    public function __construct()
    {
        // Prevent unauthenticated users from accessing the page
        $this->middleware(['auth'])->only(['index', 'store', 'destroy']);
    }

    // Return the terms and conditions preset create view
    public function index()
    {
        return view('terms.create');
    }

    // Add a terms and conditions preset to the database table
    public function store(Request $request)
    {
        // Validate terms and conditions
        if (in_array(null, $request->termsConditions, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'termsConditions' => ['One or more values are invalid'],
            ]);

            throw $error;
        }

        // Put all inputs into an array
        $termsConditions = [];
        foreach ($request->termsConditions as $term) {
            $termsConditions[] = $term;
        }

        // Save terms and conditions
        TermsConditions::create([
            'name' => $request->name,
            'terms_conditions' => $termsConditions,
        ]);

        // Redirect back
        return redirect()->route('profiles')->with('status', 'Terms and conditions preset created');
    }

    public function show(TermsConditions $term)
    {
        return view('terms.edit', [
            'term' => $term,
        ]);
    }

    // Update a terms and conditions preset in the database table
    public function update(Request $request, TermsConditions $term)
    {
        // Validate terms and conditions
        if (in_array(null, $request->termsConditions, true)) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'termsConditions' => ['One or more values are invalid'],
            ]);

            throw $error;
        }

        // Save the changes to the database table
        $term->update([
            'name' => $request->name,
            'terms_conditions' => $request->termsConditions,
        ]);

        // Redirect back with success message
        return redirect()->route('profiles')->with('status', 'Preset updated successfully');
    }

    // Delete a terms and conditions preset from the database table
    public function destroy(TermsConditions $term)
    {
        $term->delete();

        return back()->with('status', 'Terms and conditions preset deleted');
    }
}
