@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Riwayat Pembayaran</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Pesanan</th>
                    <th class="py-3 px-4">Metode</th>
                    <th class="py-3 px-4">Total</th>
                    <th class="py-3 px-4">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($payment->tanggal_pembayaran)->format('d M Y') }}</td>
                        <td class="py-3 px-4">#{{ $payment->pesanan->id ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $payment->metode_pembayaran }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <span class="inline-block px-3 py-1 rounded-full text-white {{ $payment->status_pembayaran == 'Lunas' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                {{ $payment->status_pembayaran }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada pembayaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
