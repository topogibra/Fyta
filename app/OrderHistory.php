<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    public $timestamps  = false;

    public function order()
    {
        return $this->belongsTo('App\Order', 'id_order');
    }
}
