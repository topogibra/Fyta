<?php

namespace App\Http\Controllers;
use App\Product;
use App\Image;
use App\Order;

//TODO:check if it is the right path
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller{
    public function details()
    {
        return view('pages.order_summary');
    }

    public function payment()
    {
        return view('pages.payment_details');
    }

    public function summary($order_id)
    {
        $products_image = Order::products()->belongsTo(Image::products(),'id_product');
        
        $products = $products_image 
            ->select('name','price','quantity','img_hash')
            ->where('order.id', '=', $order_id)
            ->get();

        $sum = 0;
        foreach ($products as $p) {
            $sum += $p->select('price') *  $p->select('quantity');
        }

        $order_info = Order::user()
                        ->select('shipping_id','order_date','user.username','user.address')
                        ->where('user_id', '=', 4)
                        ->get();

        //TODO: location; delivery tipe in db
        return view('pages.checkout_details', [$order_info,'location' => 'Calgary, Canada', 'sum' => $sum , 'delivery'=> 'FREE' ,'items' => $products]);
    }

    public function cart()
    {
        //TODO:
        //$user_id = Auth::id();
        $product_image = Product::shoppingCart()->belongsTo(Image::products(),'id_product');
        
        $shopping_cart = $product_image
                                    ->select('name','price','quantity','img_hash')
                                    ->where('user.id', '=', 2)
                                    //->offset(10*$n_page)
                                    //->limit(10)
                                    ->get();

        return view('pages.cart', ['items' => $shopping_cart]);
    }

}