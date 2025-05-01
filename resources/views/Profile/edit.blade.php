@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Main Content -->
    <div class="flex-1 p-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Profil</h2>

        <div class="bg-white p-8 rounded-lg shadow-md  mb-5">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col items-center mb-6">
                    <!-- Foto Profil Preview -->
                    <img id="preview-image"
                    src="{{ Auth::user()->photo
                        ? asset('storage/' . Auth::user()->photo)
                        : asset('images/default-profile.png') }}"
                    class="w-32 h-32 rounded-full object-cover mb-4 border"
                    alt="Profile Picture">

                    <!-- Upload Foto -->
                    <label for="photo" class="cursor-pointer bg-gray-200 px-4 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-300">
                        Pilih Foto
                    </label>
                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <p class="text-xs text-gray-500 mt-2">Ukuran disarankan: 200x200 px</p>
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                </div>

                <!-- No Telepon -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium">No Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                </div>

                <!-- Password Baru (Opsional) -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium">Password Baru</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Kosongkan jika tidak ingin mengganti password">
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Ulangi password baru">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full transition duration-200">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Script Preview Gambar -->
<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function(){
        const preview = document.getElementById('preview-image');
        preview.src = reader.result;
    };
    if(input.files[0]){
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
