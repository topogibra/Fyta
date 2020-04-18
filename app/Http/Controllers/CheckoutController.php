<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller{
    public function details()
    {
        $response = User::validateCustomer();
        if($response)
            abort($response);
        
        $user = Auth::user();
        $output = str_replace(' ', '&nbsp;', $user->address);
        return view('pages.order_summary', [ 'email' => $user->email , 'address' => $output]);
    }

    public function payment()
    {
        $response = User::validateCustomer();
        if($response)
            abort($response);

        return view('pages.payment_details');
    }

    public function summary($order_id) //NOTE: the order_id is not being passed anywhere
    {
        $response = User::validateCustomer();
        if($response)
            abort($response);
        
        $products = Product::getOrderProducts($order_id);
        $information = Order::getOrderInformation($order_id);
        $status = Order::getOrderStatus($order_id);
        
        $sum = 0;
        foreach($products as $product)
        {
            $sum += $product->quantity * $product->price;
        }
        return view('pages.checkout_details', [ 'information' => $information, 'status'=> $status,'sum' => $sum , 'delivery'=> 'FREE' ,'items' => $products]);
    }

    public function cart()
    {
        $role = User::checkUser();
        if($role == User::$GUEST)
            abort(401);
        else if($role == User::$MANAGER)
            return back();
        
        $id = Auth::id();
        $shopping_cart = Product::getShoppingCart($id);

        return view('pages.cart', ['items' => $shopping_cart]);
    }

   
}