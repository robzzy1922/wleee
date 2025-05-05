@extends('layouts.admin')

@section('content')
    <div class="flex">
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


        <div class="flex-1 ml-64 container  mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Tambah data </h1>
            <form action="{{ route('catalog.store') }}" method="POST" enctype="multipart/form-data">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
                @csrf
                @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
                    <input type="text" name="nama_barang"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium">Harga</label>
                    <input type="number" name="harga"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="gambar" class="block text-sm font-medium">Gambar</label>
                    <input type="file" name="gambar"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium">Kategori</label>
                    <select name="kategori" id=""
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                        <option value="perlengkapan">Pilih Kategori</option>
                        <option value="perlengkapan">Perlengkapan PC</option>
                        <option value="laptop">laptop</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="link" class="block text-sm font-medium">Link</label>
                    <input type="text" name="link"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                        >
                </div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full transition duration-200">Simpan</button>
            </form>
        </div>
    </div>


    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview-image');
                preview.src = reader.result;
            };
            if (input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
