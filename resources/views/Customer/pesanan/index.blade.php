@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-24 px-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-teal-700 mb-4">Pesanan Saya</h2>
        <p class="text-gray-600 mb-6">Berikut adalah daftar pesanan servis Anda. Silakan cek status atau lakukan tindakan jika diperlukan.</p>

        @if($pesanans->isEmpty())
            <div class="text-center py-10 text-gray-500 text-lg">
                Belum ada pesanan servis 😢
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-teal-50 text-teal-800 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 border">No</th>
                            <th class="px-4 py-3 border">ID Pesanan</th>
                            <th class="px-4 py-3 border">jenis_barang</th>
                            <th class="px-4 py-3 border">Tanggal</th>
                            <th class="px-4 py-3 border">Status</th>
                            <th class="px-4 py-3 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($pesanans as $i => $pesanan)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-4 py-2 border">{{ $i + 1 }}</td>
                            <td class="px-4 py-2 border font-semibold text-gray-700">#{{ $pesanan->id }}</td>
                            <td class="px-4 py-2 border">{{ $pesanan->jenis_barang }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $pesanan->status == 'Selesai' ? 'bg-green-100 text-green-700' :
                                    ($pesanan->status == 'Dalam Proses Servis' ? 'bg-yellow-100 text-yellow-700' :
                                    'bg-blue-100 text-blue-700') }}">
                                    {{ $pesanan->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('customer.pesanan.detail', $pesanan->id) }}"
                                   class="text-blue-600 hover:underline font-medium">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
