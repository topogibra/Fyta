<?php

namespace App\Http\Controllers;

use DateTime;
use App\Product;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller{
    

    public function manager(){
        return view('pages.profile', ['layout' => ['scripts' => ['js/manager_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css']]]);
    }

    public function user(){
        return view('pages.profile', ['layout' => ['scripts' => ['js/profile_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css', 'css/homepage.css']]]);
    }

    public function orders() {
        $role = User::checkUser();
        if($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access your order history'], 401);
        }
        else if($role == User::$MANAGER)
            return response()->json(['message' => 'Managers can\'t access order history'], 403);
        
        $user = Auth::user();
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

    public function stocks() {
        $role = User::checkUser();
        if($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access stocks section'], 401);
        }
        else if($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);
        
    
        $products = Product::getStockProducts()->all();
        $clean_products = array_map(function($product) {
            $data = ['name'=> $product->name, 'price' => $product->price, 'stock' => $product->stock , 'id' => $product->id];
            return $data;
        }, $products);

        return $clean_products;
    }

    public function pending() {
        $role = User::checkUser();
        if($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access the pending orders'], 401);
        }
        else if($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);
        
        $allstatus = Order::getStatusOrders()->all();
        $clean_status = array_map(function($status) {
            $data = ['number' => $status->shipping_id, 'date' => $status->order_date, 'id' => $status->order_id ];
            $order_status = $status->order_status;
            $order_status  = preg_replace("(_)"," ",$order_status);
            $data['status'] = $order_status;
            $order_status;
            return $data;
        }, $allstatus);

        return $clean_status;
    }

    public function managers() {
        $role = User::checkUser();
        if($role == User::$GUEST) {
          return response()->json(['message' => 'You must login to access the pending orders'], 401);
        }
        else if($role == User::$CUSTOMER)
          return response()->json(['message' => 'You do not have access to this section'], 403);
        
        $user = Auth::user();
        $managers = $user->getManagersInfo()->all();
        $clean_managers = array_map(function($manager) {
            $data = ['name' => $manager->username, 'date' => $manager->date];
            $data['photo'] = 'img/' . $manager->img_name;
            return $data;
        }, $managers);

        return $clean_managers;
    }
    
    public function wishlist() {
        $role = User::checkUser();
        if($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access your wishlist'], 401);
        }
        else if($role == User::$MANAGER)
            return response()->json(['message' => 'Managers can\'t access wishlist'], 403);
        
        $user = Auth::user();
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

    public function profile(Request $request)
    {
      $role = User::checkUser();
      if($role == User::$GUEST)
        return response()->json(['message' => 'You must login to access your profile'], 401);

      if($request->path() == 'manager/get' && $role != User::$MANAGER)
        return response()->json(['message' => 'You do not have access to this section'], 403);
      
      if($request->path() == 'profile/get' && $role != User::$CUSTOMER)
      return response()->json(['message' => 'Managers can\'t access customer profile'], 403);
            
      $user = Auth::user();
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