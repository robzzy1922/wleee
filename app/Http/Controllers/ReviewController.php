<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($orderId)
{
    $order = Order::findOrFail($orderId);
    return view('customer.riwayat', ['riwayat' => $orders]);
}

public function store(Request $request, $orderId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required|string|max:255',
    ]);

    Review::create([
        'order_id' => $orderId,
        'customer_id' => auth()->id(),
        'rating' => $request->rating,
        'komentar' => $request->komentar,
    ]);

    return redirect()->route('customer.riwayat')->with('success', 'Ulasan berhasil dikirim!');
}
}
