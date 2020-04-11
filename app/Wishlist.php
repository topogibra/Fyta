<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'wishlist_product');
    }
}
