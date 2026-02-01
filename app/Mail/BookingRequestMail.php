<?php

namespace App\Mail;

use App\Models\BookingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public BookingRequest $booking;

    /**
     * Create a new message instance.
     */
    public function __construct(BookingRequest $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Новая заявка на запись')
                    ->view('emails.booking_request')
                    ->with(['booking' => $this->booking]);
    }
}
