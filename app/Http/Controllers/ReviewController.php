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
        return view('customer.review.create', ['riwayat' => $order]);
    }

    public function store(Request $request, $pesananId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:255',
        ]);
    
        $pesanan = Pesanan::findOrFail($pesananId);
    
        if ($pesanan->user_id !== Auth::id()) {
            return redirect()->route('customer.riwayat')->with('error', 'Anda tidak memiliki izin untuk memberikan ulasan pada pesanan ini.');
        }
    
        // Cek apakah user sudah memberikan review pada pesanan ini
        $existingReview = Review::where('pesanan_id', $pesananId)
                                ->where('user_id', Auth::id())
                                ->first();
    
        if ($existingReview) {
            return redirect()->route('customer.riwayat')->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }
    
        // Simpan ulasan baru
        Review::create([
            'pesanan_id' => $pesananId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->komentar,
        ]);
    
        // Ambil semua pesanan milik user yang sedang login
        $pesanans = Pesanan::where('user_id', Auth::id())->get();
    
        // Kembalikan view dengan semua data yang diperlukan
        return view('customer.pesanan.detail', compact('pesanan', 'pesanans'))->with('success', 'Ulasan berhasil dikirim!');
    }
}
