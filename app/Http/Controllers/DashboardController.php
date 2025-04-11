<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

public function customerDashboard()
{
    $notifications = Notification::where('user_id', auth()->id())->latest()->take(10)->get();
    $pesanan = Pesanan::where('user_id', auth()->id())->latest()->get();

    return view('customer.dashboard', compact('notifications', 'pesanan'));
}
}
