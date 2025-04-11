@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Pesanan - {{ $title }}</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Barang</th>
                    <th class="px-4 py-2 text-left">Kerusakan</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Estimasi</th>
                    <th class="px-4 py-2 text-left">Harga</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($pesanan as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $item->id }}</td>
                    <td class="px-4 py-2">{{ $item->customer->nama }}</td>
                    <td class="px-4 py-2">{{ $item->barang }}</td>
                    <td class="px-4 py-2">{{ $item->kerusakan }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded-full text-sm
                            @if($item->status == 'Selesai') bg-green-100 text-green-600
                            @elseif($item->status == 'Ditolak') bg-red-100 text-red-600
                            @else bg-yellow-100 text-yellow-600 @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $item->estimasi_waktu ?? '-' }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($item->harga ?? 0) }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.pesanan.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
