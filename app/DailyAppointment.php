<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyAppointment extends Model
{
    public $timestamps = false;

    public function timeslots()
    {
        return $this->hasMany('\App\Timeslot', 'daily_appointments_id');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Appointment', 'appointment_id');
    }

}
