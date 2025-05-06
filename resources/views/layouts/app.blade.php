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
            <a href="{{ route('home') }}"class="text-xl font-bold">Techfix</a>
            <ul class="flex space-x-6 items-center">
                <li><a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-md font-semibold">Home</a></li>
                {{-- <li><a href="#" class="px-4 py-2 rounded-md font-semibold">Kami Menjual</a></li>
                <li><a href="{{ route('faq') }}" class="px-4 py-2 rounded-md font-semibold">FAQ</a></li>
                <li><a href="#" class="px-4 py-2 rounded-md font-semibold">Kontak</a></li> --}}

                @auth
                <!-- Notifikasi -->
                <li class="relative list-none">
                    @php
                        $userNotifications = $notifications->where('target_role', 'customer');
                        $unreadCount = $userNotifications->where('is_read', false)->count();
                        $userNotifications = $userNotifications->sortByDesc('created_at'); // Notifikasi terbaru di atas
                    @endphp
                
                    <button class="relative px-4 py-2 rounded-md font-semibold" onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')">
                        🔔
                        @if ($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>
                
                    <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg p-4 z-50">
                        <p class="font-bold border-b mb-2 pb-1">Notifikasi</p>
                
                        @if ($unreadCount > 0)
                            <form action="{{ route('notifications.readAll') }}" method="POST" class="mb-2">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-sm text-blue-500">Baca Semua</button>
                            </form>
                        @endif
                
                        <ul class="space-y-2 max-h-64 overflow-y-auto">
                            @forelse ($userNotifications as $notif)
                                <li class="border-b pb-2">
                                    <strong class="text-blue-600">{{ $notif->title }}</strong>
                                    <p class="text-sm text-gray-700">{{ $notif->message }}</p>
                                    <small class="text-gray-500">{{ $notif->updated_at->diffForHumans() }}</small>
                
                                    @if (!$notif->is_read)
                                        <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="mt-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm text-blue-500">Mark as Read</button>
                                        </form>
                                    @else
                                        <span class="text-sm text-green-500 mt-1">Read</span>
                                    @endif
                                </li>
                            @empty
                                <li class="text-sm text-gray-500">Tidak ada notifikasi.</li>
                            @endforelse
                        </ul>
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
                            <a href="{{ route('customer.pesanan.detail', ['id' => Auth::user()->id]) }}" class="block px-3 py-2 text-sm">Pesanan</a>
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
    <div class="container mx-auto pb-5">
        @yield('content')

    </div>

    <!-- Footer -->
    <footer class="bg-[#000000] text-white py-6 mt-10" style="position: fixed; bottom: 0; width: 100%;">
        <div class="container mx-auto text-center">
            <p class="text-xs">&copy; 2025 - All rights reserved - Techfix</p>
        </div>
    </footer>
    <script>
        function markAsRead(notifId) {
            fetch(`/notifications/${notifId}/read`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ is_read: true }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update jumlah notifikasi yang belum dibaca
                    unreadCount -= 1;
                    if (unreadCount <= 0) {
                        unreadCount = 0;
                        // Jika tidak ada notifikasi yang belum dibaca, sembunyikan badge
                        document.querySelector('.badge').style.display = 'none';
                    }
                } else {
                    alert('Terjadi kesalahan!');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    
        function markAllAsRead() {
            fetch('/notifications/read-all', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    unreadCount = 0;
                    // Menyembunyikan badge jika tidak ada lagi notifikasi yang belum dibaca
                    document.querySelector('.badge').style.display = 'none';
                } else {
                    alert('Terjadi kesalahan!');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    
    
</body>
</html>

