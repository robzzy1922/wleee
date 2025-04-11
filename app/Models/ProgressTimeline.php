<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressTimeline extends Model
{
    protected $table = 'progress_timeline';
    protected $fillable = ['pesanan_id', 'status', 'catatan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}

