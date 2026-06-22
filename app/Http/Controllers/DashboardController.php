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

        $upcomingBirthdays = Employee::whereRaw(
            "strftime('%m-%d', date_of_birth) >= strftime('%m-%d', 'now')"
        )
            ->orderByRaw("strftime('%m-%d', date_of_birth)")
            ->take(3)
            ->get()
            ->map(fn ($employee) => [
                'name' => $employee->name,
                'date' => $employee->date_of_birth->format('M d'),
                'department' => $employee->department,
            ]);

        if ($upcomingBirthdays->count() < 3) {
            $excludeIds = $upcomingBirthdays->pluck('name');

            $fallback = Employee::whereNotIn('name', $excludeIds)
                ->orderByRaw("strftime('%m-%d', date_of_birth)")
                ->take(3 - $upcomingBirthdays->count())
                ->get()
                ->map(fn ($employee) => [
                    'name' => $employee->name,
                    'date' => $employee->date_of_birth->format('M d'),
                    'department' => $employee->department,
                ]);

            $upcomingBirthdays = $upcomingBirthdays->concat($fallback);
        }


        
        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'departments' => $departments,
            'recentActivities' => $recentActivities,
            'upcomingBirthdays' => $upcomingBirthdays,
        ]);
    }
}
