<div x-data="{ openEditProfile: false }">
    <!-- Tombol pemicu -->
    <button @click="openEditProfile = true" class="hidden" id="openEditProfileButton"></button>

    <!-- Modal -->
    <div x-show="openEditProfile" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
        x-transition.opacity
        x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Edit Profil</h2>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST') 
                <div class="mb-4">
                    <label class="block text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Foto Profil</label>
                    <input type="file" name="photo" class="w-full p-2 border rounded">
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="openEditProfile = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
