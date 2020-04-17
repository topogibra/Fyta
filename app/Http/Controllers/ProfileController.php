<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller{

    public function manager(){
        return view('pages.profile', ['layout' => ['scripts' => ['js/manager_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css']]]);
    }

    public function user(){
        return view('pages.profile', ['layout' => ['scripts' => ['js/profile_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css', 'css/homepage.css']]]);
    }

    public function orders() {
        $user_id = 5; //TODO: get authenticated user
        $user = User::find($user_id);
        $orders = $user->orders()->get()->all();
        $clean_orders = array_map(function($order) {
            $data = ['number'=> $order->shipping_id, 'date' => $order->order_date,'id' => $order->id];
            $order_status = $order->history()->orderBy('date','desc')->first();
            $order_price = array_sum(array_map(function($product){
                return $product->price * $product->pivot->quantity;
            },$order->products()->get()->all()));
            $data['state'] = $order_status->order_status;
            $data['price'] = $order_price;
            return $data;
        }, $orders);

        return $clean_orders;
    }
}