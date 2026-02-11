<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentConfirmed extends Notification
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

        $qrString = base64_encode(json_encode([
            'trx_id' => $this->trx->id,
            'user_id' => $this->trx->user_id,
        ]));

        return (new MailMessage)
            ->subject('Pembayaran Berhasil - ' . env('APP_NAME') )
            ->greeting('Yth. ' . $this->trx->user->name)
            ->line('Kami ingin mengkonfirmasi bahwa pembayaran Anda untuk '.env('EVENT_NAME').' telah berhasil.')
            ->line('Sebagai bukti transaksi, kami lampirkan kode QR yang akan digunakan saat registrasi ulang di lokasi acara. Mohon simpan kode QR ini dengan baik dan tunjukkan kepada petugas registrasi saat kedatangan.')
            ->line(new HtmlString('<div style="text-align: center;padding-top: 20px;padding-bottom: 35px;"><img src="https://api.qrserver.com/v1/create-qr-code/?data='.$qrString.'&size=256x256" width="200"></div>'))
            ->line('Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di ' . env('EMAIL') . ' atau ' . env('PHONE') . '.')
            ->line('')
            ->line('Terima kasih atas partisipasi Anda')
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
