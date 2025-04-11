<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function dashboard()
    {
        $orders = Order::where('customer_id', Auth::id())->get();
        return view('customer.dashboard', compact('orders'));
    }

    public function create()
    {
        return view('customer.order');
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_type' => 'required|string',
            'description' => 'required|string',
            'contact' => 'required|string',
        ]);

        Order::create([
            'customer_id' => Auth::id(),
            'device_type' => $request->device_type,
            'description' => $request->description,
            'contact' => $request->contact,
            'status' => 'Menunggu Konfirmasi Admin',
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Pesanan berhasil dikirim!');
    }

public function customerDashboard()
{
    $notifications = Notification::where('user_id', auth()->id())->latest()->take(10)->get();
    $pesanan = Pesanan::where('user_id', auth()->id())->latest()->get();

    return view('customer.dashboard', compact('notifications', 'pesanan'));
}

public function updateStatus(Request $request, $id)
{
    $pesanan = Order::findOrFail($id);

    $pesanan->status = $request->status;

    // Jika status Menunggu Persetujuan Customer, simpan estimasi & harga
    if ($request->status === 'Menunggu Persetujuan Customer') {
        $pesanan->estimasi = $request->estimasi;
        $pesanan->harga = $request->harga;
    }

    // Simpan catatan jika ada
    if ($request->filled('catatan')) {
        $pesanan->catatan = $request->catatan;
    }

    $pesanan->save();

    return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
}

public function show($id)
{
    $pesanan = Pesanan::with('progressTimeline')->findOrFail($id);

    return view('Admin.orders.detail', compact('pesanan'));
}

public function status($status)
{
    if ($status === 'all') {
        $orders = Order::with('customer')->get();
    } else {
        $orders = Order::with('customer')->where('status', $status)->get();
    }

    return view('admin.orders.status', compact('orders', 'status'));
}
}
