<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

use App\Order;
use App\Product;
use Illuminate\Http\Request;

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

    public function saveDetails(Request $request)
    {
        $request->validate(['delivery' => 'required', 'billing' => 'nullable']);

        if(count($request->session()->get('items', [])) == 0){
            return response('No products in cart!', 400);
        }

        $order = new Order;
        if($request->input('billing') != null){
            $order->billing_address = $request->input('billing'); 
        }


        $order->delivery_address = $request->input('delivery');
        $order->payment_method = 'Bank_Transfer';
        $order->shipping_id = uniqid();
        $order->id_user = 1; //TODO: Change this to ID of the authenticated user
        $order->save();

        foreach ($request->session()->get('items') as $product => $quantity){
            $order->products()->attach($product, ['quantity' => $quantity]);
        }



        return redirect('/order-summary');
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