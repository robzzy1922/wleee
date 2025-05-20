<?php

namespace App\Services\Payments;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationDecorator extends PaymentDecorator {
    public function process() {
        $result = parent::process();

        // Tambahkan notifikasi
        Notification::create([
            'user_id' => Auth::user()->id,
            'title' => 'Pembayaran Diproses',
            'message' => 'Pembayaran sebesar Rp.' . number_format($this->getAmount()) . ' sedang diproses',
            'target_role' => 'customer'
        ]);

        return $result;
    }
}
