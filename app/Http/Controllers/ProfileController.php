<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Illuminate\Support\Facades\Date;
use App\Product;
use App\Order;

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

    public static function information() {
        $managers = User::getManagersInfo()->all();
        $clean_managers = array_map(function($manager) {
            $data = ['name' => $manager->username, 'date' => $manager->date];
            $data['photo'] = 'img/' . $manager->img_name;
            return $data;
        }, $managers);

        return $clean_managers;
    }

    public static function stocks() {
        $products = Product::getStockProducts()->all();
        $clean_products = array_map(function($product) {
            $data = ['name'=> $product->name, 'price' => $product->price, 'stock' => $product->stock ];
            return $data;
        }, $products);

        return $clean_products;
    }

    public static function pending() {
        $allstatus = Order::getStatusOrders()->all();
        $clean_status = array_map(function($status) {
            $data = ['number' => $status->shipping_id, 'date' => $status->order_date];
            $order_status = $status->order_status;
            $order_status  =preg_replace("(_)"," ",$order_status);
            $data['status'] = $order_status;
            $order_status;
            return $data;
        }, $allstatus);

        return $clean_status;
    }

    public static function managers() {
        $managers = User::getManagersInfo()->all();
        $clean_managers = array_map(function($manager) {
            $data = ['name' => $manager->username, 'date' => $manager->date];
            $data['photo'] = 'img/' . $manager->img_name;
            return $data;
        }, $managers);

        return $clean_managers;
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
      if($user->user_role == 'Customer')
      {
      $date = new DateTime($user->date);
      $year = $date->format('Y');
      $month = $date->format('M');
      $day = $date->format('d');
      $data = ['username' => $user->username, 'email' => $user->email, 'address' => $user->address, 'year' => $year, 'month' => $month, 'day' => $day,'photo' => $photo];
      }
      else
      {
        $data = ['username' => $user->username, 'email' => $user->email,'photo' => $photo];
      }

      return $data;
    }
}