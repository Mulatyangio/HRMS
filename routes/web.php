<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NotificationController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');


//department routes
Route::get('/departments', [DepartmentController::class, 'index'])
    ->middleware(['auth','verified'])->name('departments');

Route::get('/departments/create', [DepartmentController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('departments.create');

Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])
    ->name('departments.edit');

Route::get('/departments/index', [DepartmentController::class, 'index'])
    ->name('departments.index');

Route::post('/departments', [DepartmentController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('departments.store');

Route::put('/departments/{department}', [DepartmentController::class, 'update'])
    ->name('departments.update');

Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
    ->name('departments.destroy');

//employee routes
Route::get('/employees', [EmployeeController::class, 'index'])
    ->middleware(['auth','verified'])->name('employees');

Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])
    ->name('employees.edit');

Route::get('/employees/create', [EmployeeController::class, 'Create'])
    ->name('employees.create');

Route::post('/employees', [EmployeeController::class, 'store'])
    ->name('employees.store');

Route::put('/employees/{employee}', [EmployeeController::class, 'update'])
    ->name('employees.update');

Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])
    ->name('employees.destroy');

//attendance routes
Route::get('/attendance', [AttendanceController::class, 'index'])
    ->middleware(['auth','verified'])->name('attendance');

Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])
    ->name('attendance.edit');

Route::get('/attendance/create', [AttendanceController::class, 'create'])
    ->name('attendance.create');

Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])
    ->name('attendance.show');

Route::post('/attendance/store', [AttendanceController::class, 'store'])
    ->name('attendance.store');

Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
    ->name('attendance.update');

//leave routes
Route::get('/leaves', [LeaveController::class, 'index'])
    ->middleware(['auth','verified'])->name('leaves');

Route::get('/leaves/{leaveMgt}/edit', [LeaveController::class, 'edit'])
    ->name('leaves.edit');

Route::put('/leaves/{leaveMgt}', [LeaveController::class, 'update'])
    ->name('leaves.update');

Route::patch('/leaves/{leaveMgt}/approve', [LeaveController::class, 'approve'])
    ->name('leaves.approve');

Route::patch('/leaves/{leaveMgt}/reject', [LeaveController::class, 'reject'])
    ->name('leaves.reject');

//payroll routes
Route::get('/payroll', [PayrollController::class, 'index'])
    ->middleware(['auth','verified'])->name('payroll');

Route::get('/payroll/create', [PayrollController::class, 'create'])
    ->middleware(['auth','verified'])->name('payroll.create');

Route::post('/payroll', [PayrollController::class, 'store'])
    ->middleware(['auth','verified'])->name('payroll.store');

Route::get('/payroll/{payroll}/edit', [PayrollController::class, 'edit'])
    ->name('payroll.edit');

Route::put('/payroll/{payroll}', [PayrollController::class, 'update'])
    ->name('payroll.update');

Route::delete('/payroll/{payroll}', [PayrollController::class, 'destroy'])
    ->name('payroll.destroy');

Route::get('/payroll/{payroll}', [PayrollController::class, 'show'])
    ->name('payroll.show');

Route::get('/activities', function () {
    $employees = \App\Models\Employee::latest()->take(5)->get()->map(fn ($e) => [
        'id' => $e->id,
        'user' => $e->name,
        'action' => 'was added as an employee',
        'type' => 'employee',
        'time' => $e->created_at->diffForHumans(),
        'created_at' => $e->created_at,
    ]);

    $attendance = \App\Models\Attendance::with('employee')->latest()->take(5)->get()->map(fn ($a) => [
        'id' => 'att-' . $a->id,
        'user' => $a->employee?->name ?? 'Unknown',
        'action' => $a->status === 'Present' ? 'clocked in' : ($a->status === 'Late' ? 'clocked in late' : 'was marked absent'),
        'type' => 'attendance',
        'time' => $a->created_at->diffForHumans(),
        'created_at' => $a->created_at,
    ]);

    $leaves = \App\Models\LeaveMgt::with('employee')->latest()->take(5)->get()->map(fn ($l) => [
        'id' => 'leave-' . $l->id,
        'user' => $l->employee?->name ?? 'Unknown',
        'action' => $l->status === 'pending' ? 'submitted a leave request' : ($l->status === 'approved' ? 'had leave approved' : 'had leave rejected'),
        'type' => 'leave',
        'time' => $l->created_at->diffForHumans(),
        'created_at' => $l->created_at,
    ]);

    $payrolls = \App\Models\Payroll::with('employee')->latest()->take(5)->get()->map(fn ($p) => [
        'id' => 'pay-' . $p->id,
        'user' => $p->employee?->name ?? 'Unknown',
        'action' => 'received payroll for ' . ($p->payroll_month ?? 'this month'),
        'type' => 'payroll',
        'time' => $p->created_at->diffForHumans(),
        'created_at' => $p->created_at,
    ]);

    $activities = collect([...$employees, ...$attendance, ...$leaves, ...$payrolls])
        ->sortByDesc('created_at')
        ->values()
        ->take(20);

    return Inertia::render('Activities/Index', [
        'activities' => $activities,
    ]);
})->middleware(['auth', 'verified'])->name('activities.index');

//Report routes
Route::get('/reports', [ReportController::class, 'index'])
    ->middleware(['auth','verified'])->name('reports');
Route::get('/reports/export/{type}', [ReportController::class, 'export'])
    ->middleware(['auth','verified'])->name('reports.export');


//notification routes
Route::get('/notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('notifications.index');

Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])
    ->middleware(['auth', 'verified'])->name('notifications.markRead');

Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])
    ->middleware(['auth', 'verified'])->name('notifications.markAllRead');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';