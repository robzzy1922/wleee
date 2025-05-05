<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techfix - Katalog</title>
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

<body class="bg-[#00000] min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <nav class="bg-[#38E4D2] py-4 px-6 flex justify-between items-center relative">
        <h1 class="text-black text-2xl font-bold">Techfix</h1>
        <div class="flex space-x-6 items-center">
            <a href="{{ route('home') }}" class="text-black font-medium">Home</a>
            <!-- Dropdown -->
            <div class="relative">
                <button id="dropdown-button" onclick="toggleDropdown(event)"
                    class="text-black font-medium flex items-center">
                    Kami Menjual <span class="ml-1">▼</span>
                </button>
                <div id="dropdown-menu" class="absolute left-0 top-full mt-2 w-48 bg-white border border-gray-300 shadow-lg rounded-lg hidden z-50">
                    <a href="{{route('komputer')}}" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="{{ asset('images/image1.png')}}" class="w-5 h-5 mr-2">Perlengkapan Komputer
                    </a>
                    <a href="{{route('laptop')}}" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="{{ asset('images/image.png')}}" class="w-5 h-5 mr-2"> Laptop
                    </a>
                </div>
            </div>
            <a href="{{ route('faq') }}" class="text-black font-medium">FAQ</a>
            <a href="https://wa.me/083148140002?text=Halo%2C%20saya%20tertarik%20dengan%20aplikasi%20tabungan%20sekolahnya."
                target="_blank" class="text-black font-medium">Kontak</a>
            <a href="{{ route('login') }}"
                class="bg-[#E81500] text-black px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-[#C11200]">Masuk</a>
        </div>
    </nav>



    <div class="container">

        <div class="px-4 py-6">
            <h1 class="text-lg font-bold mb-4">Laptop</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Card 1 -->
                <!-- Card 1 -->
                <a href="{{route('akse-laptop')}}">
                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                        <img src="{{ asset('images/Laptop.jpg') }}" alt="PC" class="w-full h-40 object-cover">
                        <div class="p-4 text-center">
                            <p class="font-semibold text-sm">Laptop</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>


    <!-- Footer -->
    <footer class="bg-[#14B8A6] text-black py-10 px-6 mt-10">
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
        document.addEventListener('DOMContentLoaded', function() {
            const faqLink = document.getElementById('faq-link');
            const faqSection = document.getElementById('faq-section');

            faqLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (faqSection.style.display === 'none') {
                    faqSection.style.display = 'block';
                    window.scrollTo({
                        top: faqSection.offsetTop - 100,
                        behavior: 'smooth'
                    });
                } else {
                    faqSection.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
