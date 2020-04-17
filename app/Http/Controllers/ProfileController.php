<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Illuminate\Support\Facades\Date;

class ProfileController extends Controller{

    public function manager(){
        return view('pages.profile', ['layout' => ['scripts' => ['js/manager_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css']]]);
    }

    public function user(){
        return view('pages.profile', ['layout' => ['scripts' => ['js/profile_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css', 'css/homepage.css']]]);
    }

    public function orders() {
        $user_id = 17; //TODO: get authenticated user
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
    
    public function wishlist() {
        $user_id = 17; //TODO: get authenticated user
        $user = User::find($user_id);
        $wishlist = $user->wishlists()->first(); //TODO: integrate multiple wishlists
        if($wishlist == null) {
            return [];
        }
        $products = $wishlist->products()->get()->all();
        $items = array_map(function($product){
            $data = ['name'=>$product->name,'price' => $product->price, 'id' => $product->id];
            $img = $product->images()->first();
            $data['img'] = 'img/' . $img->img_name;
            return $data;
        },$products);

        return $items;
    }

    public function profile()
    {
      $user_id = 17; //TODO: get authenticated user
      $user = User::find($user_id);
      $img = $user->image()->first();
      $photo = 'img/' . $img->img_name;
      $date = new DateTime($user->date);
      $year = $date->format('Y');
      $month = $date->format('M');
      $day = $date->format('d');
      $data = ['username' => $user->username, 'email' => $user->email, 'address' => $user->address, 'year' => $year, 'month' => $month, 'day' => $day,'photo' => $photo];
      return $data;
    }
}