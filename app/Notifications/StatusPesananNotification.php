<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class StatusPesananNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $pesan;

    public function __construct($status, $pesan)
    {
        $this->status = $status;
        $this->pesan = $pesan;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->pesan,
            'status' => $this->status,
        ];
    }
}
