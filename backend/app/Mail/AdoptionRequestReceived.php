<?php

namespace App\Mail;

use App\Models\Adoption;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdoptionRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $adoption;

    /**
     * Create a new message instance.
     */
    public function __construct(Adoption $adoption)
    {
        $this->adoption = $adoption;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Adoption Request')
            ->view('emails.adoption-request-received')
            ->with([
                'catName' => $this->adoption->cat->name,
                'userName' => $this->adoption->user->name,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Adoption Request Received',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Send confirmation to the adopter.
     */
    public static function sendAdopterConfirmation(Adoption $adoption)
    {
        \Mail::to($adoption->user->email)->send(new AdoptionRequestConfirmation($adoption));
    }
}