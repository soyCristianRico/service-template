<?php

declare(strict_types=1);

namespace App\Mail\Lead;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Lead $lead) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo lead: '.$this->lead->name,
            replyTo: [$this->lead->email],
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.leads.new');
    }
}
