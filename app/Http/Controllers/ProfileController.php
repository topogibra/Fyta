<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Image;
use DateTime;
use App\Product;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{


    public function manager()
    {
        return view('pages.profile', ['layout' => ['scripts' => ['js/manager_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css']]]);
    }

    public function user()
    {
        return view('pages.profile', ['layout' => ['scripts' => ['js/profile_page.js'], 'styles' => ['css/profile_page.css', 'css/registerpage.css', 'css/homepage.css']]]);
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

    public function stocks()
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access stocks section'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);


        $products = Product::getStockProducts()->all();
        $clean_products = array_map(function ($product) {
            $data = ['name' => $product->name, 'price' => $product->price, 'stock' => $product->stock, 'id' => $product->id];
            return $data;
        }, $products);

        return $clean_products;
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

    public function managers()
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access the pending orders'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);

        $user = Auth::user();
        $managers = $user->getManagersInfo()->all();
        $clean_managers = array_map(function ($manager) {
            $data = ['name' => $manager->username, 'date' => $manager->date, 'id' => $manager->id];
            $data['photo'] = 'img/' . $manager->img_name;
            $data['alt'] = $manager->alt;
            return $data;
        }, $managers);

        return $clean_managers;
    }

    public function wishlist()
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access your wishlist'], 401);
        } else if ($role == User::$MANAGER)
            return response()->json(['message' => 'Managers can\'t access wishlist'], 403);

        $user = Auth::user();
        $wishlist = $user->wishlists()->first(); //TODO: integrate multiple wishlists
        if ($wishlist == null) {
            return [];
        }
        $products = $wishlist->products()->get()->all();
        $items = array_map(function ($product) {
            $data = ['name' => $product->name, 'price' => $product->price, 'id' => $product->id];
            $img = $product->images()->first();
            $data['img'] = 'img/' . $img->img_name;
            return $data;
        }, $products);

        return $items;
    }

    public function addProductToWishlist($id)
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to add items to your wishlist'], 401);
        } else if ($role == User::$MANAGER)
            return response()->json(['message' => 'Managers can\'t add items to wishlists'], 403);
        

        $user = Auth::user();
        $wishlist = $user->wishlists()->first();
        if ($wishlist == null) {
            return [];
        }
        
        $wishlist->products()->attach($id);


        return response('Product added to wishlist');
    }

    public function removeProductFromWishlist($id)
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to add items to your wishlist'], 401);
        } else if ($role == User::$MANAGER)
            return response()->json(['message' => 'Managers can\'t add items to wishlists'], 403);


        $user = Auth::user();
        $wishlist = $user->wishlists()->first();
        if ($wishlist == null) {
            return [];
        }

        $wishlist->products()->detach($id);
        
        return response('Product removed to wishlist');
    }

    public function profile(Request $request)
    {
        $role = User::checkUser();
        if ($role == User::$GUEST)
            return response()->json(['message' => 'You must login to access your profile'], 401);

        if ($request->path() == 'manager/get' && $role != User::$MANAGER)
            return response()->json(['message' => 'You do not have access to this section'], 403);

        if ($request->path() == 'profile/get' && $role != User::$CUSTOMER)
            return response()->json(['message' => 'Managers can\'t access customer profile'], 403);

        $user = Auth::user();
        $img = $user->image()->first();
        if (!$img)
            $photo = 'img/user.png';
        else
            $photo = 'img/' . $img->img_name;

        if ($user->user_role == 'Customer') {
            $date = new DateTime($user->date);
            $year = $date->format('Y');
            $month = $date->format('M');
            $day = $date->format('d');
            $data = ['username' => $user->username, 'email' => $user->email, 'address' => $user->address, 'year' => $year, 'month' => $month, 'day' => $day, 'photo' => $photo];
        } else {
            $data = ['username' => $user->username, 'email' => $user->email, 'photo' => $photo];
        }

        return $data;
    }

    public function updateCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'birthday' => 'required|date',
            "address" => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }


        $user = Auth::user();
        $this->authorize('updateCustomer', $user);

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password_hash = bcrypt($request->input('password'));
        }
        $user->date = $request->input('birthday');
        $user->address = $request->input('address');
        $user->save();

        $file = Input::file('photo');
        if ($file != null)
            $this->storeNewPhoto($user, $file);
        return response('Saved successfully');
    }

    public function updateManager(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

        $user = Auth::user();
        $this->authorize('upsertManager', $user);
        return $this->upsertManager($request, $user);
    }

    public function createManager(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:user',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = new User();
        $user->user_role = 'Manager';
        $this->authorize('upsertManager', Auth::user());
        return $this->upsertManager($request, $user);
    }

    public function deleteManager($id)
    {
        $user = User::find($id);
        if($user == null)
            return response('Failed to find specified manager', 400);

        $this->authorize('upsertManager', Auth::user());

        $user->delete();
        
        return response('Deleted sucessfully');
    }

    private function upsertManager(Request $request, User $user)
    {

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password_hash = bcrypt($request->input('password'));
        }

        $file = Input::file('photo');
        if ($file != null)
            $this->storeNewPhoto($user, $file);
        $user->save();
        return response('Saved successfully');
    }

    private function storeNewPhoto(User $user, UploadedFile $file)
    {
        $path = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('img/', $path);

        $img = new Image;
        $img->img_name = $path;
        $img->description = $user->username;
        $img->save();

        $user->id_image = $img->id;
    }
}
