<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Pesanan;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        // Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

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

        $userId = Auth::id();

        $data['user_id']            = $userId;
        $data['customer_id']        = $userId; // pastikan kolom ini memang ada di tabel
        $data['tanggal_pemesanan']  = now();
        $data['status']             = 'Menunggu Konfirmasi Admin';
        $data['harga']              = null;
        $data['estimasi']           = null;

        $pesanan = Pesanan::create($data);

        // Buat notifikasi
        \App\Models\Notification::create([
            'user_id'      => $userId,
            'title'        => 'Pesanan Berhasil Dibuat',
            'message'      => 'Pesanan untuk ' . $pesanan->jenis_barang . ' telah berhasil dibuat dan menunggu konfirmasi admin.',
            'is_read'      => false,
            'target_role'  => 'admin',
        ]);

        return redirect()->route('customer.pesanan.index', $pesanan->id)
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

        $snapToken = null;

        if ($pesanan->status === 'Selesai' && !$pesanan->payment) {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $orderId = 'ORDER-' . $pesanan->id . '-' . time();

            $transaction_details = [
                'order_id' => $orderId,
                'gross_amount' => (int)$pesanan->harga,
            ];

            $customer_details = [
                'first_name' => $pesanan->nama,
                'email' => Auth::user()->email,
                'phone' => $pesanan->telepon,
                'address' => $pesanan->alamat,
            ];

            $transaction_data = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];

            try {
                $snapToken = Snap::getSnapToken($transaction_data);

                // Update pesanan with snap token
                $pesanan->update([
                    'midtrans_snap_token' => $snapToken
                ]);

            } catch (\Exception $e) {
                Log::error('Midtrans Error: ' . $e->getMessage());
                return back()->with('error', 'Terjadi kesalahan dalam memproses pembayaran.');
            }
        }

        return view('customer.pesanan.detail', compact('pesanan', 'snapToken'));
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
            ->with(['user', 'payment']) // eager load relations if needed
            ->orderBy('created_at', 'desc')
            ->paginate(10); // add pagination for better performance

        return view('customer.pesanan.index', compact('pesanans'));
    }

    public function riwayat()
    {
        $pesanans = Pesanan::where('customer_id', Auth::id())
            ->whereIn('status', ['Selesai', 'Dibatalkan', 'Ditolak'])
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
