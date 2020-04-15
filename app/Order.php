<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps  = false;
    
    protected $table = 'order';

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_order')->withPivot('quantity');
    }

    public function history()
    {
        return $this->hasMany('App\OrderHistory', 'id_order');
    }
}
