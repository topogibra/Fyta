<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

  public function addReview(Request $request){

    

    $rules = [
      'id_product' => 'required | numeric | min:1',
      'id_order' => 'required | numeric | min:1',
      'rating'    => 'required | integer | between:1,5',
      'description' => 'required | string | max:255',
    ];
    $validator = Validator::make(Input::all(),$rules);

    if ($validator->fails()) {
      return response()->json(array(
        'message' => $validator->getMessageBag()->toArray()
      ), 400);
    }

    $validator->validate();

    $productId = $request->input('id_product');
    $orderId = $request->input('id_order');
    $stars = $request->input('rating');
    $description = $request->input('description');
    $order = Order::find($orderId);
    $product = Product::find($productId);
    
    $this->authorize('addReview',[$order,$product]);

    $data = array(
      "id_product" => $productId,
      "id_order" => $orderId,
      "description" => $description,
      "rating" => $stars
    ); 
    
    if(Review::exists($productId,$orderId)){
      return response()->json(["message" => "Already exists a review for that order"], 400);
    }
    
    Review::insert($data);
    
    return response()->json(['message' => '/product/' . $productId],200);
  }
}
