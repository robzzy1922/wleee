@extends('layouts.app') <!-- Kalau kamu pakai layout utama -->

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pesanan Masuk</h1>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Nama Customer</th>
                    <th class="py-2 px-4">Barang</th>
                    <th class="py-2 px-4">Kerusakan</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Harga</th>
                    <th class="py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $order->id }}</td>
                    <td class="py-2 px-4">{{ $order->customer_name }}</td>
                    <td class="py-2 px-4">{{ $order->product_name }}</td>
                    <td class="py-2 px-4">{{ $order->damage }}</td>
                    <td class="py-2 px-4">{{ $order->status }}</td>
                    <td class="py-2 px-4">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">
                        <a href="#" class="text-blue-500 hover:underline">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($orders->isEmpty())
            <div class="text-center p-4">
                Tidak ada pesanan masuk.
            </div>
        @endif
    </div>
</div>
@endsection
