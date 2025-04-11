<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StatusPesananNotification;

class PesananController extends Controller
{
    // Tampilkan form create pesanan
    public function create()
    {
        return view('customer.pesanan.create'); // Pastikan view ini tersedia
    }

    // Simpan pesanan baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required',
        'kontak' => 'required',
        'perangkat' => 'required',
        'kerusakan' => 'required',
        'metode_pembayaran' => 'required',
    ]);

    $pesanan = new Pesanan();
    $pesanan->nama = $request->nama;
    $pesanan->kontak = $request->kontak;
    $pesanan->perangkat = $request->perangkat;
    $pesanan->kerusakan = $request->kerusakan;
    $pesanan->catatan = $request->catatan;
    $pesanan->metode_pembayaran = $request->metode_pembayaran;
    $pesanan->status_pesanan = 'Menunggu Konfirmasi Admin';
    $pesanan->status_pembayaran = 'Belum Dibayar';
    $pesanan->total_biaya = 0;
    $pesanan->tanggal_pesanan = now();

    $pesanan->save();

    return redirect()->route('customer.riwayat')->with('success', 'Pesanan berhasil dikirim!');
}

    // Update status pesanan & kirim notifikasi
    public function updateStatus(Request $request, $id)
    {
        // Cari pesanan yang mau diupdate
        $pesanan = Pesanan::findOrFail($id);

        // Update status
        $pesanan->status = $request->status;
        $pesanan->save();

        // Kirim notifikasi ke customer
        Notification::create([
            'user_id' => $pesanan->user_id,
            'message' => 'Status servis Anda telah diperbarui menjadi: ' . $request->status,
        ]);

        return redirect()->back()->with('success', 'Status dan notifikasi berhasil diperbarui.');
    }
}
