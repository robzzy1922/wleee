@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Kelola Pembayaran</h2>

    <!-- Filter, Status, Cari, Export -->
    <div class="flex flex-wrap items-center gap-3 mb-4">
        <select class="border border-gray-300 rounded p-2">
            <option>Filter</option>
            <option>Hari Ini</option>
            <option>Minggu Ini</option>
            <option>Bulan Ini</option>
        </select>

        <select class="border border-gray-300 rounded p-2">
            <option>Status</option>
            <option>Berhasil</option>
            <option>Pending</option>
            <option>Gagal</option>
        </select>

        <input type="text" placeholder="Cari..." class="border border-gray-300 rounded p-2 w-48">

        <!-- Export Button -->
        <a href="{{ route('admin.pembayaran.export') }}" class="ml-auto bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
            Export ▼
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">ID Pembayaran</th>
                    <th class="px-4 py-3">ID Pesanan</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Tgl Bayar</th>
                    <th class="px-4 py-3">Metode</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($pembayarans as $index => $pembayaran)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $pembayaran->id_pembayaran ?? 'PAY00' . $pembayaran->id }}</td>
                        <td class="px-4 py-2">{{ $pembayaran->id_pesanan ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $pembayaran->nama_pelanggan }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d M H:i') }}</td>
                        <td class="px-4 py-2">{{ $pembayaran->metode }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <div class="flex items-center gap-2">
                                <!-- Detail Button -->
                                <button class="text-blue-600 hover:underline" x-data="{ open: false }" @click="open = !open">
                                    🔍
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.pembayaran.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">❎</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Detail Pembayaran -->
                    <div x-show="open" x-cloak>
                        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
                            <div class="bg-white p-6 rounded shadow-lg max-w-lg w-full">
                                <h3 class="text-lg font-bold mb-4">Detail Pembayaran</h3>
                                <p><strong>ID Pembayaran:</strong> {{ $pembayaran->id_pembayaran ?? 'PAY00' . $pembayaran->id }}</p>
                                <p><strong>ID Pesanan:</strong> {{ $pembayaran->id_pesanan ?? '-' }}</p>
                                <p><strong>Nama:</strong> {{ $pembayaran->nama_pelanggan }}</p>
                                <p><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d M Y H:i') }}</p>
                                <p><strong>Metode Pembayaran:</strong> {{ $pembayaran->metode }}</p>
                                <p><strong>Jumlah:</strong> Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
                                <button @click="open = false" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Tutup</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data pembayaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
