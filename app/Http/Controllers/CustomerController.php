<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Show form to create a new pesanan
     */
    public function createPesanan()
    {
        return view('customer.pesanan.create');
    }

    /**
     * Store a new pesanan into database
     */
    public function storePesanan(Request $request)
    {
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:20',
            'jenis_barang'  => 'required|string|max:100',
            'keluhan'       => 'nullable|string',
        ]);

        $data['user_id']            = Auth::id();
        $data['customer_id']        = Auth::id(); // Ensure customer_id is set
        $data['tanggal_pemesanan']  = now();
        $data['status']             = 'Menunggu Konfirmasi Admin';
        $data['harga']              = null;
        $data['estimasi']           = null;

        $pesanan = Pesanan::create($data);

        return redirect()->route('customer.pesanan.detail', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * List all pesanan for tracking
     */
    public function tracking()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())
            ->with('progress')
            ->latest()
            ->get();

        return view('customer.tracking', compact('pesanans'));
    }

    /**
     * Show payment history
     */
    public function pembayaran()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with('pesanan')
            ->latest()
            ->get();

        return view('customer.pembayaran', compact('payments'));
    }

    /**
     * Show order history (riwayat pesanan) including reviews
     */

    /**
     * Show detail of a specific pesanan
     */
    public function detailPesanan($id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
            ->with(['payment', 'progress', 'review'])
            ->findOrFail($id);

        return view('customer.pesanan.detail', compact('pesanan'));
    }

    /**
     * Store or update a review for a pesanan
     */
    public function storeReview(Request $request)
    {
        $data = $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string',
        ]);

        Review::updateOrCreate(
            [
                'user_id'    => Auth::id(),
                'pesanan_id' => $data['pesanan_id'],
            ],
            [
                'rating'  => $data['rating'],
                'comment' => $data['comment'] ?? ''
            ]
        );

        return back()->with('success', 'Ulasan berhasil dikirim!');
    }

    // app/Http/Controllers/CustomerController.php

    public function pesananDetail($id)
    {
        // Ambil pesanan spesifik berdasarkan ID dan user yang sedang login
        $pesanan = Pesanan::where('user_id', Auth::id())
            ->with(['payment', 'progress', 'review'])
            ->findOrFail($id);
    
        // Ambil semua pesanan milik user yang sedang login
        $pesanans = Pesanan::where('user_id', Auth::id())->get();
    
        // Kirim data ke view
        return view('Customer.pesanan.detail', compact('pesanan', 'pesanans'));
    }
    // di CustomerController.php
    public function pesananIndex()
    {
        $pesanans = Pesanan::where('customer_id', Auth::id())
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('customer.pesanan.index', compact('pesanans'));
    }

    public function riwayat()
    {
        // ambil data pesanan riwayat
        $pesanans = Pesanan::where('customer_id', auth()->id())
            ->whereIn('status', ['Selesai', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.riwayat', compact('pesanans'));
    }
    public function index()
    {
        $customers = Customer::all();  // Sekarang bisa pake Customer
        return view('admin.customers.index', compact('customers'));
    }
}
