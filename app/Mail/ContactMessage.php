<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новое сообщение с сайта FishShop: ' . $this->contactData['subject'],
            replyTo: [$this->contactData['email'] => $this->contactData['name']]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
