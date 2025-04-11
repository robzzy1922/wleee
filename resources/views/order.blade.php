<!-- Modal Form Pemesanan -->
<div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-teal-500 p-6 rounded-lg shadow-lg w-[90%] md:w-3/4 max-w-3xl">
        <h2 class="text-2xl font-bold mb-4 text-center text-white">Pesan Jasa Servis</h2>

        <form action="{{ route('order.store') }}" method="POST" class="space-y-4 text-white">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Kolom Kiri -->
                <div class="space-y-3">
                    <div>
                        <label class="block font-semibold">Nama</label>
                        <input type="text" name="name" class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Alamat</label>
                        <input type="text" name="address" class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Nomor Telepon</label>
                        <input type="text" name="phone" class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                    </div>

                    <div>
                        <label class="block font-semibold">Alat Elektronik Yang Akan Diperbaiki</label>
                        <input type="text" name="device" class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                    </div>

                    <!-- Input Tanggal Pemesanan -->
                    <div>
                        <label class="block font-semibold">Tanggal Pemesanan</label>
                        <div class="flex space-x-2">
                            <input type="text" name="month" placeholder="Bulan" class="w-1/3 p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                            <input type="text" name="day" placeholder="Hari" class="w-1/3 p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                            <input type="text" name="year" placeholder="Tahun" class="w-1/3 p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-3">
                    <label class="block font-semibold">Deskripsi Pesanan</label>
                    <textarea name="description" class="w-full h-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:ring-2 focus:ring-white outline-none" required></textarea>
                </div>
            </div>

            <div class="flex justify-center space-x-4 mt-4">
                <button type="button" @click="open = false" class="bg-gray-500 text-white px-6 py-2 rounded-lg">Batal</button>
                <button type="submit" class="bg-white text-teal-600 px-6 py-2 rounded-lg font-bold hover:bg-gray-200">Pesan</button>
            </div>
        </form>
    </div>
</div>
