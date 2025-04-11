<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('layanans')->insert([
            ['nama' => 'Servis Laptop', 'deskripsi' => 'Perbaikan kerusakan umum', 'harga' => 150000],
            ['nama' => 'Servis HP', 'deskripsi' => 'Ganti layar atau baterai', 'harga' => 100000],
            ['nama' => 'Servis TV', 'deskripsi' => 'Perbaikan kerusakan internal', 'harga' => 200000],
        ]);
    }
}