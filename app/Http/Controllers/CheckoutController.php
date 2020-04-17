<?php

namespace App\Http\Controllers;
use App\Product;
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

    public function summary()
    {
        //TODO:get real order id
        $products = Product::getOrderProducts(43);
        $information = Order::getOrderInformation(43);
        $status = Order::getOrderStatus(43);
        
        $sum = 0;
        foreach($products as $product)
        {
            $sum += $product->quantity * $product->price;
        }
        // //TODO: location; delivery tipe in db
        return view('pages.checkout_details', [ 'information' => $information, 'location' => 'Calgary, Canada', 'status'=> $status,'sum' => $sum , 'delivery'=> 'FREE' ,'items' => $products]);
    }

    public function cart()
    {
        // TODO:
        // $user_id = Auth::id();
        
        $shopping_cart = Product::getShoppingCart(48);

        return view('pages.cart', ['items' => $shopping_cart]);
    }

}