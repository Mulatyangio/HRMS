<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\LeaveMgt;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $department = $request->query('department');
        $status = $request->query('status');

        $employeeQuery = Employee::query();
        if ($department) {
            $employeeQuery->where('department', $department);
        }

        $employees = $employeeQuery->get();
        $totalEmployees = $employees->count();
        $activeEmployees = $employees->where('status', 'active')->count();
        $onLeaveEmployees = $employees->where('status', 'on_leave')->count();
        $inactiveEmployees = $employees->where('status', 'inactive')->count();

        $departments = Departments::query();
        if ($department) {
            $departments->where('name', $department);
        }
        $departments = $departments->get()->map(function ($dept) {
            $head = Employee::where('department', $dept->name)
                ->where('is_department_head', true)
                ->first();
            return [
                'id' => $dept->id,
                'name' => $dept->name,
                'head_count' => Employee::where('department', $dept->name)->count(),
                'manager' => $head ? ['name' => $head->name] : null,
                'employees_count' => Employee::where('department', $dept->name)->count(),
            ];
        });

        $today = now()->toDateString();
        $dateFrom = $from ?: $today;
        $dateTo = $to ?: $today;

        $attendanceQuery = Attendance::whereBetween('date', [$dateFrom, $dateTo]);
        if ($department) {
            $attendanceQuery->whereHas('employee', fn ($q) => $q->where('department', $department));
        }

        $attendance = [
            'present' => (clone $attendanceQuery)->where('status', 'Present')->count(),
            'absent' => (clone $attendanceQuery)->where('status', 'Absent')->count(),
            'late' => (clone $attendanceQuery)->where('status', 'Late')->count(),
        ];

        $attendanceRecordsQuery = Attendance::with('employee')
            ->whereBetween('date', [$dateFrom, $dateTo]);
        if ($department) {
            $attendanceRecordsQuery->whereHas('employee', fn ($q) => $q->where('department', $department));
        }
        if ($status) {
            $attendanceRecordsQuery->where('status', $status);
        }
        $attendanceRecords = $attendanceRecordsQuery->get();

        $leaveRecords = LeaveMgt::with('employee')->get();

        $payrolls = Payroll::with('employee')->get();
        $totalPayroll = $payrolls->sum('net_salary');
        $payrollCount = $payrolls->count();

        $activities = collect()
            ->merge(Employee::latest()->take(3)->get()->map(fn ($e) => [
                'id' => 'emp-' . $e->id,
                'title' => 'Employee Added',
                'description' => "{$e->name} was added as an employee",
                'type' => 'employee',
                'created_at' => $e->created_at->diffForHumans(),
            ]))
            ->merge(Attendance::with('employee')->latest()->take(3)->get()->map(fn ($a) => [
                'id' => 'att-' . $a->id,
                'title' => 'Attendance Recorded',
                'description' => ($a->employee?->name ?? 'Someone') . ' was ' . strtolower($a->status),
                'type' => 'attendance',
                'created_at' => $a->created_at->diffForHumans(),
            ]))
            ->merge(LeaveMgt::with('employee')->latest()->take(3)->get()->map(fn ($l) => [
                'id' => 'lev-' . $l->id,
                'title' => 'Leave ' . ucfirst($l->status),
                'description' => ($l->employee?->name ?? 'Someone') . ' submitted a ' . ($l->type ?? 'leave') . ' request',
                'type' => 'leave',
                'created_at' => $l->created_at->diffForHumans(),
            ]))
            ->merge(Payroll::with('employee')->latest()->take(3)->get()->map(fn ($p) => [
                'id' => 'pay-' . $p->id,
                'title' => 'Payroll Processed',
                'description' => ($p->employee?->name ?? 'Someone') . ' received salary',
                'type' => 'payroll',
                'created_at' => $p->created_at->diffForHumans(),
            ]))
            ->sortByDesc(fn ($a) => $a['created_at'])
            ->values()
            ->take(10);

        return inertia('Reports/Index', [
            'summary' => [
                'employees' => $totalEmployees,
                'departments' => $departments->count(),
                'presentToday' => $attendance['present'],
                'absentToday' => $attendance['absent'],
                'leaveToday' => $onLeaveEmployees,
                'monthlyPayroll' => $totalPayroll,
            ],
            'departments' => $departments,
            'attendance' => $attendance,
            'attendance_records' => $attendanceRecords,
            'leaves' => $leaveRecords,
            'payrolls' => $payrolls,
            'payroll' => [
                'total' => $totalPayroll,
                'count' => $payrollCount,
            ],
            'activities' => $activities,
        ]);
    }

    public function export(Request $request, string $type)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $department = $request->query('department');
        $status = $request->query('status');

        $employeeQuery = Employee::query();
        if ($department) {
            $employeeQuery->where('department', $department);
        }
        $employees = $employeeQuery->get();

        $today = now()->toDateString();
        $dateFrom = $from ?: $today;
        $dateTo = $to ?: $today;

        $attendanceQuery = Attendance::whereBetween('date', [$dateFrom, $dateTo]);
        if ($department) {
            $attendanceQuery->whereHas('employee', fn ($q) => $q->where('department', $department));
        }
        if ($status) {
            $attendanceQuery->where('status', $status);
        }

        $attendance = [
            'present' => (clone $attendanceQuery)->where('status', 'Present')->count(),
            'absent' => (clone $attendanceQuery)->where('status', 'Absent')->count(),
            'late' => (clone $attendanceQuery)->where('status', 'Late')->count(),
        ];

        return match ($type) {
            'csv' => $this->exportCsv($employees, $attendance),
            'excel' => $this->exportExcel($employees, $attendance),
            'pdf' => $this->exportPdf($employees, $attendance),
            default => abort(404),
        };
    }

    private function exportCsv($employees, $attendance): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($employees, $attendance) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Report', 'Value']);
            fputcsv($handle, ['Total Employees', $employees->count()]);
            fputcsv($handle, ['Active Employees', $employees->where('status', 'active')->count()]);
            fputcsv($handle, ['Present Today', $attendance['present']]);
            fputcsv($handle, ['Absent Today', $attendance['absent']]);
            fputcsv($handle, ['Late Today', $attendance['late']]);

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="report.csv"');

        return $response;
    }

    private function exportExcel($employees, $attendance): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($employees, $attendance) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Report', 'Value']);
            fputcsv($handle, ['Total Employees', $employees->count()]);
            fputcsv($handle, ['Active Employees', $employees->where('status', 'active')->count()]);
            fputcsv($handle, ['Present Today', $attendance['present']]);
            fputcsv($handle, ['Absent Today', $attendance['absent']]);
            fputcsv($handle, ['Late Today', $attendance['late']]);

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment; filename="report.xls"');

        return $response;
    }

    private function exportPdf($employees, $attendance)
    {
        $pdf = Pdf::loadView('reports.export', compact('employees', 'attendance'));
        return $pdf->download('report.pdf');
    }
}
