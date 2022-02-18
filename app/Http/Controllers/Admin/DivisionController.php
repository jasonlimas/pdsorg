<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        return view('admin.division.create');
    }

    public function show(Division $division)
    {
        return view('admin.division.edit', [
            'division' => $division,
        ]);
    }

    // Function for adding new division to the database divisions table
    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
            'abbreviation' => 'required|string|max:5',
            'description' => 'required|string|max:255',
        ]);

        // Add division to the database table
        Division::create([
            'abbreviation' => $request->abbreviation,
            'description' => $request->description,
        ]);

        // Redirect back to admin panel with success message
        return redirect()->route('admin')->with('success', 'Division ' . $request->abbreviation . ' created successfully');
    }

    // Function for updating a division to the database divisions table
    public function update(Request $request, Division $division)
    {
        // Validate
        $this->validate($request, [
            'abbreviation' => 'required|string|max:5',
            'description' => 'required|string|max:255',
        ]);

        // Update division in the database table
        $division->update([
            'abbreviation' => $request->abbreviation,
            'description' => $request->description,
        ]);

        // Redirect back to admin panel with success message
        return redirect()->route('admin')->with('success', 'Division ' . $request->abbreviation . ' updated successfully');
    }

    // Function for deleting a division from the database divisions table
    public function destroy(Division $division)
    {
        // Delete division from the database table
        $division->delete();

        // Redirect back to admin panel with success message
        return redirect()->route('admin')->with('success', 'Division ' . $division->abbreviation . ' deleted successfully');
    }
}
