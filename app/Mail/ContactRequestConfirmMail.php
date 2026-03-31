<?php

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRequestConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactRequest $contactRequest) {}

    public function build()
    {
        return $this
            ->subject('Richiesta ricevuta - Dott.ssa Cristina Pacifici')
            ->view('emails.contact-confirm', [
                'contactRequest' => $this->contactRequest,
            ]);
    }
}
