<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotification
{
    use InteractsWithQueue;

    public function handle(OrderStatusUpdated $event)
    {
        $order = $event->order;

        // Kirim notifikasi ke customer
        Notification::create([
            'user_id' => $order->customer_id,
            'title' => 'Status Pesanan Diperbarui',
            'message' => "Pesanan Anda kini berstatus: {$order->status}",
        ]);
    }
}