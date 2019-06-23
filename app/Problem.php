<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
