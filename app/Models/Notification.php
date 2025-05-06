<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
        'target_role'
    ];

    // Hubungan ke user (yang menerima notifikasi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
