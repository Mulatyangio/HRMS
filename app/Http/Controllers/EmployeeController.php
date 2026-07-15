<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use App\Models\Employee;
use App\Models\User;

class EmployeeController extends Controller
{
    public function create()
    {
        return inertia('Employees/Create', [
            'departments' => \App\Models\Departments::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'department' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive,on_leave',
            'salary' => 'nullable|numeric|min:0',
            'hired_at' => 'nullable|date',
            'department_id' => 'nullable|exists:departments,id',
            'is_department_head' => 'nullable|boolean',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $password = $validatedData['password'];
        unset($validatedData['password']);
        unset($validatedData['password_confirmation']);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $password,
            'role' => 'employee',
        ]);

        $validatedData['user_id'] = $user->id;

        $employee = Employee::create($validatedData);

        \App\Models\Notification::create([
            'type' => 'employee_added',
            'title' => 'New Employee Added',
            'message' => $employee->name . ' has been added as a ' . $employee->position . '.',
        ]);

        return redirect()->route('employees')->with('success', 'Employee created successfully. Login credentials: ' . $user->email);
    }
      public function index(Request $request): Response
    {
        $query = Employee::with('user')->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($department = $request->query('department')) {
            $query->where('department', $department);
        }

        return Inertia::render('Employees/Index', [
            'employees' => $query->paginate(10)->withQueryString(),
            'departments' => \App\Models\Departments::all(),
        ]);
    }

    public function edit(Employee $employee)
    {
        return inertia('Employees/Edit', [
            'employee' => $employee->load('user'),
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
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $password = $validatedData['password'] ?? null;
        unset($validatedData['password']);
        unset($validatedData['password_confirmation']);

        $employee->update($validatedData);

        if ($employee->user) {
            $employee->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);

            if ($password) {
                $employee->user->update(['password' => $password]);
            }
        }

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