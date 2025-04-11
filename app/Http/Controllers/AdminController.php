<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Pesanan;
use App\Models\ProgressPesanan;
use App\Models\ProgressUpdate;
use App\Models\ProgressTimeline;


class AdminController extends Controller
{

public function index()
{
    $total = Pesanan::count(); // total semua pesanan
    $completed = Pesanan::where('status', 'selesai')->count();
    $pending = Pesanan::where('status', 'menunggu_konfirmasi')->count();
    $rejected = Pesanan::where('status', 'ditolak')->count();

    return view('admin.dashboard', compact('total', 'completed', 'pending', 'rejected'));
}

    public function statusList() {
        $orders = Order::with('customer')->latest()->get();
        return view('admin.orders.status', compact('orders'));
    }

    public function editStatus($id)
{
    $pesanan = Order::findOrFail($id);
    return view('admin.ubah-status', compact('pesanan'));
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string',
        'estimasi' => 'nullable|string|max:255',
        'harga' => 'nullable|numeric|min:0',
        'catatan' => 'nullable|string|max:1000',
    ]);

    $pesanan = Order::findOrFail($id);

    // Simpan data lama untuk membandingkan
    $oldStatus = $pesanan->status;

    // Update status & data terkait
    $pesanan->status = $request->status;

    if ($request->status === 'Menunggu Persetujuan Customer') {
        $pesanan->estimasi = $request->estimasi;
        $pesanan->harga = $request->harga;
    }

    if ($request->filled('catatan')) {
        $pesanan->catatan = $request->catatan;
    }

    $pesanan->save();

    // Simpan ke progress timeline
    ProgressTimeline::create([
        'pesanan_id' => $pesanan->id,
        'status' => $request->status,
        'catatan' => $request->catatan,
    ]);

    return redirect()->route('admin.orders.index')->with('success', 'Status dan riwayat berhasil diperbarui.');
}

    public function rejectOrder($id) {
        $order = Order::findOrFail($id);
        $order->status = 'Ditolak';
        $order->save();

        return back()->with('success', 'Pesanan telah ditolak.');
    }

    public function detail($id) {
        $order = Order::with(['customer', 'progressUpdates'])->findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }

    public function statusBy($status) {
        $orders = Order::where('status', $status)->get();
        return view('admin.orders.status', compact('orders', 'status'));
    }

    public function kelolaPesanan()
{
    $pesanans = Pesanan::all();

    return view('admin.kelola-pesanan', compact('pesanans'));
}

public function allOrders()
{
    $orders = Order::with('customer')->latest()->get();
    return view('admin.orders.total', compact('orders'));
}

// Di Admin\OrderController atau controller yang kamu pakai
public function detailPesanan($id)
{
    $pesanan = Pesanan::with(['customer', 'progressTimeline'])->findOrFail($id);
    return view('admin.orders.detail', compact('pesanan'));
}

public function showPesanan($id)
{
    $pesanan = Pesanan::findOrFail($id);
    return view('admin.pesanan.detail', compact('pesanan'));
}

public function konfirmasiPesanan(Request $request, $id)
{
    $request->validate([
        'harga' => 'required|numeric',
        'estimasi' => 'required|string|max:255',
    ]);

    $pesanan = Pesanan::findOrFail($id);
    $pesanan->harga = $request->harga;
    $pesanan->estimasi = $request->estimasi;
    $pesanan->status = 'Menunggu Persetujuan Customer';
    $pesanan->save();

    return redirect()->route('admin.pesanan.show', $id)->with('success', 'Pesanan berhasil dikonfirmasi.');
}
}
