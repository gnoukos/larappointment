<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function belong_to_option(){
        return $this->hasOne('App\Option', 'belong_to_option');
    }

    public function appointment_hours(){
        return $this->hasMany('App\AppointmentHours');
    }
}
