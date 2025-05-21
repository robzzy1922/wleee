<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan di database
    protected $table = 'customers';

    // Kolom yang bisa diisi melalui mass assignment (untuk keamanan)
    protected $fillable = [
        'nama', // nama customer
        'email', // email customer
        'no_hp', // nomor handphone customer
        'foto_url', // URL foto profil customer (jika ada)
        'status', // status customer (aktif/nonaktif)
        'total_pesanan', // total pesanan yang telah dilakukan
    ];
}