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
        $response = $this->validateCustomer();
        if($response)
            abort($response);
        
        $user = Auth::user();
        $output = str_replace(' ', '&nbsp;', $user->address);
        return view('pages.order_summary', [ 'email' => $user->email , 'address' => $output]);
    }

    public function payment()
    {
        $response = $this->validateCustomer();
        if($response)
            abort($response);

        return view('pages.payment_details');
    }

    public function summary(Request $request, $order_id) //NOTE: the order_id is not being passed anywhere
    {
        $response = $this->validateCustomer();
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
        // //TODO: location; delivery tipe in db
        return view('pages.checkout_details', [ 'information' => $information, 'location' => 'Calgary, Canada', 'status'=> $status,'sum' => $sum , 'delivery'=> 'FREE' ,'items' => $products]);
    }

    public function cart()
    {
        $response = $this->validateCustomer();
        if($response)
            abort($response);
        
        $id = Auth::id();
        $shopping_cart = Product::getShoppingCart($id);

        return view('pages.cart', ['items' => $shopping_cart]);
    }

    public function validateCustomer()
    {
        $role = ProfileController::checkUser();
        if($role == ProfileController::$GUEST) {
            return 401;
        }
        else if($role == ProfileController::$MANAGER)
            return 403;
        
        return null;
    }
}