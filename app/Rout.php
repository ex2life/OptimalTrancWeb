<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rout extends Model
{
    //
    public function cities() {

        return $this->belongsToMany(City::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
