@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6" x-data="{ openDetail: false, showToast: false, selectedOrder: null }">
    <h1 class="text-2xl font-bold mb-4">Kelola Pesanan</h1>

    <!-- Filter & Sorting -->
    <div class="flex justify-between items-center mb-4">
        <input type="text" placeholder="Cari pelanggan..." class="border px-4 py-2 rounded-lg">
        <select class="border px-4 py-2 rounded-lg">
            <option value="">Semua Status</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="ditolak">Ditolak</option>
        </select>
    </div>

    <!-- Tabel Pesanan -->
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Nama</th>
                <th class="border border-gray-300 px-4 py-2">Perangkat</th>
                <th class="border border-gray-300 px-4 py-2">Tanggal Pesanan</th>
                <th class="border border-gray-300 px-4 py-2">Total Biaya</th>
                <th class="border border-gray-300 px-4 py-2">Metode Pembayaran</th>
                <th class="border border-gray-300 px-4 py-2">Status Pembayaran</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanans as $pesanan)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $pesanan->nama_pelanggan }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $pesanan->perangkat }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $pesanan->tanggal_pesanan }}</td>
                <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($pesanan->total_biaya, 0, ',', '.') }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $pesanan->metode_pembayaran }}</td>
                <td class="border border-gray-300 px-4 py-2 {{ $pesanan->status_pembayaran == 'Lunas' ? 'text-green-500' : 'text-red-500' }}">
                    {{ $pesanan->status_pembayaran }}
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <select class="border px-2 py-1 rounded bg-white text-black"
                        onchange="updateStatus({{ $pesanan->id }}, this.value)">
                        <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $pesanan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <div class="relative inline-block">
                        <button class="bg-gray-500 text-white px-3 py-1 rounded" onclick="toggleMenu({{ $pesanan->id }})">
                            ⋮
                        </button>
                        <div id="menu-{{ $pesanan->id }}" class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg">
                            <button @click="openDetail = true; selectedOrder = {{ json_encode($pesanan) }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Detail</button>
                            <form action="{{ route('order.destroy', $pesanan->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block px-4 py-2 text-red-600 hover:bg-gray-100 w-full text-left">Hapus</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Detail Pesanan -->
<div x-show="openDetail" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" x-transition.opacity>
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Detail Pesanan</h2>

        <form :action="`/admin/pesanan/${selectedOrder.id}/konfirmasi`" method="POST">
            @csrf
            <p><strong>Nama:</strong> <span x-text="selectedOrder?.nama_pelanggan"></span></p>
            <p><strong>Perangkat:</strong> <span x-text="selectedOrder?.perangkat"></span></p>
            <p><strong>Tanggal Pesanan:</strong> <span x-text="selectedOrder?.tanggal_pesanan"></span></p>
            <p><strong>Total Biaya:</strong> Rp <span x-text="selectedOrder?.total_biaya"></span></p>
            <p><strong>Status Pembayaran:</strong> <span x-text="selectedOrder?.status_pembayaran"></span></p>

            <div class="mt-4">
                <label class="block font-semibold mb-1">Total Biaya (Rp)</label>
                <input type="number" name="harga" class="w-full border p-2 rounded" required>
            </div>
            <div class="mt-4">
                <label class="block font-semibold mb-1">Estimasi Waktu Pengerjaan</label>
                <input type="text" name="estimasi" class="w-full border p-2 rounded" placeholder="Contoh: 2 hari" required>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" @click="openDetail = false" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Tutup</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleMenu(orderId) {
        document.querySelectorAll('.relative .absolute').forEach(menu => {
            menu.classList.add('hidden');
        });
        document.getElementById(`menu-${orderId}`).classList.toggle('hidden');
    }

    function updateStatus(orderId, newStatus) {
        fetch(`/order/${orderId}/update-status`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Status berhasil diperbarui!");
            } else {
                alert("Gagal memperbarui status!");
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>
@endsection
