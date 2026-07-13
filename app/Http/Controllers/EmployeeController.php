<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use App\Models\Employee;

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
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,on_leave',
            'salary' => 'nullable|numeric|min:0',
            'hired_at' => 'nullable|date',
            'department_id' => 'nullable|exists:departments,id',
            'is_department_head' => 'nullable|boolean',
        ]);

        
        // Create a new employee record
        $employee = \App\Models\Employee::create($validatedData);

        \App\Models\Notification::create([
            'type' => 'employee_added',
            'title' => 'New Employee Added',
            'message' => $employee->name . ' has been added as a ' . $employee->position . '.',
        ]);

        // Redirect back to the employees list with a success message
        return redirect()->route('employees')->with('success', 'Employee created successfully.');
    }
      public function index(): Response
    {
        return Inertia::render('Employees/Index', [
            'employees' => Employee::latest()->get(),
            'departments' => \App\Models\Departments::all(),
        ]);
    }

    public function edit(Employee $employee)
    {
        return inertia('Employees/Edit', [
            'employee' => $employee,
            'departments' => \App\Models\Departments::all(),
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'department' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,on_leave',
            'salary' => 'nullable|numeric|min:0',
            'hired_at' => 'nullable|date',
            'is_department_head' => 'nullable|boolean',
        ]);

        $employee->update($validatedData);

        return redirect()->route('employees')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $name = $employee->name;
        $employee->delete();

        \App\Models\Notification::create([
            'type' => 'employee_removed',
            'title' => 'Employee Removed',
            'message' => $name . ' has been removed from the system.',
        ]);

        return redirect()->route('employees')->with('success', 'Employee deleted successfully.');
    }
}