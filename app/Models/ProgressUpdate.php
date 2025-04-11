<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressUpdate extends Model
{
    protected $fillable = ['order_id', 'note'];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
