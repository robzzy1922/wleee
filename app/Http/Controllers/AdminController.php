<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Pesanan;
use App\Models\ProgressPesanan;
use App\Models\ProgressUpdate;
use App\Models\ProgressTimeline;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function index()
    {
        $total = Pesanan::count(); // total semua pesanan
        $completed = Pesanan::where('status', 'Selesai')->count();
        $pending = Pesanan::where('status', 'Menunggu Konfirmasi Admin')->count();
        $rejected = Pesanan::where('status', 'Ditolak')->count();

        return view('admin.dashboard', compact('total', 'completed', 'pending', 'rejected'));
    }

    public function statusList()
    {
        $orders = Order::with('customer')->latest()->get();
        return view('admin.orders.status', compact('orders'));
    }

    public function editStatus($id)
    {
        $pesanan = Order::findOrFail($id);
        return view('admin.ubah-status', compact('pesanan'));
    }

    public function editProfile()
    {
        return view('admin.edit-profile');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'estimasi' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $pesanan = Order::findOrFail($id);

        // Simpan data lama untuk membandingkan
        $oldStatus = $pesanan->status;

        // Update status & data terkait
        $pesanan->status = $request->status;

        if ($request->status === 'Menunggu Persetujuan Customer') {
            $pesanan->estimasi = $request->estimasi;
            $pesanan->harga = $request->harga;
        }

        if ($request->filled('catatan')) {
            $pesanan->catatan = $request->catatan;
        }

        $pesanan->save();

        // Simpan ke progress timeline
        ProgressTimeline::create([
            'pesanan_id' => $pesanan->id,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status dan riwayat berhasil diperbarui.');
    }

    public function rejectOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Ditolak';
        $order->save();

        return back()->with('success', 'Pesanan telah ditolak.');
    }

    public function detail($id)
    {
        $order = Order::with(['customer', 'progressUpdates'])->findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }

    public function statusBy($status)
    {
        $orders = Order::where('status', $status)->get();
        return view('admin.orders.status', compact('orders', 'status'));
    }

    public function kelolaPesanan(Request $request)
    {
        $query = Pesanan::query();

        // Filter berdasarkan nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pesanans = $query->get();

        return view('admin.kelola-pesanan', compact('pesanans'));
    }
    public function kelolaCatalog(Request $request)
    {
        $query = Catalog::query();

        // Filter berdasarkan nama
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $catalog = $query->get(); // Mengambil koleksi catalog setelah filter

        return view('admin.kelola-catalog', compact('catalog'));
    }



    public function tambahCatalog()
    {
        return view('admin.create-catalog');
    }

    public function editCatalog($id)
    {
        $catalog = Catalog::findOrFail($id);
        return view('admin.edit-catalog', compact('catalog'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            // 'link' => 'required|url',
            'link' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('catalog', 'public');
        }

        Catalog::create([
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'link' => $request->link,
            'gambar' => $gambarPath,
        ]);


        return redirect()->route('admin.catalog')->with('success', 'Barang berhasil ditambahkan!');
    }


    public function updateCatalog(Request $request, $id)
    {
        $catalog = Catalog::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kategori' => 'required|string|max:255',
            'link' => 'required|url',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($catalog->gambar && Storage::disk('public')->exists($catalog->gambar)) {
                Storage::disk('public')->delete($catalog->gambar);
            }

            $path = $request->file('gambar')->store('catalog', 'public');
            $catalog->gambar = $path;
        }

        $catalog->nama_barang = $validated['nama_barang'];
        $catalog->harga = $validated['harga'];
        $catalog->kategori = $validated['kategori'];
        $catalog->link = $validated['link'];

        $catalog->save();

        return redirect()->route('admin.catalog')->with('success', 'Data katalog berhasil diedit.');
    }

    public function deleteCatalog($id)
    {
        $catalog = Catalog::findOrFail($id); // Ganti dengan model yang sesuai
        $catalog->delete();

        return redirect()->route('admin.catalog')->with('success', 'Data katalog berhasil dihapus.');
    }



    public function allOrders()
    {
        $orders = Order::with('customer')->latest()->get();
        return view('admin.orders.total', compact('orders'));
    }

    // Di Admin\OrderController atau controller yang kamu pakai
    public function detailPesanan($id)
    {
        $pesanan = Pesanan::with(['customer', 'progressTimeline'])->findOrFail($id);
        return view('admin.orders.detail', compact('pesanan'));
    }

    public function editHarga($id)
    {
        $harga = Pesanan::findOrFail($id);
        return view('admin.edit-harga', compact('harga'));
    }

    public function updateHarga(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->harga = $request->input('harga');
        $pesanan->save();

        return redirect()->route('admin.orders')->with('success', 'berhasil.');
    }


    public function showPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('admin.pesanan.detail', compact('pesanan'));
    }

    public function konfirmasiPesanan(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric',
            'estimasi' => 'required|string|max:255',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->harga = $request->harga;
        $pesanan->estimasi = $request->estimasi;
        $pesanan->status = 'Menunggu Persetujuan Customer';
        $pesanan->save();

        return redirect()->route('admin.pesanan.show', $id)->with('success', 'Pesanan berhasil dikonfirmasi.');
    }
    public function users()
    {
        // Ambil semua user dengan role customer
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')->get(); // Filter customer berdasarkan role
        return view('admin.customers.index', compact('customers'));
    }

    public function edit($id)
    {
        $customer = User::find($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = User::find($id);
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Data customer berhasil dihapus!');
    }

    public function pembayaran()
    {
        $pembayarans = Pembayaran::with('user')->get(); // atau relasi dari pesanan
        return view('admin.pembayaran', compact('pembayarans'));
    }

    public function konfirmasiPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'lunas';
        $pembayaran->save();

        return redirect()->back()->with('success', 'Status pembayaran diperbarui!');
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Update data
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Update foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::exists($user->photo)) {
                Storage::delete($user->photo);
            }

            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
