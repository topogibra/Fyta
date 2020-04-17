<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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

    public function summary(Request $request, $order_id)
    {
        $products = Product::getOrderProducts($order_id);
        $information = Order::getOrderInformation($order_id);
        $status = Order::getOrderStatus($order_id);
        
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