<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    return inertia('Attendance/index', [
        'attendances' => Attendance::with('employee')
            ->latest()
            ->get(),
    ]);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          return inertia('Attendance/Create', [
            'employees' => Employee::all(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Late',
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendance')->with('success', 'Attendance recorded successfully.');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)

    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        return inertia('Attendance/Edit', [
            'attendance' => $attendance->load('employee'),
            'employees' => Employee::all(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'status' => 'required|in:Present,Absent,Late',
        ]);

        $attendance->update($validatedData);

        return redirect()->route('attendance')->with('success', 'Attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance')->with('success', 'Attendance deleted successfully.');
    }
}

    