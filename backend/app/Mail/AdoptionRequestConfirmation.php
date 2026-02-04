<?php

namespace App\Mail;

use App\Models\Adoption;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdoptionRequestConfirmation extends Mailable
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
        return $this->subject('Adoption Request Confirmation')
            ->view('emails.adoption-request-confirmation')
            ->with([
                'catName' => $this->adoption->cat->name,
                'userName' => $this->adoption->user->name,
            ]);
    }
}