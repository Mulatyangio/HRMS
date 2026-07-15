<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveMgt;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeDashboardController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();

        if (!$employee) {
            return Inertia::render('Employee/NoProfile');
        }

        $recentAttendance = $employee->attendances()
            ->latest('date')
            ->take(5)
            ->get();

        $recentLeaves = $employee->leaveManagements()
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_leaves' => $employee->leaveManagements()->count(),
            'pending_leaves' => $employee->leaveManagements()->where('status', 'pending')->count(),
            'approved_leaves' => $employee->leaveManagements()->where('status', 'approved')->count(),
            'days_present_this_month' => $employee->attendances()
                ->whereMonth('date', now()->month)
                ->whereIn('status', ['Present', 'Late'])
                ->count(),
        ];

        return Inertia::render('Employee/Dashboard', [
            'employee' => $employee,
            'recentAttendance' => $recentAttendance,
            'recentLeaves' => $recentLeaves,
            'stats' => $stats,
        ]);
    }
}
