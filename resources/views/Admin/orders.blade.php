@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-xl font-bold mb-4">Kelola Pesanan - {{ ucfirst($status) }}</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer->name ?? 'Tidak Diketahui' }}</td>
            <td>{{ $order->description }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>
                <a href="{{ route('order.show', $order->id) }}">Detail</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
