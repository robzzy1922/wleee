<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCustomerOrderStatus implements ShouldQueue
{
    public function handle(OrderStatusUpdated $event)
    {
        $customer = $event->order->customer;

        if ($customer) {
            Notification::create([
                'user_id' => $customer->id, // Kirim notifikasi ke customer yang punya pesanan ini
                'title'   => 'Status Pesanan Diperbarui',
                'message' => "Pesanan Anda kini berstatus: {$event->order->status}",
            ]);
        }
    }
}
