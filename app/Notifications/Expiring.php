<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Expiring extends Notification
{
    use Queueable;
    public $trx;

    /**
     * Create a new notification instance.
     */
    public function __construct($props)
    {
        $this->trx = $props['trx'];
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
            ->subject('Pendaftaran Dibatalkan - ' . env('APP_NAME') )
            ->greeting('Yth. ' . $this->trx->user->name)
            ->line('Kami dari panitia ' . env('EVENT_NAME') . ' ingin menyampaikan terima kasih atas pendaftaran Anda.')
            ->line('')
            ->line('Namun, kami mohon maaf untuk memberitahukan bahwa pendaftaran Anda terpaksa kami batalkan karena telah melewati batas waktu pembayaran. Sesuai dengan ketentuan yang berlaku, pendaftaran yang tidak disertai pembayaran dalam batas waktu yang ditentukan akan otomatis dibatalkan oleh sistem.')
            ->line('Kami memahami bahwa hal ini mungkin menimbulkan ketidaknyamanan. Jika Anda masih berminat untuk mengikuti '.env('EVENT_NAME').', Anda dapat melakukan pendaftaran ulang.')
            ->action('Ulangi Pendaftaran', url('/'))
            ->line('Kami sangat menghargai minat Anda untuk berpartisipasi dalam acara ini dan berharap Anda dapat bergabung bersama kami di '.env('EVENT_NAME').' mendatang.')
            ->line('Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di ' . env('EMAIL') . ' atau ' . env('PHONE') . '.')
            ->line('')
            ->line('Terima kasih atas pengertiannya')
            ->line('')
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
