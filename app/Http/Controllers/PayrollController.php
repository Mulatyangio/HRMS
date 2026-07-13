<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Http\Requests\StorePayrollRequest;
use App\Http\Requests\UpdatePayrollRequest;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        return inertia('Payroll/Index', [
            'payrolls' => Payroll::with('employee')->latest()->get(),
        ]);
    }

    public function create()
    {
        return inertia('Payroll/Create', [
            'employees' => \App\Models\Employee::all(),
        ]);
    }

    public function store(StorePayrollRequest $request)
    {
        $payroll = Payroll::create($request->validated());
        $employee = $payroll->employee;

        \App\Models\Notification::create([
            'type' => 'payroll_processed',
            'title' => 'Payroll Processed',
            'message' => 'Payroll for ' . ($employee->name ?? 'employee') . ' has been processed for ' . $payroll->month . '.',
        ]);

        return redirect()->route('payroll')->with('success', 'Payroll created successfully.');
    }

    public function show(Payroll $payroll)
    {
        return inertia('Payroll/Show', [
            'payroll' => $payroll->load('employee'),
        ]);
    }

    public function edit(Payroll $payroll)
    {
        return inertia('Payroll/Edit', [
            'payroll' => $payroll->load('employee'),
            'employees' => \App\Models\Employee::all(),
        ]);
    }

    public function update(UpdatePayrollRequest $request, Payroll $payroll)
    {
        $payroll->update($request->validated());
        return redirect()->route('payroll')->with('success', 'Payroll updated successfully.');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payroll')->with('success', 'Payroll deleted successfully.');
    }
}
