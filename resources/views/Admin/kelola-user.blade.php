@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6" x-data="{ openEdit: false, selectedUser: null }">
    <h1 class="text-2xl font-bold mb-4">Kelola Pengguna</h1>
    
    <!-- Tabel User -->
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Nama</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
                <th class="border border-gray-300 px-4 py-2">Peran</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($user->role) }}</td>
                <td class="border border-gray-300 px-4 py-2 flex gap-2">
                    <button @click="openEdit = true; selectedUser = {{ json_encode($user) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                    </form>                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Edit User -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-transition.opacity>
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Edit Pengguna</h2>
            <form method="POST" :action="'/users/' + selectedUser.id">
                @csrf
                @method('PUT')
                <label class="block mb-2">Nama</label>
                <input type="text" x-model="selectedUser.name" name="name" class="border w-full px-4 py-2 rounded-lg mb-4">
                <label class="block mb-2">Peran</label>
                <select name="role" class="border w-full px-4 py-2 rounded-lg mb-4">
                    <option value="admin" :selected="selectedUser.role === 'admin'">Admin</option>
                    <option value="customer" :selected="selectedUser.role === 'customer'">Customer</option>
                    <option value="technician" :selected="selectedUser.role === 'technician'">Teknisi</option>
                </select>
                <div class="flex justify-end">
                    <button @click="openEdit = false" type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
