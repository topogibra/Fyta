<?php

namespace App;
namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller{
    
    public function invoice($id)
    {
        $role = User::checkUser();
        if($role == User::$GUEST) {
            abort(401);
        }

        $order = Order::find($id);
        if(!$order) {
            abort(400);
        }

        $user_id = Auth::id();
        if($order->id_user != $user_id && $role == User::$CUSTOMER) {
            abort(403);
        }
        
        $products = Product::getOrderProducts($id);
        $information = Order::getOrderInformation($id);
        $status = Order::getOrderStatus($id);

        $sum = 0;
        foreach($products as $product)
        {
            $sum += $product->quantity * $product->price;
        }

        return view('pages.invoice', ['information' => $information, 'status'=> $status,'sum' => $sum, 'delivery' => 'FREE', 'items' => $products]);
    }

    public function order($id)
    {
        if(!Auth::check()) {
            abort(401);
        }

        $order = Order::find($id);
        if(!$order) {
            abort(400);
        }
        $user = Auth::user();
        if($user->user_role != "Manager") {
            abort(403);
        }

        $products = Product::getOrderProducts($id);
        $information = Order::getOrderInformation($id);
        $status = Order::getOrderStatus($id);

        $sum = 0;
        foreach($products as $product)
        {
            $sum += $product->quantity * $product->price;
        }

        return view('pages.invoice', ['information' => $information, 'status'=> $status,'sum' => $sum, 'delivery' => 'FREE', 'items' => $products]);
    }

    
}