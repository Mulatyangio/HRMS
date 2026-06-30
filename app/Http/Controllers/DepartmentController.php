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
        return Inertia::render('Departments/Index', [
            'departments' => Departments::latest()->get(),
        ]);
    }
}
