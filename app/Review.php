<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    public $timestamps  = false;

    protected $table = 'review';

    public function product()
    {
        return $this->belongsTo('App\Product', 'id_product');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'id_order');
    }

    public static function getByProductID($id)
    {
        $reviews = DB::table('review')
                    ->select('id_order','description','rating as review','review_date as date')
                    ->where('id_product','=',$id)
                    ->orderBy('date','desc')
                    ->get();
        
        if($reviews->isEmpty())
            return null;
        
        $score = 0;
        $reviews = json_decode(json_encode($reviews));

        foreach($reviews as $review) {
            $order = Order::find($review->id_order);
            $user = $order->user;
            $img = $user->image;
            $review->name = $user->username;
            $review->img = 'img/' . $img->img_name;
            $review->alt = str_replace(' ', '', $img->description);
            $score += $review->review;
        }
        
        $score = $score / count($reviews);
        return (object) ['reviews' => $reviews,'score' => $score];
    }

}
