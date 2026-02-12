<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionNotifySystem extends Notification
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
        $type = $this->submission->type;
        $file = $this->submission->file; // filename
        
        return (new MailMessage)
            ->subject('Submission ' . ucwords($type) . " - " . env('EVENT_NAME'))
            ->line('Berikut adalah detail dari Submission ' . ucwords($type) . " yang baru saja dikirim :")
            ->line('Nama                       : ' . $this->submission->name)
            ->line('Email                      : ' . $this->submission->email)
            ->line('Submission : ' . ucwords($type) . " (File Terlampir)")
            ->attach(
                public_path('storage/submission_' . $type . '/' . $file),
                [
                    'as' => $file
                ]
            );
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
