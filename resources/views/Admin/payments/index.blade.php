@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Kelola Pembayaran</h1>

    <!-- Filter & Export -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-2 mb-4">
        <div class="flex gap-2">
            <input type="text" placeholder="Cari Pembayaran..." class="border px-4 py-2 rounded-lg">
            <select class="border px-4 py-2 rounded-lg">
                <option value="">Semua Status</option>
                <option value="Lunas">Lunas</option>
                <option value="Pending">Pending</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
        <div class="flex gap-2">
            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Export CSV</a>
            <a href="#" class="bg-red-500 text-white px-4 py-2 rounded-lg">Export PDF</a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">ID Pembayaran</th>
                    <th class="border px-4 py-2">ID Pesanan</th>
                    <th class="border px-4 py-2">Nama Customer</th>
                    <th class="border px-4 py-2">Tanggal Bayar</th>
                    <th class="border px-4 py-2">Metode Bayar</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Bukti</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $i => $payment)
                <tr class="border-t">
                    <td class="border px-4 py-2">{{ $i + 1 }}</td>
                    <td class="border px-4 py-2">{{ $payment->id }}</td>
                    <td class="border px-4 py-2">{{ $payment->order->id }}</td>
                    <td class="border px-4 py-2">{{ $payment->order->customer->name }}</td>
                    <td class="border px-4 py-2">{{ $payment->created_at->format('d M Y H:i') }}</td>
                    <td class="border px-4 py-2">{{ $payment->method }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($payment->amount,0,',','.') }}</td>
                    <td class="border px-4 py-2">
                        @if ($payment->proof)
                            <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs {{ $payment->status == 'Lunas' ? 'bg-green-200 text-green-800' : ($payment->status == 'Pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="border px-4 py-2 space-x-1">
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="bg-gray-500 text-white px-2 py-1 rounded">Detail</a>
                        @if ($payment->status == 'Pending')
                            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Verifikasi</button>
                            </form>
                            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($payments->isEmpty())
                <tr>
                    <td colspan="10" class="text-center p-4 text-gray-500">Belum ada data pembayaran.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
