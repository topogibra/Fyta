<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $timestamps  = false;
    
    protected $table = 'discount';

    public function products()
    {
        return $this->belongsToMany('App\Product', 'apply_discount');
    }

    
}
