<?php

namespace App\Console\Commands;

use App\Jobs\appointmentReminderJob;
use App\Timeslot;
use Carbon\Carbon;
use DemeterChain\C;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class appointmentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remind users for their upcoming appointments 1 day before';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timeslots = Timeslot::where('user_id', '!=', null)->where('slot', '>', Carbon::now())->where('slot', '<', Carbon::now()->addDay())->with('user')->get(); //to add days change the addDay parameter to 2,3,4...


        foreach ($timeslots as $timeslot){
            $parents = getTimeSlotOptionParentsArray($timeslot);
            $details['user'] = $timeslot->user;
            $details['timeslot'] = $timeslot;
            $details['parents'] = $parents;
            $remindJob = (new appointmentReminderJob($details))->delay(Carbon::now()->addSeconds(3));
            dispatch($remindJob);
        }

        Log::info("SUCCESSFULLY REMIND APPOINTMENTS!");
    }
}
