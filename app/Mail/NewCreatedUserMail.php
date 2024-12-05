<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCreatedUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $base_url;

    /**
     * Create a new message instance.
     */
    public function __construct($token, $base_url)
    {
        $this->token = $token;
        $this->base_url = $base_url;
    }

    private function resetUrl(): string
    {
        return $this->base_url . route('frontend.password.reset', [
            'token' => $this->token,
        ], false);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Welcome to '.config('app.name');

        return new Envelope(
            subject: $subject,
        );
    }

    
   
    public function content(): Content
    {
        $reset_url = $this->resetUrl();
        $app_name = config('app.name');

        return new Content(
            view: 'emails.new-user-notification',  // The view where we render the dynamic content
            with: ['reset_url' => $reset_url, 'app_name' => $app_name]
        );
    }
    

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
