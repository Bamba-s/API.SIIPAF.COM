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
    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $mailData)
    {
        //
        $this->mailData = $mailData;
     }
   
    public function build()
    {
        return $this ->subject('Nouveau message du formulaire de contact')
           ->view('emails.contact-submitted')
           ->with([
                'name' => $this->mailData->name,
                'telephone' => $this->mailData->telephone,
                'email' => $this->mailData->email,
                'message' => $this->mailData->message,
                'service' => $this->mailData->service,
            ]);
             }
  
             }
