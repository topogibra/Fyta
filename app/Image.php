<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model{
    public $timestamps  = false;
    protected $table = 'image';

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_image');
    }
}