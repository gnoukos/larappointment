<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentHours extends Model
{
    public function appointment(){
        return $this->belongsTo('App\Appointment', 'appointment_id');
    }
}
