<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Layanan;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    // Field yang bisa diisi
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'telepon',
        'jenis_barang',
        'tanggal_pemesanan',
        'keluhan',
        'status',
    ];

    // Relasi ke User (optional tapi berguna banget nanti)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function payment()
{
    return $this->hasOne(Payment::class);
}

public function progressTimeline()
{
    return $this->hasMany(ProgressPesanan::class);
}

public function customer()
{
    return $this->belongsTo(User::class, 'customer_id'); // ganti ke model yang sesuai
}

public function layanan()
{
    return $this->belongsTo(Layanan::class, 'layanan_id'); // pastikan 'layanan_id' sesuai dengan nama kolom foreign key
}

public function progress()
{
    return $this->hasMany(ProgressPesanan::class, 'pesanan_id');
}
}
