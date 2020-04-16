<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use app\Product;

class SearchController extends Controller{
    public function render($tag_id,$n_page)
    {
        $search_products = Product::tags()
                            ->select('name','price')
                            ->where('tag.id',$tag_id)
                            ->orderByDesc('views')
                            ->offset(10*$n_page)
                            ->limit(10)
                            ->get();

        $tags = DB::table('tag')
                ->select('name')
                ->get();

        return view('pages.search', ['categories' => $tags, 'sizes' =>  array("0kg-0.2kg", "0.2kg-0.5kg", "0.5-1.5kg", "1.5kg-3kg", "&gt; 3kg"), 'items' => $search_products]);
    }

  


}