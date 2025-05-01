<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Payment;
use App\Models\ProgressUpdate;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'item_name',
        'status',
        'order_date',
        'layanan_id',
        'total_amount',
        'estimated_finish_date',
        'notes'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
{
    return $this->hasOne(Review::class);
}

public function customer()
{
    return $this->belongsTo(User::class, 'customer_id');
}

public function progressUpdates() {
    return $this->hasMany(ProgressUpdate::class);
}

public function layanan()
{
    return $this->belongsTo(Layanan::class, 'layanan_id'); // pastiin kolom ini juga bener
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
