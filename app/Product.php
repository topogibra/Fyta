<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps  = false;
    protected $table = 'product';


    public function orders()
    {
        return $this->belongsToMany('App\Order', 'product_order')->withPivot('quantity');
    }

    public function wishlists()
    {
        return $this->belongsToMany('App\Wishlist', 'wishlist_product');
    }

    public function shoppingCart()
    {
        return $this->belongsToMany('App\User', 'shopping_cart')->withPivot('quantity');
    }

    public function discounts()
    {
        return $this->belongsToMany('App\Discount', 'apply_discount');
    }

    public function images()
    {
        return $this->belongsToMany('App\Image', 'product_image', 'id_product', 'id_image');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'product_tag', 'id_product', 'id_tag');
    }
}
