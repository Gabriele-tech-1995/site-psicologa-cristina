<?php

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactRequest $contactRequest) {}

    public function build()
    {
        return $this
            ->subject('Nuova richiesta dal sito')
            ->replyTo($this->contactRequest->email, $this->contactRequest->name)
            ->view('emails.contact-request', [
                'contactRequest' => $this->contactRequest,
            ]);
    }
}
