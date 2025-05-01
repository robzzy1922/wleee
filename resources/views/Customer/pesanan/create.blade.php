@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 p-8 bg-teal-300 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Pesan Jasa Servis</h2>

    <form method="POST" action="{{ route('customer.pesanan.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kiri -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Nama</label>
                    <input type="text" name="nama" class="w-full p-2 rounded-lg shadow border border-gray-300 focus:ring-2 focus:ring-teal-600" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Alamat</label>
                    <input type="text" name="alamat" class="w-full p-2 rounded-lg shadow border border-gray-300 focus:ring-2 focus:ring-teal-600" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Nomor Telepon</label>
                    <input type="text" name="telepon" class="w-full p-2 rounded-lg shadow border border-gray-300 focus:ring-2 focus:ring-teal-600" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Alat Elektronik yang Akan Direparasi</label>
                    <input type="text" name="jenis_barang" class="w-full p-2 rounded-lg shadow border border-gray-300 focus:ring-2 focus:ring-teal-600" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" class="w-full p-2 rounded-lg shadow border border-gray-300 focus:ring-2 focus:ring-teal-600" required>
                </div>
            </div>

            <!-- Kanan -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi Pesanan</label>
                <textarea name="keluhan" rows="10" class="w-full p-3 rounded-lg shadow border border-gray-300 resize-none focus:ring-2 focus:ring-teal-600" required></textarea>
            </div>
        </div>

        <div class="mt-6 text-center">
            <button type="submit" class="bg-white text-teal-700 font-semibold py-2 px-6 rounded-lg shadow hover:bg-teal-600 hover:text-white transition duration-200">
                Pesan
            </button>
        </div>
    </form>
</div>
@endsection
