<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketsEmail extends Mailable
{
   use Queueable, SerializesModels;

    public $transaction;
    public $tickets;

    public function __construct($transaction, $tickets)
    {
        $this->transaction = $transaction;
        $this->tickets = $tickets;
    }

    public function build()
    {
        return $this->subject('Tiket Pemesanan Anda - Wonderfull NTT')
                    ->markdown('emails.tickets');
    }
}
