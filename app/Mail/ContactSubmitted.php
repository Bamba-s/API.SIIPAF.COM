<?php

namespace App\Mail;

use App\Models\Forms\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        //
        $this->contact = $contact;
    }
    public function build()
    {
        return $this->view('emails.contact_submitted')
            ->subject('Formulaire de contact soumis')
            ->with([
                'name' => $this->contact->name,
                'telephone' => $this->contact->telephone,
                'message' => $this->contact->message,
                'service' => $this->contact->service,
            ]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Submitted',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.contact_submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
