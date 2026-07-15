<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeAttendanceController extends Controller
{
    public function index(): Response
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $attendances = $employee->attendances()->latest('date')->get();

        $todayRecord = $employee->attendances()
            ->whereDate('date', now()->toDateString())
            ->first();

        return Inertia::render('Employee/MyAttendance', [
            'attendances' => $attendances,
            'todayRecord' => $todayRecord,
            'employee' => $employee,
        ]);
    }

    public function clockIn(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $todayRecord = $employee->attendances()
            ->whereDate('date', now()->toDateString())
            ->first();

        if ($todayRecord && $todayRecord->check_in) {
            return back()->withErrors(['clock' => 'You have already clocked in today.']);
        }

        $now = now();
        $checkInTime = $now->format('H:i:s');
        $hour = (int) $now->format('H');
        $status = ($hour >= 9) ? 'Late' : 'Present';

        if ($todayRecord) {
            $todayRecord->update([
                'check_in' => $checkInTime,
                'status' => $status,
            ]);
        } else {
            $employee->attendances()->create([
                'date' => $now->toDateString(),
                'check_in' => $checkInTime,
                'status' => $status,
            ]);
        }

        return back()->with('success', 'Clocked in successfully at ' . $now->format('h:i A') . '.');
    }

    public function clockOut(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();

        $todayRecord = $employee->attendances()
            ->whereDate('date', now()->toDateString())
            ->first();

        if (!$todayRecord || !$todayRecord->check_in) {
            return back()->withErrors(['clock' => 'You have not clocked in today.']);
        }

        if ($todayRecord->check_out) {
            return back()->withErrors(['clock' => 'You have already clocked out today.']);
        }

        $todayRecord->update([
            'check_out' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Clocked out successfully at ' . now()->format('h:i A') . '.');
    }
}
