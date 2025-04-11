@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Form Pemesanan Servis</h2>

    {{-- Notifikasi jika ada error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('customer.order.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1">Jenis Perangkat</label>
            <input
                type="text"
                name="device_type"
                class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Laptop, HP, TV"
                value="{{ old('device_type') }}"
                required
            >
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Deskripsi Kerusakan</label>
            <textarea
                name="description"
                class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Layar pecah, baterai cepat habis"
                required
            >{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Kontak</label>
            <input
                type="text"
                name="contact"
                class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: 08xxxxxxxxxx / email"
                value="{{ old('contact') }}"
                required
            >
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            Kirim Pesanan
        </button>
    </form>
</div>
@endsection
