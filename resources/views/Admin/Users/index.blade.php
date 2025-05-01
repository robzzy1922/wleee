@extends('layouts.admin')

@section('content')
 <!-- Sidebar -->
<aside class="h-screen w-64 bg-gray-900 text-white p-5 space-y-6 fixed">
    <h2 class="text-2xl font-bold">TechFix Admin</h2>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Dashboard</a>
        <a href="{{ route('admin.orders') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Pesanan</a>
        <a href="{{ route('admin.users') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Data Pengguna</a>
        <a href="{{ route('admin.pembayaran') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Pembayaran</a>
    </nav>
</aside>
<div class="ml-64 p-6">
    <h2 class="text-2xl font-bold mb-4">Data Pengguna</h2>

    <!-- Tabel Pengguna -->
    <div class="mb-4">
        <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Tambah Pengguna</a>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($users as $index => $user)
                    <tr>
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
