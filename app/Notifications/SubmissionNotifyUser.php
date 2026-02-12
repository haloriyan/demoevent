<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionNotifyUser extends Notification
{
    use Queueable;
    public $submission;

    /**
     * Create a new notification instance.
     */
    public function __construct($props)
    {
        $this->submission = $props['submission'];
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
            ->subject('Kami Telah Menerima Submission ' . ucwords($this->submission->type) . " Anda! - " . env('EVENT_NAME'))
            ->greeting('Yth. ' . $this->submission->name)
            ->line('Terima kasih telah berpartisipasi dalam Submission ' . ucwords($this->submission->type) . " dalam rangkaian acara " . env('EVENT_NAME'))
            ->line('Dan perlu Kami sampaikan kembali bahwa kriteria dan hasil penilaian merupakan kewenangan para juri sepenuhnya dan tidak dapat diganggu-gugat.');
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
