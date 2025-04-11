@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white min-h-screen p-4">
        <h2 class="text-lg font-bold mb-4">Menu Pelanggan</h2>
        <ul>
            <li class="mb-2"><a href="#" class="block px-4 py-2 bg-gray-800 rounded">Dashboard</a></li>
            <li class="mb-2"><a href="#" class="block px-4 py-2 bg-blue-600 rounded">Account</a></li>
            <li class="mb-2"><a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded">Riwayat Service</a></li>
            <li class="mb-2"><a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded">Riwayat Pembelian</a></li>
            <li class="mb-2"><a href="#" class="block px-4 py-2 hover:bg-gray-700 rounded">Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4">Profil</h2>
        <div class="bg-white p-8 rounded-lg shadow-md w-full">
            <div class="flex flex-col items-center mb-6">
                <img src="https://via.placeholder.com/100" class="w-24 h-24 rounded-full" alt="Profile Picture">
                <input type="file" class="mt-2 text-sm">
                <p class="text-xs text-gray-500">Photo Size: 200 x 200</p>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium">No Telepon</label>
                    <input type="text" name="phone" id="phone" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password Baru</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg w-full">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
