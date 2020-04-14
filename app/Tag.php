<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps  = false;

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}
