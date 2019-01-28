<?php

namespace App\Mail;

use App\Timeslot;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class successfullAssignation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Timeslot $timeslot)
    {
        $this->timeslot=$timeslot;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.successfulAssignation')->subject("Successful Assignation")->with('timeslot',$this->timeslot);
    }
}
