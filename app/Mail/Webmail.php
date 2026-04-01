<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class Webmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $bodies;
    public $uris = []; // uri path for attachments

    /**
     * Create a new message instance.
     */
    public function __construct($props)
    {
        $this->subject = $props['subject'];
        $this->bodies = $props['bodies'];
        $this->uris = $props['uris'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.webmail',
            with: [
                'subject' => $this->subject,
                'bodies' => $this->bodies,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $theURIs = [];
        foreach ($this->uris as $uri) {
            array_push(
                $theURIs, 
                Attachment::fromPath($uri)
            );
        }

        return $theURIs;
    }
}
