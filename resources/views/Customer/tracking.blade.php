@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Tracking Servis</h2>

    @forelse($pesanans as $pesanan)
        <div class="mb-6 border border-gray-200 rounded-lg p-4 shadow-sm">
            <h3 class="text-lg font-semibold mb-2">Pesanan #{{ $pesanan->id }}</h3>
            <p class="text-gray-600 mb-2">Layanan: <strong>{{ $pesanan->layanan ?? '-' }}</strong></p>
            <p class="text-gray-600 mb-4">Tanggal Pemesanan: {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y') }}</p>

            <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                <div class="bg-blue-500 h-3 rounded-full transition-all duration-300"
                     style="width:
                        @if($pesanan->status == 'Menunggu Konfirmasi Admin') 25%
                        @elseif($pesanan->status == 'Menunggu Persetujuan Customer') 40%
                        @elseif($pesanan->status == 'Dalam Proses Servis') 70%
                        @elseif($pesanan->status == 'Selesai') 100%
                        @else 10%
                        @endif
                     ">
                </div>
            </div>

            <p class="text-sm font-medium">
                Status:
                <span class="text-blue-600">{{ $pesanan->status }}</span>
            </p>
        </div>
    @empty
        <p class="text-center text-gray-500">Belum ada pesanan servis 😢</p>
    @endforelse
</div>
@endsection
