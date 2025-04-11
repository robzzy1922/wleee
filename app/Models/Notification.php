<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
    ];

    // Hubungan ke user (yang menerima notifikasi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
