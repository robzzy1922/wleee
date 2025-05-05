<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalog'; // Nama tabel

    protected $fillable = [
        'nama_barang',
        'kategori',
        'link',
        'harga',
        'gambar',
    ];
    
}
