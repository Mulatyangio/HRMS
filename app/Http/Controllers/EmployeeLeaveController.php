<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveMgt;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeLeaveController extends Controller
{
    public function index(): Response
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $leaves = $employee->leaveManagements()->latest()->get();

        return Inertia::render('Employee/LeaveRequests', [
            'leaves' => $leaves,
            'employee' => $employee,
        ]);
    }

    public function store(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $validatedData = $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $employee->leaveManagements()->create($validatedData);

        Notification::create([
            'type' => 'leave_requested',
            'title' => 'Leave Requested',
            'message' => $employee->name . ' has requested ' . $validatedData['type'] . ' leave from ' . $validatedData['start_date'] . ' to ' . $validatedData['end_date'] . '.',
        ]);

        return redirect()->route('employee.leaves')->with('success', 'Leave request submitted successfully.');
    }

    public function edit(LeaveMgt $leaveMgt)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        if ($leaveMgt->employee_id !== $employee->id || $leaveMgt->status !== 'pending') {
            abort(403);
        }

        return Inertia::render('Employee/EditLeave', [
            'leave' => $leaveMgt,
        ]);
    }

    public function update(Request $request, LeaveMgt $leaveMgt)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        if ($leaveMgt->employee_id !== $employee->id || $leaveMgt->status !== 'pending') {
            abort(403);
        }

        $validatedData = $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $leaveMgt->update($validatedData);

        return redirect()->route('employee.leaves')->with('success', 'Leave request updated successfully.');
    }

    public function destroy(LeaveMgt $leaveMgt)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        if ($leaveMgt->employee_id !== $employee->id || $leaveMgt->status !== 'pending') {
            abort(403);
        }

        $leaveMgt->delete();

        return redirect()->route('employee.leaves')->with('success', 'Leave request cancelled.');
    }
}
