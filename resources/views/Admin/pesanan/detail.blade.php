@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Detail Pesanan</h2>

    <div class="space-y-4">
        <div><strong>Nama:</strong> {{ $pesanan->nama }}</div>
        <div><strong>Alamat:</strong> {{ $pesanan->alamat }}</div>
        <div><strong>Telepon:</strong> {{ $pesanan->telepon }}</div>
        <div><strong>Jenis Barang:</strong> {{ $pesanan->jenis_barang }}</div>
        <div><strong>Keluhan:</strong> {{ $pesanan->keluhan }}</div>
        <div><strong>Tanggal Pemesanan:</strong> {{ $pesanan->tanggal_pemesanan }}</div>
        <div><strong>Status Saat Ini:</strong> {{ $pesanan->status }}</div>
    </div>

    <form action="{{ route('admin.pesanan.konfirmasi', $pesanan->id) }}" method="POST" class="mt-6">
        @csrf
        <div class="mb-4">
            <label for="harga" class="block font-semibold mb-1">Total Biaya (Rp)</label>
            <input type="number" name="harga" id="harga" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="estimasi" class="block font-semibold mb-1">Estimasi Waktu Pengerjaan</label>
            <input type="text" name="estimasi" id="estimasi" class="w-full p-2 border rounded" required placeholder="Contoh: 2 hari">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Konfirmasi dan Kirim ke Customer
        </button>
    </form>
</div>
@endsection
