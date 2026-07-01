<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
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

//employee routes
Route::get('/employees', [EmployeeController::class, 'index'])
    ->middleware(['auth','verified'])->name('employees');

Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])
    ->name('employees.edit');

Route::get('/employees/create', [EmployeeController::class, 'Create'])
    ->name('employees.create');

Route::post('/employees', [EmployeeController::class, 'store'])
    ->name('employees.store');

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
    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';