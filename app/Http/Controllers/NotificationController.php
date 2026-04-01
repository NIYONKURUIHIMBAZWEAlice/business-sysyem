<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $business = Auth::user()->businesses()->first();
        $notifications = BusinessNotification::where('business_id', $business->id)
            ->latest()
            ->get();

        // Mark all as read
        BusinessNotification::where('business_id', $business->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }

    public function destroy($id)
    {
        $notification = BusinessNotification::findOrFail($id);
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Notification deleted!');
    }

    public function destroyAll()
    {
        $business = Auth::user()->businesses()->first();
        BusinessNotification::where('business_id', $business->id)->delete();
        return redirect()->route('notifications.index')->with('success', 'All notifications cleared!');
    }
}