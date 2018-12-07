<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function option(){
        return $this->belongsTo('\App\Option', 'belong_to_option');
    }

    public function appointment_hours(){
        return $this->hasMany('\App\AppointmentHours');
    }
}
