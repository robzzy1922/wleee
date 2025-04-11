<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Order;

class CustomerController extends Controller
{
    public function tracking()
{
    $pesanans = Pesanan::where('user_id', auth()->id())->latest()->get();

    return view('customer.tracking', compact('pesanans'));
}

    public function pembayaran()
{
    $payments = Payment::where('user_id', auth()->id())->with('pesanan')->latest()->get();

    return view('customer.pembayaran', compact('payments'));
}

public function riwayat()
{
    $riwayat = Order::with('review')->where('customer_id', auth()->id())->get();
    return view('customer.riwayat', compact('riwayat'));
}

public function ulasan()
{
    $pesanan_selesai = Pesanan::where('user_id', auth()->id())
                        ->where('status', 'Selesai')
                        ->with('review')
                        ->get();

    return view('customer.ulasan', compact('pesanan_selesai'));
}

public function storeReview(Request $request)
{
    $request->validate([
        'pesanan_id' => 'required|exists:pesanans,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    Review::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'pesanan_id' => $request->pesanan_id
        ],
        [
            'rating' => $request->rating,
            'comment' => $request->comment
        ]
    );

    return back()->with('success', 'Ulasan berhasil dikirim!');
}
}
