<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderHistory;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function details()
    {
        $response = User::validateCustomer();
        if ($response)
            abort($response);

        $user = Auth::user();
        $output = str_replace(' ', '&nbsp;', $user->address);
        return view('pages.order_summary', ['name'=> $user->username ,'email' => $user->email, 'address' => $output]);
    }

    public function saveDetails(Request $request)
    {
        $request->validate(['name' => 'required','delivery' => 'required', 'billing' => 'nullable']);

        if (count($request->session()->get('items', [])) == 0) {
            return response('No products in cart!', 400);
        }

        DB::beginTransaction();
        $order = new Order;
        $this->authorize('create', $order);
        if ($request->input('billing') != null) {
            $order->billing_address = $request->input('billing');
        }

        $order->username = $request->input('name');
        $order->delivery_address = $request->input('delivery');
        $order->payment_method = 'Bank_Transfer';
        $order->shipping_id = uniqid();
        $order->id_user = Auth::id();
        $order->save();

        foreach ($request->session()->get('items') as $product => $quantity) {
            Product::updateStock($product,$quantity);
            $order->products()->attach($product, ['quantity' => $quantity]);
        }

        $history = new OrderHistory;
        $history->id_order = $order->id;
        $history->order_status = 'Awaiting_Payment';
        $history->save();

        DB::commit();
        $request->session()->forget('items');

        $user_id = Auth::id();
        if (request()->session()->get('buynow') == null) {
            Product::deleteShoppingCartIds($user_id);
        } else
            request()->session()->forget('buynow');

        return redirect('/order-summary/' . $order->id);
    }

    public function payment()
    {
        $response = User::validateCustomer();
        if ($response)
            abort($response);

        return view('pages.payment_details');
    }

    public function summary($order_id)
    {

        $this->authorize('show', Order::find($order_id));
        $products = Product::getOrderProducts($order_id);
        $information = Order::getOrderInformation($order_id);
        $status = Order::getOrderStatus($order_id);

        $sum = 0;
        foreach ($products as $product) {
            $sum += $product->quantity * $product->price;
        }
        return view('pages.checkout_details', ['information' => $information, 'status' => $status, 'sum' => $sum, 'delivery' => 'FREE', 'items' => $products]);
    }

    public function cart()
    {
        $role = User::checkUser();
        if ($role == User::$GUEST)
            abort(401);
        else if ($role == User::$MANAGER)
            return redirect('/manager');

        $id = Auth::id();
        $shopping_cart = Product::getShoppingCart($id);

        return view('pages.cart', ['items' => $shopping_cart]);
    }
}
