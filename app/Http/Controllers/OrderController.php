<?php

namespace App;
namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\OrderHistory;
use App\User;
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

    public function buyNow($id)
    {
        if (User::validateCustomer())
            return redirect('/login');
        request()->session()->put('items', [$id => 1]);
        request()->session()->put('buynow', true);
        return redirect('checkout-details');
    }


    public function orders()
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access your order history'], 401);
        } else if ($role == User::$MANAGER)
            return response()->json(['message' => 'Managers can\'t access order history'], 403);

        $user = Auth::user();
        $orders = $user->orders()->get()->all();
        $clean_orders = array_map(function ($order) {
            $data = ['number' => $order->shipping_id, 'date' => $order->order_date, 'id' => $order->id];
            $order_status = $order->history()->orderBy('date', 'desc')->first();
            $order_price = array_sum(array_map(function ($product) {
                return $product->price * $product->pivot->quantity;
            }, $order->products()->get()->all()));
            $data['state'] = $order_status->order_status;
            $data['price'] = $order_price;
            return $data;
        }, $orders);

        return $clean_orders;
    }

    public function pending()
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access the pending orders'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);

        $allstatus = Order::getStatusOrders();
        $clean_status = array_map(function ($status) {
            $data = ['number' => $status->shipping_id, 'date' => $status->order_date, 'id' => $status->order_id];
            $order_status = $status->order_status;
            $order_status  = preg_replace("(_)", " ", $order_status);
            $data['status'] = $order_status;
            $order_status;
            return $data;
        }, $allstatus);

        return $clean_status;
    }

}