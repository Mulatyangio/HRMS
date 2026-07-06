<?php

namespace App\Http\Controllers;

use App\Models\LeaveMgt;
use App\Http\Requests\UpdateLeaveMgtRequest;

class LeaveController extends Controller
{
    public function index()
    {
        return inertia('Leave/Index', [
            'leaves' => LeaveMgt::with('employee')->latest()->get(),
        ]);
    }

    public function edit(LeaveMgt $leaveMgt)
    {
        return inertia('Leave/Edit', [
            'leave' => $leaveMgt->load('employee'),
        ]);
    }

    public function update(UpdateLeaveMgtRequest $request, LeaveMgt $leaveMgt)
    {
        $leaveMgt->update($request->validated());
        return redirect()->route('leaves')->with('success', 'Leave updated successfully.');
    }

    public function approve(LeaveMgt $leaveMgt)
    {
        $leaveMgt->update(['status' => 'approved']);
        return redirect()->route('leaves')->with('success', 'Leave approved.');
    }

    public function reject(LeaveMgt $leaveMgt)
    {
        $leaveMgt->update(['status' => 'rejected']);
        return redirect()->route('leaves')->with('success', 'Leave rejected.');
    }
}
