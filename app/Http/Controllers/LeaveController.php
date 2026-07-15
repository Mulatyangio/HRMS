<?php

namespace App\Http\Controllers;

use App\Models\LeaveMgt;

class LeaveController extends Controller
{
    public function index()
    {
        return inertia('Leave/Index', [
            'leaves' => LeaveMgt::with('employee')->latest()->get(),
        ]);
    }

    public function approve(LeaveMgt $leaveMgt)
    {
        $leaveMgt->update(['status' => 'approved']);

        $employee = $leaveMgt->employee;
        \App\Models\Notification::create([
            'type' => 'leave_approved',
            'title' => 'Leave Approved',
            'message' => ($employee->name ?? 'An employee') . '\'s leave request has been approved.',
        ]);

        return redirect()->route('leaves')->with('success', 'Leave approved.');
    }

    public function reject(LeaveMgt $leaveMgt)
    {
        $leaveMgt->update(['status' => 'rejected']);

        $employee = $leaveMgt->employee;
        \App\Models\Notification::create([
            'type' => 'leave_rejected',
            'title' => 'Leave Rejected',
            'message' => ($employee->name ?? 'An employee') . '\'s leave request has been rejected.',
        ]);

        return redirect()->route('leaves')->with('success', 'Leave rejected.');
    }
}
