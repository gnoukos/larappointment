<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;

    public function parent(){
        return $this->belongsTo('App\Option', 'parent');
    }

    public function children(){
        return $this->hasMany('App\Option', 'parent');
    }
}
