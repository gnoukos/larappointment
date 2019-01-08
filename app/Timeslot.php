<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    public function daily_appointment(){
        return $this->belongsTo('App\DailyAppointment', 'daily_appointments_id');
    }
}
