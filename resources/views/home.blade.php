<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techfix - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            document.getElementById("dropdown-menu").classList.toggle("hidden");
        }

        window.onclick = function(event) {
            if (!event.target.matches('#dropdown-button') && !event.target.closest('#dropdown-menu')) {
                document.getElementById("dropdown-menu").classList.add("hidden");
            }
        }
    </script>
</head>
<body class="bg-[#14B8A6] min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <nav class="bg-[#38E4D2] py-4 px-6 flex justify-between items-center relative">
        <h1 class="text-black text-2xl font-bold">Techfix</h1>
        <div class="flex space-x-6 items-center">
            <a href="{{ route('home') }}" class="text-black font-medium">Home</a>
            <!-- Dropdown -->
            <div class="relative">
                <button id="dropdown-button" onclick="toggleDropdown(event)" class="text-black font-medium flex items-center">
                    Kami Menjual <span class="ml-1">▼</span>
                </button>
                <div id="dropdown-menu" class="absolute left-0 top-full mt-2 w-48 bg-white border border-gray-300 shadow-lg rounded-lg hidden z-50">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="icon-komputer.png" class="w-5 h-5 mr-2"> Komputer
                    </a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="icon-laptop.png" class="w-5 h-5 mr-2"> Laptop
                    </a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="icon-printer.png" class="w-5 h-5 mr-2"> Printer
                    </a>
                </div>
            </div>
            <a href="{{ route('faq') }}" class="text-black font-medium">FAQ</a>
            <a href="https://wa.me/083148140002?text=Halo%2C%20saya%20tertarik%20dengan%20aplikasi%20tabungan%20sekolahnya." target="_blank" class="text-black font-medium">Kontak</a>
            <a href="{{ route('login') }}" class="bg-[#E81500] text-black px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-[#C11200]">Masuk</a>
        </div>
    </nav>

    <!-- Header Section -->
    <div class="text-center py-10 max-w-4xl mx-auto w-full">
        <h1 class="text-3xl font-bold text-black">
            Service Laptop, Printer, dan Komputer Terbaik di Kota Indramayu
        </h1>
        <p class="text-gray-700 mt-2 text-lg">
            Panggil teknisi ke rumah, kami siap melayani Anda di mana saja, gratis antar jemput.
            Bergaransi, dan hanya bayar ketika unitmu selesai diperbaiki.
        </p>
    </div>

    <!-- Layanan Kami -->
    <div class="text-center py-10">
        <h2 class="text-2xl font-semibold text-black mb-6">Layanan Kami</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 max-w-5xl mx-auto">
            @php
                $services = [
                    ['img' => asset('images/kulkas.jpg'), 'title' => 'Kulkas'],
                    ['img' => asset('images/handphone.jpg'), 'title' => 'Handphone'],
                    ['img' => asset('images/laptop.jpg'), 'title' => 'Laptop'],
                    ['img' => asset('images/ac.jpg'), 'title' => 'AC'],
                    ['img' => asset('images/kipas.jpg'), 'title' => 'Kipas Angin']
                ];
            @endphp

            @foreach($services as $service)
                <div class="text-center">
                    <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}" class="w-32 h-32 mx-auto rounded-lg shadow-md">
                    <p class="mt-2 font-medium">{{ $service['title'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Testimoni Pelanggan -->
    <div class="bg-[#B2EBF2] py-10 px-6">
        <h2 class="text-2xl font-semibold text-center text-black">Testimoni Pelanggan</h2>
        <div class="flex flex-wrap justify-center gap-6 mt-6 max-w-5xl mx-auto">
            <div class="bg-[#B2EBF2] py-10 px-6">
                <h2 class="text-2xl font-semibold text-center text-black">Testimoni Pelanggan</h2>
                <div class="flex flex-wrap justify-center gap-6 mt-6 max-w-5xl mx-auto">
                    @forelse($reviews as $review)
                        <div class="bg-white p-6 rounded-lg shadow w-72 text-center border border-gray-300">
                            <div class="mb-2 text-yellow-500">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    ★
                                @endfor
                            </div>
                            <p class="text-gray-700 italic">"{{ $review->comment ?? 'Tidak ada komentar.' }}"</p>
                            <p class="mt-2 font-semibold text-[#004AAD]">- {{ $review->user->name }}</p>
                        </div>
                    @empty
                        <p class="text-center text-gray-600">Belum ada testimoni.</p>
                    @endforelse
                </div>
            </div>
            @foreach($testimonials as $testimonial)
                <div class="bg-white p-6 rounded-lg shadow w-72 text-center border border-gray-300">
                    <p class="text-gray-700 italic">"{{ $testimonial['text'] }}"</p>
                    <p class="mt-2 font-semibold text-[#004AAD]">- {{ $testimonial['name'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- FAQ Section (Tersembunyi dulu) -->
    <div class="bg-[#FDE68A] py-10 px-6" id="faq-section" style="display: none;">
        <h2 class="text-2xl font-semibold text-center text-black mb-6">Form Pertanyaan Umum</h2>
        <form class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama</label>
                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Nama Anda">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Email Anda">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Pertanyaan</label>
                <textarea class="w-full border border-gray-300 rounded px-3 py-2" rows="4" placeholder="Tulis pertanyaan Anda di sini..."></textarea>
            </div>
            <button type="submit" class="bg-[#E81500] hover:bg-[#C11200] text-white font-semibold px-6 py-2 rounded-lg shadow">
                Kirim Pertanyaan
            </button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-[#14B8A6] text-black py-10 px-6 mt-10" >
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 text-center md:text-left">
            <div>
                <h3 class="text-lg font-semibold text-black-400">Techfix</h3>
                <p class="mt-2">Perusahaan Jasa Service Elektronik terbaik di Kota Indramayu</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-black-400">Akun</h3>
                <ul class="mt-2">
                    <li><a href="#" class="hover:underline">Masuk</a></li>
                    <li><a href="#" class="hover:underline">Daftar</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-black-400">Tentang Kami</h3>
                <ul class="mt-2">
                    <li><a href="#" class="hover:underline">Profil</a></li>
                    <li><a href="#" class="hover:underline">Tim Kami</a></li>
                    <li><a href="#" class="hover:underline">Karir</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-black-400">Hubungi Kami</h3>
                <p class="mt-2">+6281234567890</p>
                <p>Jl. Teknisi No. 123, Indramayu</p>
            </div>
        </div>
        <div class="mt-10 py-4 text-center">
            <p class="text-sm text-black">&copy; 2025 - All rights reserved - Techfix</p>
        </div>
    </footer>

    <!-- FAQ Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqLink = document.getElementById('faq-link');
            const faqSection = document.getElementById('faq-section');

            faqLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (faqSection.style.display === 'none') {
                    faqSection.style.display = 'block';
                    window.scrollTo({ top: faqSection.offsetTop - 100, behavior: 'smooth' });
                } else {
                    faqSection.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
