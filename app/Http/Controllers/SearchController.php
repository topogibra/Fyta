<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Product;

class SearchController extends Controller{
    
    public function render()
    {
        $search_products = Product::getTopByTag('Indoor');

        $tags = DB::table('tag')
                ->select('name', 'id')
                ->limit(10)
                ->get();
            
        return view('pages.search', ['categories' => $tags, 'sizes' =>  array("0kg-0.2kg", "0.2kg-0.5kg", "0.5-1.5kg", "1.5kg-3kg", "&gt; 3kg"), 'items' => $search_products]);
    }

  


}