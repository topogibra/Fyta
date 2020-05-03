<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{

    public function addShoppingCart(Request $request, $id)
    {
        $request->validate(['quantity' => ['required', 'min:-1']]);

        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response('Need to login', 401);
        }

        if ($role == User::$MANAGER)
            return response('Manager', 403);

        $user =  Auth::id();

        $quantity = $request->get('quantity');

        $cart = Product::getQuantityByID($id, $user);

        if ($cart != null) {
            $product = Product::find($id);
            $quantity = $quantity + $cart->quantity;
            if ($product->stock <  $quantity)
                return response('Number of products to add exceed stock', 500);
            Product::updateQuantity($id, $user, $quantity);
        } else {
            DB::insert('insert into shopping_cart(id_user,id_product,quantity) values (?, ?,?)', [$user, $id, $quantity]);
        }

        return redirect('/product/' . $id);
    }

    public function deleteCartProduct($id)
    {
        $role = User::checkUser();
        if ($role == User::$MANAGER)
            return response('Managers cannot access shopping cart', 403);

        $id_user = Auth::id();
        Product::deleteShoppingCartProduct($id_user, $id);

        redirect('/cart');
        return response('Sucessfully deleted product!', 200);
    }

    public function buy()
    {
        $user = Auth::id();
        $cart = Product::getShoppingCartIds($user);

        $array_items = [];
        foreach ($cart as $value) {
            $array_items[$value->id] = $value->qty;
        }

        request()->session()->put('items', $array_items);

        if (count(request()->session()->get('items', [])) == 0) {
            return response('No products in cart!', 400);
        }

        return redirect('checkout-details');
    }
}
