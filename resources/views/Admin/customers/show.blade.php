@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Detail Customer</h2>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-2">Informasi Pribadi</h3>
        <p><span class="font-medium">Nama:</span> {{ $customer->name }}</p>
        <p><span class="font-medium">Email:</span> {{ $customer->email }}</p>
        <p><span class="font-medium">No. HP:</span> {{ $customer->phone }}</p>
        <p><span class="font-medium">Alamat:</span> {{ $customer->address }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Riwayat Pesanan</h3>
        @if($customer->orders->isEmpty())
            <p class="text-gray-500">Belum ada pesanan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Barang</th>
                            <th class="px-4 py-2">Kerusakan</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-800">
                        @foreach($customer->orders as $order)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->item_name }}</td>
                            <td class="px-4 py-2">{{ $order->damage_description }}</td>
                            <td class="px-4 py-2">{{ $order->status }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
