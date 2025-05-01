@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-[#004AAD]">Riwayat Servis</h2>

    @forelse($riwayat as $item)
    <div class="bg-gray-50 p-4 rounded-lg shadow mb-6">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-[#004AAD]">{{ $item->nama_barang }}</h3>
            <span class="text-sm font-medium {{ $item->status == 'Selesai' ? 'text-green-600' : 'text-gray-600' }}">
                {{ $item->status }}
            </span>
        </div>
        <p class="text-sm text-gray-600">Kerusakan: {{ $item->kerusakan }}</p>
        <p class="text-sm text-gray-600">Biaya: {{ $item->biaya ? 'Rp ' . number_format($item->biaya, 0, ',', '.') : '-' }}</p>

        @if($item->status == 'Selesai')
            @if ($item->review)
                {{-- Tampilkan Review --}}
                <div class="flex items-center mt-3 mb-1">
                    @for ($i = 0; $i < $item->review->rating; $i++)
                        <span class="text-yellow-400 text-lg">★</span>
                    @endfor
                    @for ($i = $item->review->rating; $i < 5; $i++)
                        <span class="text-gray-300 text-lg">★</span>
                    @endfor
                </div>
                <p class="italic text-gray-700">"{{ $item->review->comment }}"</p>
            @else
                {{-- Form Review --}}
                <form action="{{ route('review.store') }}" method="POST" class="mt-3 space-y-2">
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

                    <button type="submit" class="bg-[#14B8A6] text-white px-4 py-2 rounded hover:bg-[#0D9488]">
                        Kirim Penilaian
                    </button>
                </form>
            @endif
        @endif
    </div>
    @empty
        <div class="text-center text-gray-500 mt-10">
            Belum ada riwayat servis yang selesai atau dibatalkan.
        </div>
    @endforelse
</div>
@endsection
