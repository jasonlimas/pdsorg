<?php

namespace App\Http\Controllers;

use App\Models\TermsConditions;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    public function index()
    {
        return view('terms.index');
    }

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
}
