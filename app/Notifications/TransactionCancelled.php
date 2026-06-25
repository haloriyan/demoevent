<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionCancelled extends Notification
{
    use Queueable;
    public $user;
    public $trx;

    public function __construct($props)
    {
        $this->user = $props['user'];
        $this->trx = $props['trx'];
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembatalan Pendaftaran - ' . env('APP_NAME') )
            ->greeting('Yth. ' . $this->user->name)
            ->line('Kami informasikan bahwa pendaftaran Anda untuk '.env('EVENT_NAME').' telah dibatalkan.')
            ->line('')
            ->line('Detail Pendaftaran :')
            ->line('- NIK : ' . $this->user->nik)
            ->line('- No. Pendaftaran : #' . $this->trx->id)
            ->line('')
            ->line('Jika Anda merasa pembatalan ini adalah sebuah kesalahan atau ingin mendaftar kembali, silakan hubungi kami di ' . env('EMAIL') . ' atau ' . env('PHONE') . '.')
            ->line('')
            ->line('Terima kasih atas perhatian Anda.')
            ->line('')
            ->line('Hormat Kami,')
            ->line('Panitia ' . env('EVENT_NAME'));
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
