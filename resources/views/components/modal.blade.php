<div x-data="{ open: false }">
    <button @click="open = true" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Pesan Sekarang</button>

    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] md:w-1/2 max-w-xl">
            <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Pesan Jasa Servis</h2>

            <form action="{{ route('order.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold">Nama</label>
                    <input type="text" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Alamat</label>
                    <input type="text" name="address" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Nomor Telepon</label>
                    <input type="text" name="phone" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Alat Elektronik</label>
                    <input type="text" name="device" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold">Deskripsi Kerusakan</label>
                    <textarea name="description" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 outline-none" required></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="open = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
                    <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-bold">Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
