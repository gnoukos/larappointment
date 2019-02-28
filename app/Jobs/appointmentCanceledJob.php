<?php

namespace App\Jobs;

use App\Mail\appointmentCanceled;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\appointmentReminder;
use Mail;

class appointmentCanceledJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->details['user'])->send(new appointmentCanceled($this->details['timeslot'], $this->details['parents']));

        $parents=$this->details['parents'];

        $parentsPath='';
        for ($i=0; $i<count($parents); $i++ ) {
            if ($i != count($parents) - 1) {
                $parentsPath .= $parents[$i]["title"] . '->';
            }else {
                $parentsPath .= $parents[$i]["title"];
            }
        }

        $dateInfo=Carbon::parse($this->details['timeslot']->slot)->format('l d/m/Y H:i');

        $smsMessage=config('app.name').', your appointment for '.$parentsPath.' at '.$dateInfo.' has been cancelled';

        send_sms($this->details['user']->mobile_num,$smsMessage);

    }
}
