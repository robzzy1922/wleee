@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Riwayat Servis</h2>

    @forelse($riwayat as $item)
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <h3 class="text-lg font-semibold text-[#004AAD]">Pesanan #{{ $item->id }}</h3>
        <p class="text-sm text-gray-600">Status: {{ $item->status }}</p>

        @if ($item->status == 'Selesai')
            @if ($item->review)
                {{-- Sudah diberi review --}}
                <div class="mt-2">
                    <div class="flex items-center text-yellow-500 mb-1">
                        @for ($i = 0; $i < $item->review->rating; $i++)
                            ★
                        @endfor
                    </div>
                    <p class="italic text-gray-700">"{{ $item->review->comment }}"</p>
                </div>
            @else
                {{-- Belum diberi review --}}
                <form action="{{ route('review.store') }}" method="POST" class="mt-2 space-y-2">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $item->id }}">

                    <label class="block text-sm font-medium">Rating:</label>
                    <select name="rating" class="w-full border border-gray-300 rounded px-2 py-1">
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                        <option value="2">★★☆☆☆ (2)</option>
                        <option value="1">★☆☆☆☆ (1)</option>
                    </select>

                    <label class="block text-sm font-medium">Komentar:</label>
                    <textarea name="comment" rows="2" class="w-full border border-gray-300 rounded px-2 py-1" placeholder="Tulis ulasan kamu..."></textarea>

                    <button type="submit" class="bg-[#14B8A6] text-white px-4 py-1 rounded hover:bg-[#0D9488]">
                        Kirim Penilaian
                    </button>
                </form>
            @endif
        @endif
    </div>
    @empty
        <p class="text-center text-gray-500">Belum ada riwayat servis yang selesai.</p>
    @endforelse
</div>
@endsection
