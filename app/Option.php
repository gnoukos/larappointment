<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;
    protected $with = array('children');

    public function getParent()
    {
        return $this->belongsTo('\App\Option', 'parent');
    }

    public function children()
    {
        return $this->hasMany('\App\Option', 'parent');
    }
}
