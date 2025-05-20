@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg max-w-screen-2xl pb-10">
    <h2 class="text-3xl font-bold mb-8">Detail Pesanan #{{ $pesanan->id }}</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-300 rounded-lg overflow-hidden">
            <tr>
                <th class="px-4 py-3 border bg-gray-100">ID Pesanan</th>
                <td class="px-4 py-3 border">{{ $pesanan->id }}</td>
            </tr>
            <tr>
                <th class="px-4 py-3 border bg-gray-100">Jenis Barang</th>
                <td class="px-4 py-3 border">{{ $pesanan->jenis_barang }}</td>
            </tr>
            <tr>
                <th class="px-4 py-3 border bg-gray-100">Keluhan</th>
                <td class="px-4 py-3 border">{{ $pesanan->keluhan }}</td>
            </tr>
            <tr>
                <th class="px-4 py-3 border bg-gray-100">Status</th>
                <td class="px-4 py-3 border">
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $pesanan->status == 'Selesai' ? 'bg-green-100 text-green-800' :
                            ($pesanan->status == 'Dalam Proses Servis' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-blue-100 text-blue-800') }}">
                        {{ $pesanan->status }}
                    </span>
                </td>
            </tr>
            <tr>
                <th class="px-4 py-3 border bg-gray-100">Harga</th>
                <td class="px-4 py-3 border">
                    Rp {{ number_format($pesanan->harga, 0, ',', '.') }}
                    @if($pesanan->status === 'Selesai')

                    <button id="pay-button"
                        class="ml-4 bg-green-500 text-white text-sm px-4 py-2 rounded hover:bg-green-600 transition">
                        Bayar Sekarang
                    </button>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    @if($pesanan->status === 'Selesai' && !$pesanan->payment)
    <!-- Midtrans Snap -->
    <script type="text/javascript"
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    @if(isset($snapToken))
    <div class="mt-6 text-center">
        <button id="pay-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("customer.pembayaran") }}';
                        },
                        onPending: function(result) {
                            alert('Pembayaran dalam proses!');
                            window.location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal!');
                            console.log(result);
                        },
                        onClose: function() {
                            alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                        }
                    });
                };
    </script>
    @endif
    @endif
</div>
@endsection