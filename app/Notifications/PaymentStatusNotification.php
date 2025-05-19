<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pesanan;

class PaymentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $statusMessages = [
            'lunas' => 'Pembayaran Anda telah berhasil',
            'ditolak' => 'Pembayaran Anda ditolak oleh sistem',
            'kadaluarsa' => 'Pembayaran Anda telah kadaluarsa',
            'batal' => 'Pembayaran Anda telah dibatalkan'
        ];

        return [
            'pesanan_id' => $this->pesanan->id,
            'title' => 'Status Pembayaran',
            'message' => $statusMessages[$this->pesanan->payment_status] ?? 'Status pembayaran berubah',
            'status' => $this->pesanan->payment_status
        ];
    }
}
