<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model{
    public $timestamps  = false;

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_image');
    }
}