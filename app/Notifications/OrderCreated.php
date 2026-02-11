<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification
{
    use Queueable;
    public $user;
    public $trx;

    /**
     * Create a new notification instance.
     */
    public function __construct($props)
    {
        $this->user = $props['user'];
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
        Carbon::setLocale('id');
        
        return (new MailMessage)
            ->subject('Pendaftaran Berhasil - ' . env('APP_NAME') )
            ->greeting('Yth. ' . $this->user->name)
            ->line('Kami ingin mengkonfirmasi bahwa pendaftaran Anda untuk '.env('EVENT_NAME').' telah berhasil.')
            ->line('')
            ->line('Berikut adalah detail pendaftaran Anda :')
            ->line('- NIK : ' . $this->user->nik)
            ->line('- Nama Lengkap : ' . $this->user->name)
            ->line('- Alamat Email : ' . $this->user->email)
            ->line('- Nomor Telepon : 0' . $this->user->whatsapp)
            ->line('- Kepesertaan : ' . $this->trx->ticket->name)
            ->line('- No. Pendaftaran : #' . $this->trx->id)
            ->line('')
            ->line(env('EVENT_NAME') .' akan diselenggarakan pada :')
            ->line('- Tanggal : ' . Carbon::parse($this->trx->ticket->start_date)->isoFormat('DD MMMM Y'))
            ->line('')
            ->line('Pembayaran dapat dilakukan dengan transfer ke rekening PERAMI')
            ->line('- Nominal : ' . currency_encode($this->trx->payment_amount))
            ->line('- Bank : ' . env('BANK_NAME'))
            ->line('- No. Rekening : ' . env('BANK_NUMBER'))
            ->line('')
            // ->line('Kemudian, mohon kirim foto bukti pembayaran beserta nomor pendaftaran kepada panitia melalui email mail@mail.com dan tunggu email konfirmasi pembayaran dari panitia')
            ->line('Kemudian mohon kirim foto bukti pembayaran melalui link berikut')

            ->action('Upload Bukti Pembayaran', route('pembayaran', $this->trx->id))
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
