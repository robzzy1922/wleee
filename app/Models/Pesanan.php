<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Layanan;
use App\Models\Payment;
use App\Models\ProgressPesanan;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'midtrans_order_id',
        'midtrans_snap_token',
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
