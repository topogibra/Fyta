<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    public $timestamps  = false;

    protected $table = 'order_history';

    public function order()
    {
        return $this->belongsTo('App\Order', 'id_order');
    }
}
