<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function routs() {
        return $this->hasMany('App/Rout');
    }
}
