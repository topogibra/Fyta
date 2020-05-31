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
    public function details(Request $request)
    {
        $response = User::validateCustomer();
        if ($response)
            abort($response);

        $item_ids = $request->session()->get('items', []);
        if (count($item_ids) == 0) {
            return response('No products in cart to checkout!', 400);
        }

        $user = Auth::user();
        $output = $user->address;
        return view('pages.order_summary', ['name' => $user->username, 'email' => $user->email, 'address' => $output]);
    }

    public function saveDetails(Request $request)
    {
        $request->validate(['name' => 'required', 'delivery' => 'required', 'billing' => 'nullable']);

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
            $order->products()->attach($product, ['quantity' => $quantity]);
            Product::updateStock($product, $quantity);
        }

        $history = new OrderHistory;
        $history->id_order = $order->id;
        $history->order_status = 'Awaiting_Payment';
        $history->save();

        DB::commit();
        $request->session()->forget('items');

        $user_id = Auth::id();
        if (request()->session()->get('buynow') != null) {
            request()->session()->forget('buynow');
        }

        Product::deleteShoppingCartIds($user_id);
        return redirect('/order-summary/' . $order->id);
    }

    public function confirmCart(Request $request)
    {
        $response = User::validateCustomer();
        if ($response)
            abort($response);

        $request->validate(['delivery' => 'required', 'billing' => 'nullable', 'payment' => 'required']);

        $id = Auth::id();
        $item_ids = $request->session()->get('items', []);
        if (count($item_ids) == 0) {
            return response('No products in cart!', 400);
        }

        if (request()->session()->get('buynow')) {
            Product::deleteShoppingCartIds($id);
            reset($item_ids);
            $product_id = key($item_ids);
            DB::table('shopping_cart')->insert(
                [
                    'id_user' => $id,
                    'id_product' => $product_id,
                    'quantity' => $item_ids[$product_id]
                ]

            );
        }

        $items = Product::getShoppingCart($id);
        $sum = 0;
        foreach ($items as $item) {
            $sum += $item->quantity * $item->price;
        }

        return view('pages.confirm_cart', [
            'delivery' => $request->input('delivery'),
            'billing' => $request->input('billing'),
            'items' => $items, 'sum' => $sum,
            'delivery_fee' => 'Free',
            'payment' => $request->input('payment'),
            'paymentPretty' => Order::paymentMethodString($request->input('payment'))
        ]);
    }


    public function payment(Request $request)
    {
        $response = User::validateCustomer();
        if ($response)
            abort($response);

        $request->validate(['delivery' => 'required', 'billing' => 'nullable', 'payment' => 'nullable']);
        $delivery = $request->input('delivery');
        $billing = $request->input('billing');

        return view('pages.payment_details', ['delivery' => $delivery, 'billing' => $billing, 'payment' => $request->input('payment')]);
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
        return view('pages.checkout_details', ['information' => $information, 'status' => $status, 'sum' => $sum, 'delivery' => 'Free', 'items' => $products]);
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
