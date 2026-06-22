<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create()
    {
        return inertia('Employees/Create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department' => 'required|string|max:255',
            'phone' => 'required|int|max:20',
        ]);

        // Create a new employee record
        \App\Models\Employee::create($validatedData);

        // Redirect back to the employees list with a success message
        return redirect()->route('employees')->with('success', 'Employee created successfully.');
    }
}