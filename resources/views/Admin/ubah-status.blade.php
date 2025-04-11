@extends('layouts.app')

@section('content')
<div class="p-4 max-w-xl mx-auto" x-data="{ status: '{{ $pesanan->status }}' }">
    <h2 class="text-xl font-semibold mb-4">Ubah Status Pesanan</h2>

    <form action="{{ route('admin.orders.updateStatus', $pesanan->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-medium">Status Sekarang</label>
            <p class="text-gray-700">{{ $pesanan->status }}</p>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Pilih Status Baru</label>
            <select name="status" id="status" x-model="status" class="mt-1 block w-full border rounded p-2">
                <option value="Menunggu Konfirmasi Admin">Menunggu Konfirmasi Admin</option>
                <option value="Menunggu Persetujuan Customer">Menunggu Persetujuan Customer</option>
                <option value="Dalam Proses Servis">Dalam Proses Servis</option>
                <option value="Selesai">Selesai</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>

        <!-- Estimasi & Harga muncul hanya saat status = Menunggu Persetujuan Customer -->
        <div x-show="status === 'Menunggu Persetujuan Customer'" class="space-y-4">
            <div>
                <label for="estimasi" class="block text-sm font-medium text-gray-700">Estimasi Waktu Servis</label>
                <input type="text" name="estimasi" id="estimasi" class="mt-1 block w-full border rounded p-2" placeholder="Contoh: 2 hari kerja">
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga Servis (Rp)</label>
                <input type="number" name="harga" id="harga" class="mt-1 block w-full border rounded p-2" placeholder="Contoh: 150000">
            </div>
        </div>

        <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
            <textarea name="catatan" id="catatan" rows="3" class="mt-1 block w-full border rounded p-2">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Status</button>
        </div>
    </form>
</div>
@endsection
