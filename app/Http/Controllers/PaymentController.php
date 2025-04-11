<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'metode_pembayaran' => 'required|string',
            'total_bayar' => 'required|numeric',
        ]);

        // Simpan data pembayaran
        $payment = Payment::create([
            'pesanan_id' => $request->pesanan_id,
            'user_id' => Auth::id(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_bayar' => $request->total_bayar,
            'status_pembayaran' => 'Lunas',
            'tanggal_pembayaran' => now(),
        ]);

        // Update status pesanan
        $pesanan = Pesanan::find($request->pesanan_id);
        $pesanan->status = 'Dalam Proses Servis';
        $pesanan->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil!');
    }
}
