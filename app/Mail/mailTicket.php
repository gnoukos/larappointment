<?php

namespace App\Mail;

use App\Option;
use App\Timeslot;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Timeslot $timeslot, $parents, $startingHour)
    {
        $this->timeslot=$timeslot;
        $this->parents=$parents;
        $this->startingHour=$startingHour;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.mailTicket')->text('mails.mailTicketPlain')->subject("Get Your Ticket")->with(['timeslot'=>$this->timeslot, 'parents'=>$this->parents, 'startingHour'=>$this->startingHour]);
    }
}
