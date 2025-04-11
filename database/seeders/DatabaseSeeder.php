<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini!

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Techfix',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Sekarang Hash sudah dikenali
            'role' => 'admin', // Pastikan field 'role' ada di tabel users
        ]);
        $this->call(LayananSeeder::class);
    }
}
