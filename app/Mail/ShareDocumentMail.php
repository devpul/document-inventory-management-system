<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShareDocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $sender;
    public $url;

    public function __construct($document, $sender)
    {
        $this->document = $document;
        $this->sender = $sender;

        // generate URL untuk diakses dari browser
        $this->url = asset('storage/documents/' . basename($document->file_attachment));
    }

    public function build()
    {
        return $this->subject('Dokumen dibagikan kepada Anda')
                    ->view('emails.share_document');
    }
}