<?php

namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Attachment;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public array $ticketImages;

    public function __construct(Order $order, array $ticketImages)
    {
        $this->order = $order;
        $this->ticketImages = $ticketImages;
    }

    public function build(): static
    {
        return $this->subject('E-Tiket Sparkling Nganjuk Carnival #5')
        ->view('emails.ticket-confirmation');
    }
}
