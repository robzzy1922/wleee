@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg max-w-lg">
    <h2 class="text-2xl font-bold mb-4">Pembayaran Pesanan #{{ $pesanan->id }}</h2>
    <p class="mb-2">Nama: <b>{{ $pesanan->nama }}</b></p>
    <p class="mb-2">Total Bayar: <b>Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</b></p>
    <button id="pay-button" class="bg-green-500 text-white px-6 py-2 rounded mt-6 hover:bg-green-600 transition">Bayar Sekarang</button>
    <a href="{{ route('customer.pesanan.detail', $pesanan->id) }}" class="ml-4 text-blue-600 hover:underline">Kembali ke Detail</a>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert(\"Pembayaran berhasil!\");
                window.location.href = \"{{ route('customer.pesanan.detail', $pesanan->id) }}\";
            },
            onPending: function(result){
                alert(\"Menunggu pembayaran...\");
                window.location.href = \"{{ route('customer.pesanan.detail', $pesanan->id) }}\";
            },
            onError: function(result){
                alert(\"Pembayaran gagal!\");
            }
        });
    };
</script>
@endsection