<!DOCTYPE html>
<html lang="id">
    <!-- Tambahkan ini di bagian atas sebelum <head> jika perlu -->
        @php
            use App\Models\Pesanan;
            $user = Auth::user();
            $notifCount = 0;
            $notifs = [];

            if ($user && $user->role === 'customer') {
                $notifs = Pesanan::where('user_id', $user->id)
                            ->where('is_read_customer', false)
                            ->latest()
                            ->take(5)
                            ->get();

                $notifCount = $notifs->count();
            }
        @endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techfix - Service Laptop & Elektronik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-[#14B8A6]">

    <!-- Navbar -->
    <nav class="bg-[#38E4D2] text-black p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Techfix</a>
            <ul class="flex space-x-6 items-center">
                <li><a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-md font-semibold">Home</a></li>
                <li><a href="#" class="px-4 py-2 rounded-md font-semibold">Kami Menjual</a></li>
                <li><a href="{{ route('faq') }}" class="px-4 py-2 rounded-md font-semibold">FAQ</a></li>
                <li><a href="#" class="px-4 py-2 rounded-md font-semibold">Kontak</a></li>

                @auth
                <!-- Notifikasi -->
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open; markAsRead()" class="relative px-4 py-2 rounded-md font-semibold">
                        🔔
                        @if($notifCount > 0)
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-2 rounded-full">{{ $notifCount }}</span>
                        @endif
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg p-3 z-50">
                        <p class="font-bold border-b mb-2 pb-1">Notifikasi</p>
                        @if($notifCount > 0)
                            <ul>
                                @foreach ($notifs as $n)
                                    <li class="text-sm border-b py-2">
                                        📌 Status pesanan jadi <strong>{{ $n->status }}</strong>
                                        <br>
                                        <small class="text-gray-500">{{ $n->updated_at->diffForHumans() }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">Tidak ada notifikasi baru.</p>
                        @endif
                    </div>
                </li>
                    <!-- Dropdown Profil -->
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 px-4 py-2 rounded-md font-semibold">
                            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : '' }}" alt="Avatar" class="w-8 h-8 rounded-full">
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg p-3">
                            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm">Edit Profil</a>
                            <a href="{{ route('customer.pesanan.detail', ['id' => Auth::user()->id]) }}" class="block px-3 py-2 text-sm">Pesanan Saya</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-3 py-2 text-sm text-red-500">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="bg-[#E81500] text-white px-4 py-2 rounded-md font-semibold">Masuk</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto">
        @yield('content')

    </div>

    <!-- Footer -->
    <footer class="bg-[#000000] text-white py-6 mt-10" style="position: fixed; bottom: 0; width: 100%;">
        <div class="container mx-auto text-center">
            <p class="text-xs">&copy; 2025 - All rights reserved - Techfix</p>
        </div>
    </footer>
    <script>
        function markAsRead() {
            fetch("{{ route('notif.read') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });
        }
    </script>
</body>
</html>

