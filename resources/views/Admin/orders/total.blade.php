@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Total Pesanan</h2>

    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama Customer</th>
                    <th class="px-4 py-3">Barang</th>
                    <th class="px-4 py-3">Kerusakan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Estimasi</th>
                    <th class="px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($orders as $order)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-medium text-gray-900">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->customer->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $order->barang }}</td>
                        <td class="px-4 py-2">{{ $order->kerusakan }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                @if($order->status == 'Menunggu Konfirmasi') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'Menunggu Persetujuan Customer') bg-blue-100 text-blue-800
                                @elseif($order->status == 'Dalam Proses Servis') bg-indigo-100 text-indigo-800
                                @elseif($order->status == 'Selesai') bg-green-100 text-green-800
                                @elseif($order->status == 'Ditolak') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $order->harga ? 'Rp ' . number_format($order->harga, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-2">{{ $order->estimasi ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
