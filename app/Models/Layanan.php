<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'deskripsi', 'harga'];

    // Relasi ke Order (jika dibutuhkan)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
