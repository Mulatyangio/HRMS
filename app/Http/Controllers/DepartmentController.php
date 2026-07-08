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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'head' => 'nullable|string|max:255',
        ]);

        $words = explode(' ', $validatedData['name']);
        $code = count($words) > 1
            ? collect($words)->map(fn($w) => strtoupper($w[0]))->implode('')
            : strtoupper(substr($validatedData['name'], 0, 3));

        $validatedData['code'] = $code;

        Departments::create($validatedData);

        return redirect()->route('departments')->with('success', 'Department created successfully.');
    }
      public function index(): Response
    {
        $departments = Departments::all()->map(function ($dept) {
            $head = \App\Models\Employee::where('department', $dept->name)
                ->where('is_department_head', true)
                ->first();
            $dept->head_name = $head ? $head->name : null;
            return $dept;
        });

        return Inertia::render('Departments/Index', [
            'departments' => $departments,
        ]);
    }

    public function edit(Departments $department)
    {
        $head = \App\Models\Employee::where('department', $department->name)
            ->where('is_department_head', true)
            ->first();
        $department->head_name = $head ? $head->name : null;

        return inertia('Departments/Edit', [
            'department' => $department,
        ]);
    }

    public function update(Request $request, Departments $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'head' => 'nullable|string|max:255',
        ]);

        $words = explode(' ', $validatedData['name']);
        $code = count($words) > 1
            ? collect($words)->map(fn($w) => strtoupper($w[0]))->implode('')
            : strtoupper(substr($validatedData['name'], 0, 3));

        $validatedData['code'] = $code;

        $department->update($validatedData);

        return redirect()->route('departments')->with('success', 'Department updated successfully.');
    }

    public function destroy(Departments $department)
    {
        $department->delete();
        return redirect()->route('departments')->with('success', 'Department deleted successfully.');
    }
}
