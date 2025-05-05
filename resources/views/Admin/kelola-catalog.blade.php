@extends('layouts.admin')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        <aside class="h-screen w-64 bg-gray-900 text-white p-5 space-y-6 fixed">
            <h2 class="text-2xl font-bold">TechFix Admin</h2>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
                <a href="{{ route('admin.orders') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Pesanan</a>
                <a href="{{ route('admin.catalog') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Katalog</a>
                <a href="{{ route('admin.users') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Pengguna</a>
                {{-- <a href="{{ route('admin.pembayaran') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Pembayaran</a> --}}
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 container mx-auto p-6" x-data="{ openDetail: false, selectedOrder: null }">

            <h1 class="text-2xl font-bold mb-4">Kelola Catalog</h1>

            <!-- Filter -->
            <!-- filepath: c:\xampp\htdocs\proyek2\resources\views\Admin\kelola-pesanan.blade.php -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-2 mb-4">
                <form method="GET" action="{{ route('admin.catalog') }}" class="flex flex-col md:flex-row gap-2 w-full">
                    <input type="text" name="search" placeholder="Cari Nama barang..." value="{{ request('search') }}"
                        class="border px-4 py-2 rounded-lg w-full md:w-1/3">
                </form>
                <a href="{{ route('admin.tambahCatalog') }}"
                    class="bg-blue-700 text-white px-6 py-2 rounded-lg whitespace-nowrap inline-flex items-center justify-center">
                    Tambah Data
                </a>

            </div>
            <!-- Tabel Pesanan -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">Nama Barang</th>
                            <th class="border px-4 py-2">Harga</th>
                            <th class="border px-4 py-2">Kategori</th>
                            <th class="border px-4 py-2">Link</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($catalog as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->nama_barang }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2">{{ $item->kategori }}</td>
                                <td class="border px-4 py-2"
                                    style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $item->link }}
                                </td>

                                <td class="border px-4 py-2 text-center">
                                    <button class="bg-blue-500 text-white px-3 py-1 rounded"
                                        @click="openDetail = true; selectedOrder = {{ json_encode($item) }}">
                                        Detail
                                    </button>
                                    <a href="{{ route('admin.editCatalog', $item->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                                    <form action="{{ route('admin.deleteCatalog', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE') <!-- Menyatakan bahwa ini adalah permintaan DELETE -->
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus katalog ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Modal Detail Pesanan -->
            <div x-show="openDetail" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
                x-transition.opacity>
                <div class="bg-white rounded-lg shadow-lg w-100 p-6">
                    <h2 class="text-xl font-bold mb-4">Detail Pesanan</h2>

                    <div class="space-y-2">
                        <p><strong>Nama:</strong> <span x-text="selectedOrder?.nama_barang"></span></p>
                        <p><strong>Harga:</strong> Rp. <span x-text="selectedOrder?.harga"></span></p>
                        <p><strong>Kategori:</strong> <span x-text="selectedOrder?.kategori"></span></p>
                        <p><strong>Link:</strong> <span x-text="selectedOrder?.link.slice(0, 50)"></span></p>

                        <div>
                            <strong>Gambar:</strong>
                            <img :src="'/storage/' + selectedOrder?.gambar" alt="Gambar Barang"
                                class="w-40 mt-2 rounded-lg shadow-md">
                        </div>
                    </div>

                    <template x-if="selectedOrder?.status != 'menunggu'">
                        <div class="flex justify-end mt-6">
                            <button type="button" @click="openDetail = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Tutup</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection
