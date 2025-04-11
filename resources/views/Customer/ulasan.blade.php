@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-xl font-bold mb-4">Ulasan & Rating</h1>
    <p>Beri ulasan dan penilaian untuk layanan kami. ⭐</p>

    <form action="#" method="POST" class="bg-white p-4 rounded shadow mt-4">
        @csrf
        <div class="mb-3">
            <label for="ulasan" class="block font-medium">Ulasan</label>
            <textarea name="ulasan" id="ulasan" rows="4" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="block font-medium">Rating</label>
            <select name="rating" id="rating" class="w-full border rounded px-3 py-2">
                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                <option value="4">⭐⭐⭐⭐ (4)</option>
                <option value="3">⭐⭐⭐ (3)</option>
                <option value="2">⭐⭐ (2)</option>
                <option value="1">⭐ (1)</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Kirim Ulasan
        </button>
    </form>
</div>
@endsection
