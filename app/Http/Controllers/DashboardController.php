<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::active()->count();
        $onLeave = Employee::onLeave()->count();

        $stats = [
            ['label' => 'Total Employees', 'value' => (string) $totalEmployees, 'change' => '+0', 'changeType' => 'neutral', 'icon' => 'users'],
            ['label' => 'Present Today', 'value' => (string) $activeEmployees, 'change' => number_format($activeEmployees / max($totalEmployees, 1) * 100, 1) . '%', 'changeType' => 'neutral', 'icon' => 'check'],
            ['label' => 'On Leave', 'value' => (string) $onLeave, 'change' => '+0', 'changeType' => 'neutral', 'icon' => 'calendar'],
            ['label' => 'Open Positions', 'value' => '12', 'change' => '-2', 'changeType' => 'decrease', 'icon' => 'briefcase'],
        ];

        $departmentHeads = Employee::where('is_department_head', true)
            ->get()
            ->keyBy('department');

        $departments = Employee::select('department', DB::raw('count(*) as employees'))
            ->groupBy('department')
            ->orderByDesc('employees')
            ->get()
            ->map(function ($item) use ($departmentHeads) {
                return [
                    'name' => $item->department,
                    'head' => $departmentHeads->get($item->department)?->name ?? 'TBD',
                    'employees' => $item->employees,
                ];
            });

        $recentActivities = Employee::latest('updated_at')
            ->take(6)
            ->get()
            ->map(fn ($employee) => [
                'user' => $employee->name,
                'action' => 'updated their profile',
                'time' => $employee->updated_at->diffForHumans(),
            ]);

        
        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'departments' => $departments,
            'recentActivities' => $recentActivities,
        ]);
    }
}
