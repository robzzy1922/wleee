@extends('layouts.app') {{-- atau layout kamu misalnya app.blade.php --}}
@section('title', 'Daftar Semua Pesanan')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">Daftar Pesanan - Status: {{ ucfirst($status) }}</h2>

    @if($orders->isEmpty())
        <p class="text-gray-600">Belum ada pesanan.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-100 text-gray-700 text-left">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Kerusakan</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Estimasi</th>
                        <th class="px-4 py-2">Harga</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->customer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $order->barang }}</td>
                        <td class="px-4 py-2">{{ $order->kerusakan }}</td>
                        <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                        <td class="px-4 py-2">{{ $order->estimasi_waktu ?? '-' }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($order->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.orders.detail', $order->id) }}" class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
