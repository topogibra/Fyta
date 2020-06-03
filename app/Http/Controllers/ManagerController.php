<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ManagerController extends ProfileController
{
    public function render()
    {
        return view('pages.profile', ['layout' => ['scripts' => ['js/manager_page.js'],
            'styles' => ['css/profile_page.css', 'css/registerpage.css', 'css/calendar.css'], 'title' => 'Manager Profile']]);
    }

    public function update(Request $request)
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

    public function create(Request $request)
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

    public function delete($id)
    {
        $user = User::find($id);
        if ($user == null)
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

    public function stocks(Request $request)
    {
        $request->validate([
            'page' => ['required', 'numeric', 'min:0']
        ]);

        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access stocks section'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);


        $products = Product::getStockProducts($request->input('page') - 1)->all();
        $clean_products = array_map(function ($product) {
            $data = ['name' => $product->name, 'price' => $product->price, 'stock' => $product->stock, 'id' => $product->id];
            return $data;
        }, $products);

        return ['stocks' => $clean_products, 'pages' => ceil(Product::count() / 10)];
    }


    public function managers(Request $request)
    {
        $request->validate([
            'page' => ['required', 'numeric', 'min:0']
        ]);

        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access the pending orders'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);

        $user = Auth::user();
        $managers = $user->getManagersInfo($request->input('page') - 1)->all();
        $clean_managers = array_map(function ($manager) {
            $data = ['name' => $manager->username, 'date' => $manager->date, 'id' => $manager->id];
            $data['photo'] = 'img/' . $manager->img_name;
            $data['alt'] = $manager->alt;
            return $data;
        }, $managers);

        return [
            'managers' => $clean_managers,
            'pages' => ceil(User::where('user_role', '=', 'Manager')
                ->where('user.id', '<>', $user->id)->count() / 10)
        ];
    }
}
