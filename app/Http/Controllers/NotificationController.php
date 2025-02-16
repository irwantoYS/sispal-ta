<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User; // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Notification $notification)
    {
        if ($notification->notifiable_id == Auth::user()->id)
        {
            $notification->update(['read_at' => now()]);
            return response()->json(['success' => true]); // Kembalikan JSON, karena ini AJAX request
        }

        return response()->json(['success' => false], 403); // Kembalikan JSON dengan status 403
    }

    public function unreadCount()
    {
        if (Auth::check()) { // Cek apakah user sudah login
            $count = Auth::user()->unreadNotifications()->count();
            return response()->json(['count' => $count]);
        } else {
            return response()->json(['count' => 0]); // Atau response lain jika user belum login
        }
    }
}