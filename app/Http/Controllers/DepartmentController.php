<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Departments;

class DepartmentController extends Controller
{
    public function create()
    {
        return inertia('Departments/Create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            

                'id' => 'required|integer|unique:departments,id',
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255|unique:departments,code',
                'description' => 'nullable|string',
                'head_id' => 'nullable|integer|exists:employees,id',
                'status' => 'required|boolean',
                'created_at' => 'required|datetime',
                'updated_at' => 'required|datetime'
                            

        ]);

        
        // Create a new employee record
        \App\Models\Departments::create($validatedData);

        // Redirect back to the employees list with a success message
        return redirect()->route('departments')->with('success', 'Department created successfully.');
    }
      public function index(): Response
    {
        return Inertia::render('Departments/Index', [
            'departments' => Departments::latest()->get(),
        ]);
    }
}
