@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Kelola Pesanan Customer</h2>

    {{-- Input Pencarian --}}
    <input type="text" placeholder="Cari Pesanan..." class="border rounded px-3 py-2 mb-4 float-right" />

    {{-- Tabel Data Pesanan --}}
    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-collapse text-sm">
            <thead class="bg-gray-200 text-left">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">Customer</th>
                    <th class="border p-2">Barang</th>
                    <th class="border p-2">Kerusakan</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Estimasi Waktu</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $index => $order)
                <tr>
                    <td class="border p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $order->customer->nama ?? '-' }}</td>
                    <td class="border p-2">{{ $order->nama_barang }}</td>
                    <td class="border p-2">{{ $order->kerusakan }}</td>
                    <td class="border p-2">
                        @if($order->harga)
                            Rp{{ number_format($order->harga, 0, ',', '.') }}
                        @else
                            <span class="text-gray-400 italic">Belum diinput</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        {{ $order->estimasi_waktu ? $order->estimasi_waktu . ' hari' : '-' }}
                    </td>
                    <td class="border p-2">
                        <span class="px-2 py-1 text-xs rounded
                            @if($order->status == 'Menunggu Konfirmasi') bg-yellow-200 text-yellow-800
                            @elseif($order->status == 'Menunggu Pembayaran') bg-blue-200 text-blue-800
                            @elseif($order->status == 'Dalam Proses Servis') bg-green-200 text-green-800
                            @elseif($order->status == 'Selesai') bg-gray-200 text-gray-800
                            @endif
                        ">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="border p-2 text-center space-x-2">
                        {{-- Tombol Aksi --}}
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                            Detail
                        </a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                            Ubah Status
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="border p-4 text-center text-gray-500">Belum ada data pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
