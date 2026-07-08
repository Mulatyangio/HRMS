<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\LeaveMgt;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $totalEmployees = $employees->count();
        $activeEmployees = $employees->where('status', 'active')->count();
        $onLeaveEmployees = $employees->where('status', 'on_leave')->count();
        $inactiveEmployees = $employees->where('status', 'inactive')->count();

        $departments = Departments::all()->map(function ($dept) {
            $head = Employee::where('department', $dept->name)
                ->where('is_department_head', true)
                ->first();
            return [
                'name' => $dept->name,
                'head_count' => Employee::where('department', $dept->name)->count(),
                'head_name' => $head ? $head->name : 'N/A',
            ];
        });

        $today = now()->toDateString();
        $attendance = [
            'present' => Attendance::where('date', $today)->where('status', 'Present')->count(),
            'absent' => Attendance::where('date', $today)->where('status', 'Absent')->count(),
            'late' => Attendance::where('date', $today)->where('status', 'Late')->count(),
        ];

        $leaves = [
            'pending' => LeaveMgt::where('status', 'pending')->count(),
            'approved' => LeaveMgt::where('status', 'approved')->count(),
            'rejected' => LeaveMgt::where('status', 'rejected')->count(),
        ];

        $payrolls = Payroll::all();
        $totalPayroll = $payrolls->sum('net_salary');
        $payrollCount = $payrolls->count();

        return inertia('Reports/Index', [
            'employees' => [
                'total' => $totalEmployees,
                'active' => $activeEmployees,
                'on_leave' => $onLeaveEmployees,
                'inactive' => $inactiveEmployees,
            ],
            'departments' => $departments,
            'attendance' => $attendance,
            'leaves' => $leaves,
            'payroll' => [
                'total' => $totalPayroll,
                'count' => $payrollCount,
            ],
        ]);
    }

    public function export(Request $request, string $type): StreamedResponse
    {
        $employees = Employee::all();
        $attendance = [
            'present' => Attendance::where('date', now()->toDateString())->where('status', 'Present')->count(),
            'absent' => Attendance::where('date', now()->toDateString())->where('status', 'Absent')->count(),
            'late' => Attendance::where('date', now()->toDateString())->where('status', 'Late')->count(),
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

    private function exportPdf($employees, $attendance): StreamedResponse
    {
        $html = view('reports.export', compact('employees', 'attendance'))->render();

        $response = new StreamedResponse(function () use ($html) {
            echo $html;
        });

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="report.pdf"');

        return $response;
    }
}
