<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Broadcast extends Notification
{
    use Queueable;
    
    protected $user;
    protected $subject;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($props)
    {
        $this->user = $props['user'];
        $this->subject = $props['subject'];
        $this->message = $props['message'];
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
        $toReturn = (new MailMessage)
            ->subject($this->subject)
            ->greeting('Yth. ' . $this->user->name);

        $messages = explode(PHP_EOL, $this->message);

        foreach ($messages as $msg) {
            $toReturn->line($msg);
        }

        return $toReturn;
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
