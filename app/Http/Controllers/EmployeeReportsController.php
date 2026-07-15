<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeReportsController extends Controller
{
    public function index(): Response
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $attendances = $employee->attendances()->latest('date')->get();
        $leaves = $employee->leaveManagements()->latest()->get();

        $stats = [
            'total_present' => $employee->attendances()->whereIn('status', ['Present', 'Late'])->count(),
            'total_late' => $employee->attendances()->where('status', 'Late')->count(),
            'total_approved_leaves' => $employee->leaveManagements()->where('status', 'approved')->count(),
            'pending_leaves' => $employee->leaveManagements()->where('status', 'pending')->count(),
        ];

        return Inertia::render('Employee/Reports', [
            'employee' => $employee,
            'attendances' => $attendances,
            'leaves' => $leaves,
            'stats' => $stats,
        ]);
    }
}
