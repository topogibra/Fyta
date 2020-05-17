<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use App\Tag;
use App\Review;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function render($id)
    {
        $product = Product::getByID($id);
        if ($product == null) {
            return abort(404);
        }
        $feedback = Review::getByProductID($id);
        $reviews = $feedback == null ? [] : $feedback->reviews;
        $score = $feedback == null ? 0 : round($feedback->score);
        $related_products = Product::getRelatedProducts($id);
        foreach($related_products as $rel)
            $rel->sale_price = Product::getSalePrice($rel->id);
            
        $stock = $product->stock;

        if (User::checkUser() == User::$CUSTOMER) {
            $cart = Product::getQuantityByID($id, Auth::id());
            if ($cart !=  null)
                $stock = $stock - $cart->quantity;
        }

        return view('pages.product', [
            'id' => $id,
            'img' => $product->img, 'alt' => $product->alt, 'description' =>  $product->description,
            'price' => $product->price,'sale_price' => $product->sale_price, 'score' => $score, 'name' => $product->name,
            'related' => $related_products,
            'reviews' => $reviews,
            'stock' => $stock
        ]);
    }

    public function add()
    {
        if (User::checkUser() != User::$MANAGER)
            return back();

        $categories = ['Indoor', 'Outdoor', 'Vases', 'Tools'];

        return view('pages.product-form', [
            'method' => 'POST',
            'categories' => $categories
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return abort(404);
        }

        $this->authorize('update', $product);
        $categories = ['Indoor', 'Outdoor', 'Vases', 'Tools'];
        $category = $product->tags()->whereBetween('tag.id', [1, 4])->get()->first()->name;
        if (($key = array_search($category, $categories)) !== false) {
            unset($categories[$key]);
        }


        return view('pages.product-form', [
            'id' => $id,
            'name' => nl2br(str_replace(" ", "&nbsp;", $product->name)),
            'img' => $product->images()->get()->first()->img_name,
            'tags' => $product->tags()->whereNotBetween('tag.id', [1, 4])->get()->all(),
            'stock' => $product->stock,
            'price' => $product->price,
            'description' => $product->description,
            'method' => 'PUT',
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'img' => ['required'], 'name' => ['required'],
            'price' => ['required', 'numeric', 'min:1'], 'description' => ['required'], 'stock' => ['required', 'numeric', 'min:1'],
            'tags' => ['required', 'string']
        ]);


        DB::beginTransaction();
        $product = new Product;
        $this->authorize('create', $product);
        $product->stock = $request->input('stock');
        $product->price = $request->input('price');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->views = 0;
        $product->save();

        $file = Input::file('img');
        $path = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('img/', $path);


        $img = new Image;
        $img->img_name = $path;
        $img->description = $request->input('name');
        $img->save();

        $product->images()->attach($img->id);

        $tags = preg_split('/,/', $request->input('tags'));
        foreach ($tags as $tag) {
            $db_tag = Tag::where('name', '=', $tag)->first();
            if ($db_tag == null) {
                $db_tag = new Tag;
                $db_tag->name = $tag;
                $db_tag->save();
            }

            $product->tags()->attach($db_tag->id);
        }


        DB::commit();
        return redirect('/product/' . $product->id);
    }

    

    public function buyNow($id)
    {
        if (User::validateCustomer())
            return redirect('/login');
        request()->session()->put('items', [$id => 1]);
        request()->session()->put('buynow', true);
        return redirect('checkout-details');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'The product does not exist.'], 404);
        }

        $this->authorize('delete', $product);

        $product->delete();

        return response()->json(['message' => 'The product was deleted succesfully.'], 200);
    }

    public function updateProducts(Request $request)
    {
        $request->validate([
            '*.id' => 'required|numeric|min:1',
            '*.name' => 'required|string',
            '*.price' => 'required|numeric|min:1',
            '*.stock' => 'required|numeric|min:1'
        ]);


        DB::transaction(function () use (&$request) {
            foreach ($request->all() as $item) {
                $this->updateProductInfo($item);
            }
        });

        return response('Success!');
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|min:1',
            'img' => ['nullable'], 'name' => ['required'],
            'price' => ['required', 'numeric', 'min:1'], 'description' => ['required'], 'stock' => ['required', 'numeric', 'min:1'],
            'tags' => ['required', 'string']
        ]);
        DB::transaction(function () use (&$request) {
            $this->updateProductInfo($request->all());
        });

        return redirect('/product/' . $request->input('id'));
    }

    private function updateProductInfo($item)
    {
        $product = Product::find($item['id']);
        $this->authorize('update', $product);
        $product->name = $item['name'];
        $product->price = $item['price'];
        $product->stock = $item['stock'];
        if (isset($item['description']))
            $product->description = $item['description'];
        $file = Input::file('img');

        if ($file != null) {
            $path = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('img/', $path);

            $img = new Image;
            $img->img_name = $path;
            $img->description = $item['name'];
            $img->save();
            $product->images()->detach();
            $product->images()->attach($img->id);
        }

        if (isset($item['tags'])) {
            $tags = preg_split('/,/', $item['tags']);
            foreach ($tags as $tag) {
                $db_tag = Tag::where('name', '=', $tag)->first();
                if ($db_tag == null) {
                    $db_tag = new Tag;
                    $db_tag->name = $tag;
                    $db_tag->save();
                    $product->tags()->attach($db_tag->id);
                } else if ($product->tags()->where('tag.id', '=', $db_tag->id)->get()->first() == null)
                    $product->tags()->attach($db_tag->id);
            }
        }

        $product->save();
    }
}
