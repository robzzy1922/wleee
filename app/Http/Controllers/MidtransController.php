<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function create(Request $request)
    {
        // Validasi pesanan_id
        $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
        ]);

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        // Set Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = 'ORDER-' . $pesanan->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $pesanan->harga,
            ],
            'customer_details' => [
                'first_name' => $pesanan->nama,
                'email' => $pesanan->email ?? (Auth::check() ? Auth::user()->email : null),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal mendapatkan token pembayaran. Silakan coba lagi.');
        }

        // Simpan order_id midtrans ke pesanan
        $pesanan->midtrans_order_id = $orderId;
        $pesanan->midtrans_snap_token = $snapToken;
        $pesanan->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'snapToken' => $snapToken,
                'pesanan_id' => $pesanan->id,
            ]);
        }

        return view('Customer.pesanan.bayar', compact('snapToken', 'pesanan'));
    }

    // Callback untuk notifikasi Midtrans
    public function callback(Request $request)
    {
        try {
            $notif = new \Midtrans\Notification();
            $order = Pesanan::where('midtrans_order_id', $notif->order_id)->first();

            if ($order) {
                if (in_array($notif->transaction_status, ['settlement', 'capture'])) {
                    $order->payment_status = 'lunas';
                } elseif ($notif->transaction_status == 'pending') {
                    $order->payment_status = 'pending';
                } else {
                    $order->payment_status = 'belum bayar';
                }
                $order->save();
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Callback error'], 500);
        }

        return response()->json(['status' => 'ok']);
    }
}