<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Payment;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    // 1. Buat transaksi dan Snap Token
    public function createTransaction(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
        ]);

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        $orderId = 'ORDER-' . uniqid();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $pesanan->harga,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama ?? 'Customer',
                'phone' => $pesanan->telepon ?? '08123456789',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        Payment::create([
            'pesanan_id' => $pesanan->id,
            'order_id' => $orderId,
        ]);

        return response()->json(['snap_token' => $snapToken]);
    }

    // 2. Callback dari Midtrans
    public function callback(Request $request)
    {
        $notif = new Notification();

        $orderId = $notif->order_id ?? null;
        if (!$orderId) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $payment = Payment::where('order_id', $orderId)->first();
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $vaNumber = null;
        if (isset($notif->va_numbers[0]->va_number)) {
            $vaNumber = $notif->va_numbers[0]->va_number;
        } elseif (isset($notif->permata_va_number)) {
            $vaNumber = $notif->permata_va_number;
        }

        $payment->update([
            'transaction_id'      => $notif->transaction_id ?? null,
            'payment_type'        => $notif->payment_type ?? null,
            'gross_amount'        => $notif->gross_amount ?? null,
            'transaction_status'  => $notif->transaction_status ?? null,
            'fraud_status'        => $notif->fraud_status ?? null,
            'va_number'           => $vaNumber,
            'pdf_url'             => $notif->pdf_url ?? null,
            'payment_code'        => $notif->payment_code ?? null,
        ]);

        return response()->json(['message' => 'Payment updated successfully']);
    }

    public function store(Request $request)
{
    // Membuat pesanan baru
    $pesanan = new Pesanan();
    $pesanan->nama = $request->nama;
    $pesanan->alamat = $request->alamat;
    $pesanan->telepon = $request->telepon;
    $pesanan->jenis_barang = $request->jenis_barang;
    $pesanan->tanggal_pemesanan = $request->tanggal_pemesanan;
    $pesanan->keluhan = $request->keluhan;
    $pesanan->save();

    // Menghasilkan Snap token
    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . time(),
            'gross_amount' => $pesanan->harga,
        ],
        'customer_details' => [
            'first_name' => $pesanan->nama,
            'phone' => $pesanan->telepon,
        ],
    ];
    $snapToken = \Midtrans\Snap::getSnapToken($params);

    // Mengirimkan snapToken ke tampilan
    return view('customer.pesanan.create', compact('snapToken'));
}

}
