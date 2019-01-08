<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dailyAppointment extends Model
{
    public $timestamps = false;

/*    public function timeslots(){
        return $this->hasMany('\App\Timeslot');
    }

    public function appointment(){
        return $this->belongsTo('App\Appointment', 'appointments_id');
    }*/
}
