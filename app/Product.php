<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany('App\Image', 'product_image');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','product_tag','id_product','id_tag');
    }

    public static function getTopByTag($tag)
    {
        $top_items = DB::table('product')
                        ->select('product.id','product.name','price')
                        ->join('product_tag','product.id','=','product_tag.id_product')
                        ->join('tag','tag.id','=','product_tag.id_tag')
                        ->where('tag.name',$tag)
                        ->orderByDesc('views')
                        ->limit(4);
        $product_imgs = DB::table('image')
                            ->select('top_items.id as id','top_items.name','price','img_name as img','description as alt')
                            ->join('product_image','product_image.id_image','=','image.id')
                            ->joinSub($top_items, 'top_items',function($join) {
                                $join->on('top_items.id','=','product_image.id_product');
                            })
                            ->get();
        //parse the images directories
        foreach($product_imgs as $product) {
            $product->img = 'img/' . $product->img; 
        }
        return $product_imgs;
    }

    public static function getByID($id) 
    {
        $product_img = DB::table('product')
                            ->select('product.name','price','product.description','img_name as img')
                            ->join('product_image','product_image.id_product','=','product.id')
                            ->join('image', 'image.id','=','product_image.id_image')
                            ->where('product.id','=',$id)
                            ->first();
        $product_img->img = 'img/' . $product_img->img;
        return $product_img;
    }
}
