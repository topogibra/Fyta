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
        $this->authorize('show', Order::find($id));
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
        $this->authorize('show', Order::find($id));
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
        $request->validate([
            'order_id' => ['required','numeric'],
            'order_status' => ['required', 'string'],
        ]);
        
        $order = Order::find($request->input('order_id'));
        
        if(!$order) {
            return response()->json(['message' => 'The order does not exist.'], 404);
        }

        $this->authorize('update', $order);        
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