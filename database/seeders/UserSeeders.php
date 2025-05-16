<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Techfix',
            'email' => 'admin@techfix.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Regular user
        User::create([
            'name' => 'Pengguna Biasa',
            'email' => 'user@techfix.com',
            'password' => Hash::make('user123'),
            'role' => 'pengguna',
        ]);
    }
}
