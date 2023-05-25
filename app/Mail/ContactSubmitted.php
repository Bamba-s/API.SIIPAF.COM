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

    public $mailData,$logoPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $mailData, $logoPath)
    {
        //
        $this->mailData = $mailData;
        $this->logoPath = $logoPath;
     }
   
    public function build()
    {
        return $this ->subject('Nouveau message du formulaire de contact')
           ->view('emails.contact-submitted')
           ->with([
                'logo' => $this->logoPath,
                'name' => $this->mailData->name,
                'telephone' => $this->mailData->telephone,
                'email' => $this->mailData->email,
                'message' => $this->mailData->message,
                'service' => $this->mailData->service,
            ]);
             }
  
             }
