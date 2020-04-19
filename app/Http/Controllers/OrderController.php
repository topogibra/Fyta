<?php

namespace App;
namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\OrderHistory;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller{
    
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

    public function update(Request $request) 
    {
        $role = User::checkUser();
        if($role != User::$MANAGER) {
            return response()->json(['message' => 'You do not have access to this operation.'], 403);
        }

        $request->validate([
            'order_id' => ['required','numeric'],
            'order_status' => ['required'],
        ]);
        
        $order = Order::find($request->id_order);
        if(!$order) {
            return response()->json(['message' => 'The order does not exist.'], 404);
        }
        
        $status = $request->input('order_status');
        switch($status) {
            case 'Awaiting_Payment':
            case 'Ready_for_Shipping':
            case 'Processed':
                break;
            default:
                return response()->json(['message' => 'The status is invalid.'], 400);
        }

        $order_h = new OrderHistory;
        $order_h->date = now();
        $order_h->id_order = $request->input('order_id');
        $order_h->order_status = $status;
        $order_h->save();

        $order_h->order()->associate($order->id);

        return response()->json(['message' => 'Order updated successfully.'], 200);
    }
}