<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Payment;
use App\Models\ProgressPesanan;
use App\Models\Review;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    // Field yang bisa diisi
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'jenis_barang',
        'keluhan',
        'user_id',
        'customer_id',
        'tanggal_pemesanan',
        'status',
        'harga',
        'estimasi',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi ke ProgressPesanan
    public function progress()
    {
        return $this->hasMany(Pesanan::class, 'id', 'pesanan_id'); // Sesuaikan jika diperlukan
    }

    // Relasi ke Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    // app/Models/Pesanan.php

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
