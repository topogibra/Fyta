<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps  = false;

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'id_order');
    }

}
