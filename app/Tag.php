<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps  = false;

    protected $table = 'tag';

    public function products()
    {
        return $this->belongsToMany('App\Product','product_tag','id_product','id_tag');
    }
}
