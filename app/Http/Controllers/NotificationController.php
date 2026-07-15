<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Notification::latest()->take(20);

        if ($request->user()->role !== 'admin') {
            $employeeTypes = ['leave_approved', 'leave_rejected', 'leave_requested', 'payroll_processed'];
            $query->whereIn('type', $employeeTypes);
        }

        $notifications = $query->get(['id', 'type', 'title', 'message', 'is_read', 'created_at']);

        $unreadQuery = Notification::unread();
        if ($request->user()->role !== 'admin') {
            $employeeTypes = ['leave_approved', 'leave_rejected', 'leave_requested', 'payroll_processed'];
            $unreadQuery->whereIn('type', $employeeTypes);
        }
        $unreadCount = $unreadQuery->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markRead(Notification $notification): JsonResponse
    {
        $notification->update(['is_read' => true]);

        $unreadCount = Notification::unread()->count();

        return response()->json([
            'unread_count' => $unreadCount,
        ]);
    }

    public function markAllRead(): JsonResponse
    {
        Notification::unread()->update(['is_read' => true]);

        return response()->json([
            'unread_count' => 0,
        ]);
    }
}
