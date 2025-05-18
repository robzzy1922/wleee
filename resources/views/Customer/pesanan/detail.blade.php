@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg max-w-screen-2xl pb-10">
        <h2 class="text-3xl font-bold mb-8">Daftar Pesanan/Riwayat Pesanan</h2>



        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border">#ID Pesanan</th>
                        <th class="px-4 py-3 border">Layanan/Barang</th>
                        <th class="px-4 py-3 border">Deskripsi Kerusakan</th>
                        <th class="px-4 py-3 border">Tanggal Pemesanan</th>
                        <th class="px-4 py-3 border text-center">Status</th>
                        <th class="px-4 py-3 border">Harga</th>
                        <th class="px-4 py-3 border text-center">Rating</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($pesanans as $pesanan)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-4 py-2 border font-semibold text-gray-700">{{ $pesanan->id }}</td>
                            <td class="px-4 py-2 border">{{ $pesanan->jenis_barang }}</td>
                            <td class="px-4 py-2 border">{{ $pesanan->keluhan }}</td>
                            <td class="px-4 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $pesanan->status == 'Selesai' ? 'bg-green-100 text-green-800' :
                                    ($pesanan->status == 'Dalam Proses Servis' ? 'bg-yellow-100 text-yellow-800' :
                                    'bg-blue-100 text-blue-800') }}">
                                    {{ $pesanan->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border">
                                Rp {{ number_format($pesanan->harga, 0, ',', '.') }}
                                <div>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $pesanan->payment_status == 'lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($pesanan->payment_status) }}
                                    </span>
                                </div>
                                @if ($pesanan->payment_status == 'belum bayar')
                                    <button
                                        id="pay-now-btn"
                                        data-pesanan-id="{{ $pesanan->id }}"
                                        class="bg-green-500 text-white text-sm px-3 py-1 rounded hover:bg-green-600 transition mt-2"
                                    >
                                        Bayar Sekarang
                                    </button>
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">
                                @if ($pesanan->status == 'Selesai')
                                    @php
                                        $existingReview = \App\Models\Review::where('pesanan_id', $pesanan->id)
                                            ->where('user_id', auth()->id())
                                            ->first();
                                    @endphp

                                    @if (!$existingReview)
                                        <form action="{{ route('review.store', ['orderId' => $pesanan->id]) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
                                            <input type="number" name="rating" min="1" max="5"
                                                class="w-16 text-center border border-gray-300 rounded" placeholder="★"
                                                required>
                                            <textarea name="komentar" rows="2" class="w-full border border-gray-300 rounded mt-2"
                                                placeholder="Tambahkan komentar" required></textarea>
                                            <button type="submit"
                                                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Kirim</button>
                                        </form>
                                    @else
                                        <div class="text-left">
                                            <p class="text-yellow-500">Rating: {{ $existingReview->rating }} ★</p>
                                            <p class="text-gray-700">Komentar: {{ $existingReview->comment }}</p>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const payBtn = document.getElementById('pay-now-btn');
        if (payBtn) {
            payBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const pesananId = payBtn.getAttribute('data-pesanan-id');
                fetch("{{ route('midtrans.create') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ pesanan_id: pesananId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.snapToken) {
                        window.snap.pay(data.snapToken, {
                            onSuccess: function(result){
                                alert("Pembayaran berhasil!");
                                window.location.reload();
                            },
                            onPending: function(result){
                                alert("Menunggu pembayaran...");
                                window.location.reload();
                            },
                            onError: function(result){
                                alert("Pembayaran gagal!");
                            }
                        });
                    } else {
                        alert("Gagal mendapatkan token pembayaran.");
                    }
                })
                .catch(() => alert("Terjadi kesalahan, coba lagi."));
            });
        }
    });
    </script>
@endsection
