<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class RefundPaid extends Notification
{
    use Queueable;
    public $user;
    public $refund;

    /**
     * Create a new notification instance.
     */
    public function __construct($props)
    {
        $this->refund = $props['refund'];
        $this->user = $props['user'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengembalian Dana Berhasil - ' . env('APP_NAME') )
            ->greeting('Yth. ' . $this->user->name)
            ->line('Kami ingin memberitahu bahwa permintaan pembatalan Anda telah sepenuhnya berhasil dan dana telah dikembalikan ke rekening sesuai permintaan.')
            ->line('Berikut Kami lampirkan bukti pengembalian dana :')
            ->line(new HtmlString('<div><img src="'.env('APP_URL').'/storage/refund_evidences/'.$this->refund->payment_payload.'" /></div>'))
            ->line('Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di ' . env('EMAIL') . ' atau ' . env('PHONE') . '.')
            ->line('Hormat Kami,')
            ->line('Panitia ' . env('EVENT_NAME'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
