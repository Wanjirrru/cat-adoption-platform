<?php

namespace App\Mail;

use App\Models\Adoption;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdoptionDenied extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $adoption;
    public function __construct(Adoption $adoption)
    {
        $this->adoption = $adoption;
    }

    /**
     * Get the message envelope.
     */
    // Build the email
    public function build()
    {
        return $this->subject('Your Adoption Request has been Denied')
                    ->view('emails.adoption_denied');
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Adoption Denied',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

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