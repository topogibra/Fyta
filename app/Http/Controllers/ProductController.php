<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function render($id){
        $product = Product::getByID($id);
        if($product == null) {
            return response('No such product was found',404);
        }
        $feedback = Review::getByProductID($id);
        $reviews = $feedback == null? [] : $feedback->reviews;
        $score = $feedback == null? 0 : $feedback->score;
        return view('pages.product', ['img' => $product->img, 'description' =>  $product->description, 
                                        'price' => $product->price, 'score' => $score, 'name' => $product->name, 
                                        'related' => [['id' => 1, 'img' => 'img/supreme_vase.jpg', 'name' => 'Supreme Bonsai Pot', 'price' => '40€'], ['id' => 1, 'img' => 'img/gloves_tool.jpg', 'name' => 'Blue Garden Gloves', 'price' => '9€'], ['id' => 1, 'img' => 'img/pondlilies_outdoor.jpg', 'name' => 'Pond White Lilies', 'price' => '40€']], 
                                        'reviews' => $reviews]);
    }
}