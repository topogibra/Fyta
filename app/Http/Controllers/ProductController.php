<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    public function render()
    {
        return view('pages.product', ['img' => 'img/bonsai.jpg', 'description' => "Have you ever thought of tending a plant? Do you watch asian movies and feel like going into that rich culture? Now you can have a piece of that by ordering one of our premium Bonsai CRT,that will give your home a deep sense of oriental energy.", 'price' => '35€', 'score' => 4.0, 'name' => 'Bonsai CRT', 'related' => [['img' => 'img/supreme_vase.jpg', 'name' => 'Supreme Bonsai Pot', 'price' => '40€'], ['img' => 'img/gloves_tool.jpg', 'name' => 'Blue Garden Gloves', 'price' => '9€'], ['img' => 'img/pondlilies_outdoor.jpg', 'name' => 'Pond White Lilies', 'price' => '40€']], 'reviews' => [['name' => 'Frederique Cousteau', 'img' => 'img/frederique_cousteau.jpg', 'date' => '2 days ago', 'review' => 4, 'description' => "This is a bonsai alright, but the premium bit makes me twitch my nose. It's not that high quality, but good for beginners."], ['name' => 'Josh Miller', 'img' => 'img/josh_miller.jpg', 'date' => '2 days ago', 'review' => 3, 'description' => "I like this bonsai, but this is expensive! I'll never pay off my student loans at this rate... #stayoffwifiwhenhigh"], ['name' => 'Kelly Mahagan', 'img' => 'img/kelly_mahagan.jpg', 'date' => '2 days ago', 'review' => 5, 'description' => " OMG, this bonsai is so F.A.B.U.L.O.U.S.! My dad thought this was a scam, but i totally convinced him to buy it and I couldn't love this more. Love you too daddy xoxo"]]]);
    }

    public function add()
    {
        return view('pages.product-form');
    }

    public function create(Request $request)
    {

        $request->validate(['img' => ['required'], 'name' => ['required'],
             'price' => ['required', 'numeric', 'min:1'], 'description' => ['required'], 'stock' => ['required', 'numeric', 'min:1'],
             'tags' => ['required', 'string']]);

        $product = new Product;
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
        foreach ($tags as $tag){
            $db_tag = Tag::where('name', '=', $tag)->first();
            if($db_tag == null){
                $db_tag = new Tag;
                $db_tag->name = $tag;
                $db_tag->save();
            }

            $product->tags()->attach($db_tag->id);
        }

        return redirect('/home');
    }

    public function buyNow(Request $request)
    {
        $request->session()->put('items', [1]); //TODO: Add the actual id of the product
        return redirect('checkout-details');
    }
}
