<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'tanggal',
        'jumlah',
        'metode',
        'status',
    ];
    
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}

