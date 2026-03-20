<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index() {
        $notifications = Notification::with('visa')->latest()->get();
        return view('notifications.index', compact('notifications'));
    }
}