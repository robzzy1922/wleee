<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pesanan; 

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Pesanan::create([
            'nama_pelanggan' => 'Fia',
            'perangkat' => 'Laptop',
            'tanggal_pesanan' => '2025-03-27',
            'total_biaya' => 500000,
            'metode_pembayaran' => 'Gopay',
            'status_pembayaran' => 'Lunas',
            'status' => 'diproses'
        ]);
    }
}
