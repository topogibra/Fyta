<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller{
    
    public function render($search_products)
    {
        $tags = DB::table('tag')
                ->select('name', 'id')
                ->limit(10)
                ->get();
            
        return view('pages.search', ['categories' => $tags, 'sizes' =>  array("0kg-0.2kg", "0.2kg-0.5kg", "0.5-1.5kg", "1.5kg-3kg", "&gt; 3kg"), 'items' => $search_products]);
    }

    public function textSearch(Request $request)
    {
        $query = $request->input('query');
        $search_products = DB::table('product')->select('id','name','price','description','views');
        if($query) {
			$search_products = $search_products
                                    ->selectRaw('ts_rank(
                                            setweight(to_tsvector(\'english\', product."name"), \'A\') || 
                                            setweight(to_tsvector(\'english\', product."description"), \'B\'), 
                                            plainto_tsquery(\'english\', ?)
                                    ) AS ranking',[$query])
                                    ->orderByDesc('ranking');
            
            $product_imgs = DB::table('image')
                                ->select('search_product.id','name','price','img_name AS img', 'image.description as alt')
                                ->join('product_image','image.id','=','product_image.id_image')
                                ->joinSub($search_products,'search_product', function($join) {
                                    $join->on('product_image.id_product','=','search_product.id');
                                })
                                ->where('ranking','>','0.5')
                                ->limit(9)
                                ->get();
        } else {
            $product_imgs = $search_products
                                ->select('product.id','name','price','img_name as img','image.description as alt')
                                ->join('product_image','product.id','product_image.id_product')
                                ->join('image','image.id','product_image.id_image')
                                ->orderByDesc('views')
                                ->groupBy('product.id','image.id')
                                ->limit(9)
                                ->get();
        }
				
        foreach($product_imgs as $product_img)
           $product_img->img = 'img/' . $product_img->img;
                            
        return $this->render($product_imgs);
    }
  


}