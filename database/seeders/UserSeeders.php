<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Techfix',
            'email' => 'admin@techfix.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pengguna Biasa',
            'email' => 'user@techfix.com',
            'password' => Hash::make('user123'),
            'role' => 'pengguna',
        ]);
    }
}

