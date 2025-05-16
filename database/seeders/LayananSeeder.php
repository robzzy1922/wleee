<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('layanans')->insert([
            [
                'nama' => 'Servis Laptop',
                'deskripsi' => 'Perbaikan kerusakan umum',
                'harga' => 150000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Servis HP',
                'deskripsi' => 'Ganti layar atau baterai',
                'harga' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Servis TV',
                'deskripsi' => 'Perbaikan kerusakan internal',
                'harga' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}