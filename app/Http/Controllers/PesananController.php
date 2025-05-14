<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;


class PesananController extends Controller
{
    public function create()
    {
        return view('customer.pesanan.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'telepon' => 'required|string|max:20',
        'jenis_barang' => 'required|string|max:100',
        'keluhan' => 'nullable|string',
    ]);

    // Buat pesanan baru
    $pesanan = Pesanan::create([
        'user_id' => Auth::id(),
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'telepon' => $request->telepon,
        'jenis_barang' => $request->jenis_barang,
        'keluhan' => $request->keluhan,
        'tanggal_pemesanan' => now(),
        'status' => 'Menunggu Konfirmasi Admin',
        'harga' => null,
        'estimasi' => null,
    ]);

    // Notifikasi
    Notification::create([
        'user_id' => Auth::id(),
        'title' => 'Pesanan Baru Dibuat',
        'message' => 'Pesanan Anda untuk ' . $pesanan->jenis_barang . ' telah berhasil dibuat dan sedang menunggu konfirmasi admin.',
    ]);

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Buat Snap Token
    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $pesanan->id . '-' . time(),
            'gross_amount' => 100000, // misal default dulu (bisa disesuaikan kemudian)
        ],
        'customer_details' => [
            'first_name' => $request->nama,
            'phone' => $request->telepon,
            'address' => $request->alamat,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    return view('customer.pesanan.detail', compact('pesanan', 'snapToken'));
}


    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->input('status');
        $pesanan->save();

        // Tambahkan notifikasi ke admin dengan target_role = 'admin'
        \App\Models\Notification::create([
            'user_id'   => $pesanan->user_id, // pastikan relasi ini ada di model
            'title'     => 'Status Pesanan Diperbarui',
            'message'   => 'Status pesanan Anda telah diubah menjadi: ' . $pesanan->status,
            'target_role' => 'customer', // Target role admin
            'is_read'   => false, // Notifikasi belum dibaca
        ]);

        return redirect()->route('admin.orders')->with('success', 'Status updated successfully');
    }


    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        return view('customer.pesanan.detail', compact('pesanan'));
    }
}
