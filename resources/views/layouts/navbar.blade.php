<nav class="bg-white shadow-md p-4 flex justify-between items-center">
    <div class="text-2xl font-bold text-gray-800">TechFix Admin</div>

    <!-- Search Bar -->
    <div class="relative">
        <input type="text" placeholder="Cari pelanggan..." class="border p-2 rounded-lg w-64">
        <button class="absolute right-2 top-2 text-gray-500">🔍</button>
    </div>

    <!-- Profile & Notifications -->
    <div class="flex items-center space-x-4">
        <!-- Notifikasi -->
        <button class="relative">
            🔔
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
        </button>

        <!-- Profile Dropdown -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center space-x-2">
        <img src="{{ asset('img/default-avatar.png') }}" alt="Profile" class="w-10 h-10 rounded-full">
        <span class="font-semibold">Admin</span>
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false"
        class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden">
        <a href="#" onclick="document.getElementById('openEditProfileButton').click();"
        class="block px-4 py-2 hover:bg-gray-200">Edit Profil</a>
        <a href="{{ route('logout') }}" class="block px-4 py-2 text-red-600 hover:bg-gray-200">Logout</a>
    </div>
</div>
