<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get();

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function markAllRead()
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function markRead($id)
    {
        auth()->user()->notifications()->where('id', $id)->update(['is_read' => true]);

        return back()->with('success', 'Notification marked as read.');
    }
}
