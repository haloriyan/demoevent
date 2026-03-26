<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailChanged extends Notification
{
    use Queueable;
    public $user;
    public $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($props)
    {
        $this->user = $props['user'];
        $this->email = $props['email'];
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
            ->subject('Email Berubah - ' . env('APP_NAME') )
            ->greeting('Yth. ' . $this->user->name)
            ->line('Kami ingin memberitahu Anda bahwa email yang didaftarkan pada ' . env('APP_NAME') . '  telah berhasil diubah.')
            ->line('Seluruh komunikasi dan pemberitahuan akan kami kirimkan melalui email baru Anda berikut ini :')
            ->line(new HtmlString('<div style="background: #eeeeee;color: #444444;padding: 10px;border-radius: 8px;text-align: center;padding-vertical: 10px;margin-bottom: 12px;font-size: 18px;">'.$this->email.'</div>'))
            ->line('Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami di ' . env('EMAIL') . ' atau ' . env('PHONE') . '.')
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
