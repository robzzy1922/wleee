@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow mt-10">
    <h2 class="text-xl font-semibold mb-4">Beri Penilaian untuk Order: {{ $order->nama_barang }}</h2>

<form method="POST" action="{{ route('review.store', $order->id) }}">
    @csrf
    <label for="rating">Rating (1-5):</label>
    <input type="number" name="rating" min="1" max="5" required class="border p-2 rounded">

    <br><br>

    <label for="komentar">Komentar:</label><br>
    <textarea name="komentar" rows="4" required class="border p-2 rounded w-full"></textarea>

    <br><br>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim Ulasan</button>
</form>
</div>
@endsection
