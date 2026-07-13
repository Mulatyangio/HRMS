<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $notifications = Notification::latest()
            ->take(20)
            ->get(['id', 'type', 'title', 'message', 'is_read', 'created_at']);

        $unreadCount = Notification::unread()->count();

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
