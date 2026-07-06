<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Reports/Index', [
            'reports' => Report::with('employee')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Reports/Create', [
            'employees' => \App\Models\Employee::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        Report::create($request->validated());
        return redirect()->route('reports')->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return inertia('Reports/Show', [
            'report' => $report->load('employee'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        return inertia('Reports/Edit', [
            'report' => $report->load('employee'),
            'employees' => \App\Models\Employee::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        $report->update($request->validated());
        return redirect()->route('reports')->with('success', 'Report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports')->with('success', 'Report deleted successfully.');
    }
}
