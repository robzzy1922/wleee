<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function create()
    {
        return view('customer.pesanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'jenis_barang' => 'required|string|max:100',
            'keluhan' => 'nullable|string',
        ]);

        Pesanan::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'jenis_barang' => $request->jenis_barang,
            'keluhan' => $request->keluhan,
            'tanggal_pemesanan' => now(),
            'status' => 'Menunggu Konfirmasi Admin',
            'harga' => null,
            'estimasi' => null,
        ]);

        return redirect()->route('customer.pesanan.show', $pesanan->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->input('status');
        $pesanan->save();

        return redirect('http://127.0.0.1:8000/admin/kelola-pesanan')->with('success', 'Status updated successfully');
    }

    public function show($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        return view('customer.pesanan.detail', compact('pesanan'));
    }

   
}
