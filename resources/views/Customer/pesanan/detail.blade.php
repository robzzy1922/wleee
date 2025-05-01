@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg max-w-3xl pb-5">
    <h2 class="text-2xl font-bold mb-6">Daftar Pesanan</h2>

    @foreach($pesanans as $pesanan)
    <div class="mb-8 border-b pb-4">
        <h3 class="text-xl font-semibold">Detail Pesanan #{{ $pesanan->id }}</h3>

        <div class="space-y-2">
            <p><strong>Layanan/Barang:</strong> {{ $pesanan->jenis_barang }}</p>
            <p><strong>Deskripsi Kerusakan:</strong> {{ $pesanan->keluhan }}</p>
            <p><strong>Tanggal Pemesanan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y H:i') }}</p>
            <p><strong>Status:</strong>
                <span class="px-2 py-1 rounded
                    {{ $pesanan->status == 'Selesai' ? 'bg-green-100 text-green-800' :
                       ($pesanan->status == 'Dalam Proses Servis' ? 'bg-yellow-100 text-yellow-800' :
                       'bg-blue-100 text-blue-800') }}">
                    {{ $pesanan->status }}
                </span>
            </p>

            @if($pesanan->status_pesanan == 'Menunggu Pembayaran')
            <p><strong>Total Biaya:</strong> Rp{{ number_format($pesanan->total_biaya, 0, ',', '.') }}</p>
            <a href="{{ route('customer.pesanan.bayar', $pesanan->id) }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
               Bayar Sekarang
            </a>
            @endif

            @if($pesanan->status_pesanan == 'Selesai')
            <p><strong>Ulasan Anda:</strong> {{ $pesanan->review ?? 'Belum ada ulasan' }}</p>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
