<div class="bg-dark text-white vh-100 p-3" style="width: 250px;">
    <h4 class="text-center">TechFix Admin</h4>
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">📊 Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}" class="nav-link text-white">🛠 Kelola Pesanan</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users') }}" class="nav-link text-white">👥 Data Pengguna</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings') }}" class="nav-link text-white">⚙️ Pengaturan</a>
        </li>
    </ul>
</div>
