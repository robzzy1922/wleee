@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 p-8 bg-teal-300 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Pesan Jasa Servis</h2>

    <form method="POST" action="{{ route('customer.pesanan.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Nama</label>
                    <input type="text" name="nama" class="w-full p-2 rounded-lg shadow border border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Alamat</label>
                    <input type="text" name="alamat" class="w-full p-2 rounded-lg shadow border border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Nomor Telepon</label>
                    <input type="text" name="telepon" class="w-full p-2 rounded-lg shadow border border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="w-full p-2 rounded-lg shadow border border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" class="w-full p-2 rounded-lg shadow border border-gray-300" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi Pesanan</label>
                <textarea name="keluhan" rows="10" class="w-full p-3 rounded-lg shadow border border-gray-300 resize-none" required></textarea>
            </div>
        </div>

        <div class="mt-6 text-center">
            <button type="submit" class="bg-teal-600 text-white py-2 px-6 rounded-lg">
                Pesan
            </button>
        </div>
    </form>

    <!-- Menampilkan tombol pembayaran Midtrans -->
    @isset($snapToken)
        <div class="mt-8 text-center">
            <button id="pay-button" class="bg-green-500 text-white py-2 px-6 rounded-lg">
                Bayar Sekarang
            </button>
        </div>
    @endisset

</div>

@section('scripts')
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    @isset($snapToken)
        var payButton = document.getElementById('pay-button');

        payButton.onclick = function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert("Pembayaran Berhasil! " + JSON.stringify(result));
                    // Redirect to success page or handle result
                },
                onPending: function(result) {
                    alert("Pembayaran Tertunda: " + JSON.stringify(result));
                },
                onError: function(result) {
                    alert("Pembayaran Gagal: " + JSON.stringify(result));
                }
            });
        };
    @endisset
</script>
@endsection
@endsection
