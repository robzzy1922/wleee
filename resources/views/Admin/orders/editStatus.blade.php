@extends('layouts.app')
@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Ubah Status - Pesanan #{{ $order->id }}</h2>

    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
        @csrf @method('PATCH')

        @if ($order->status == 'Menunggu Konfirmasi')
            <div>
                <label class="block">Harga</label>
                <input type="number" name="price" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block">Estimasi Waktu (hari)</label>
                <input type="text" name="estimated_time" class="w-full border rounded p-2" required>
            </div>
        @elseif ($order->status == 'Dalam Proses Servis')
            <div>
                <label class="block">Update Progress</label>
                <input type="text" name="progress_note" class="w-full border rounded p-2" required>
            </div>
        @endif

        <div>
            <label class="block">Status Baru</label>
            <select name="status" class="w-full border rounded p-2" required>
                @if ($order->status == 'Menunggu Konfirmasi')
                    <option value="Menunggu Persetujuan Customer">Menunggu Persetujuan Customer</option>
                @elseif ($order->status == 'Menunggu Persetujuan Customer')
                    <option value="Dalam Proses Servis">Dalam Proses Servis</option>
                @elseif ($order->status == 'Dalam Proses Servis')
                    <option value="Selesai">Selesai</option>
                @endif
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
