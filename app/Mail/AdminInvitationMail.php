<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Invitation;

class AdminInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;
    public $acceptUrl;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
        $this->acceptUrl = route('admin.invitation.accept', $invitation->invitation_token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have been invited to be a Khit PC Admin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-invite',
        );
    }
}
