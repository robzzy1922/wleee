@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #E0F2F1;
        margin: 0;
        padding: 0;
    }

    .navbar {
        background-color: #00796B;
        color: white;
        font-size: 18px;
        display: flex;
        align-items: center;
        padding: 15px 20px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 60px;
        z-index: 1001;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .menu-btn {
        font-size: 26px;
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        margin-right: 20px;
    }

    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: -250px;
        background-color: #2c2f38;
        padding-top: 60px;
        transition: 0.3s;
        z-index: 1000;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
    }

    .sidebar.active {
        left: 0;
    }

    /* .sidebar a {
        padding: 16px 24px;
        text-decoration: none;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: background 0.3s;
    } */

    .sidebar a:hover {
        background-color: #3c3f4a;
    }

    .container2 {
        max-width: 1200px;
        margin: 100px auto 40px auto;
        padding: 20px;
        background: white;
        color: black;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .hero-section {
        background: #38E4D2;
        color: black;
        padding: 50px;
        border-radius: 10px;
    }

    .hero-section h1 {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .hero-section p {
        font-size: 16px;
    }

    .service-info {
        padding: 20px;
        background: #E0F2F1;
        border-radius: 10px;
        margin-top: 20px;
    }

    .notif-box {
        background-color: #fff3cd;
        color: #856404;
        padding: 12px;
        border-radius: 8px;
        margin: 20px auto 0 auto;
        max-width: 1200px;
        text-align: left;
    }
</style>

<!-- Navbar -->
{{-- <div class="navbar">
    <button id="toggleSidebar" class="menu-btn">&#9776;</button>
    <span class="font-bold text-lg">TechFix</span>
</div> --}}

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <a href="{{ route('customer.pesanan.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded">Pesanan Saya</a>
    <a href="{{ route('customer.pembayaran') }}">Pembayaran</a>
    <a href="{{ route('customer.riwayat') }}">Riwayat Pesanan</a>
    <a href="{{ route('customer.ulasan') }}">Ulasan</a>
</div>

<!-- Notifikasi -->
@foreach ($pesanan as $p)
    @if (!$p->is_read_customer)
        <script>
            fetch('{{ route('notif.read') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: {{ $p->id }} })
            });
        </script>
    @endif
@endforeach

<!-- Konten Utama -->
<div class="container2">
    <div class="hero-section">
        <h1>Service Laptop, Printer, dan Komputer Terbaik di Kota Indramayu</h1>
        <p>Panggil TechFix untuk layanan terbaik di kota Anda. Kami siap membantu dengan gratis antar jemput dan pembayaran setelah servis selesai.</p>
        <a href="{{ route('pesanan.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-5 rounded-lg mt-4 inline-block transition duration-300">Mau Servis</a>
    </div>

    <div class="service-info text-left mt-6">
        <h3 class="font-semibold text-lg mb-2">Jenis Layanan</h3>
        <ul class="list-disc list-inside">
            <li>Service Laptop</li>
            <li>Service Printer</li>
            <li>Service Komputer</li>
            <li>AC</li>
            <li>Kipas Angin</li></li>
            <li>Dan Barang Elektronik Lainnya</li>
        </ul>
    </div>
</div>

<!-- Sidebar Toggle Script -->
<script>
    document.getElementById("toggleSidebar").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("active");
    });
</script>
@endsection
