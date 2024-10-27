<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Quote;


class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $pdf;
    public $fileName;
    public $fromAddress;

    public function __construct($quote, $pdf, $fileName, $fromAddress)
    {
        $this->quote = $quote;
        $this->pdf = $pdf;
        $this->fileName = $fileName;
        $this->fromAddress = $fromAddress;
    }

    // public function build()
    // {
    //     return $this->view('emails.quote')
    //                 ->subject('Your Quote from Tapis Corporation')
    //                 ->attachData($this->pdf, $this->fileName, [
    //                     'mime' => 'application/pdf',
    //                 ]);
    // }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromAddress)
                    ->view('emails.quote')
                    ->with(['quote' => $this->quote])
                    ->attachData($this->pdf, $this->fileName, [
                        'mime' => 'application/pdf',
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quote Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote',
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

