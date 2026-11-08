<?php

namespace App\Mail;

use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $note;

    public function __construct(Orders $order, $note = null)
    {
        $this->order = $order;
        $this->note = $note;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Action Required: Issue with your Khit PC Payment',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-rejected',
        );
    }
}
