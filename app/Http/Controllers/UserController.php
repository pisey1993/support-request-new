<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Show the form with users dropdown
    public function create()
    {
        $users = User::all(); // you already have this for requester_name select
        $departments = Department::all(); // get all departments
        $positions = Position::all(); // get all departments

        return view('support_requests.create', compact('users', 'departments','positions'));
    }

    // Process form submission
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'requester_name' => 'required|string|max:255',
            // Add other fields validation here
        ]);

        // Example: do something with the selected requester_name
        // For example, save to a model or process logic
        // Here is just a simple return success message

        return redirect()->back()->with('success', 'Form submitted successfully with requester: ' . $request->requester_name);
    }
}
