<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function render()
    {
        $tags = DB::table('tag')
            ->select('name', 'id')
            ->limit(10)
            ->get();

        return view('pages.search', ['categories' => $tags, 'sizes' =>  array("<0.5kg", "0.5-1.5kg", "1.5kg-3kg", "3kg-5kg", "5kg-10kg", "10kg-20kg", ">20kg")]);
    }

    public function fullSearch(Request $request)
    {
        $request->validate([
            'query' => ['string','nullable'],
            'orderByMatch' => ['required', 'boolean'],
            'minPrice' => ['required', 'numeric', 'min:1'],
            'maxPrice' => ['required', 'numeric', 'min:2']
        ]);

        $query = $request->input('query');
        $orderByMatch = $request->input('orderByMatch');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $tags = $request->input('tags');
        //$sizes = $request->input('sizes'); //TODO: query based on product sizes tag

        $search_products = DB::table('product')->select('product.name as title','*');
        if ($query) {
            $search_products = $this->textQuery($search_products, $query);
        }
        if ($tags) {
            $search_products = $search_products
                ->join('product_tag','product_tag.id_product','product.id')
                ->join('tag', 'tag.id', 'product_tag.id_tag') 
                ->whereIn('tag.name', $tags);
        }

        $search_products = $search_products
            ->whereBetween('price', [$minPrice, $maxPrice]);


        $product_imgs = $search_products
            ->join('product_image', 'product_image.id_product', 'product.id')
            ->join('image', 'image.id', 'product_image.id_image');
            

        if ($query && $orderByMatch) {
            $product_imgs = $product_imgs
                ->orderByDesc('ranking');
        } else {
            $product_imgs = $product_imgs
                ->orderBy('price');
        }

        $product_imgs = $product_imgs->limit(9)->get()->all();

        $items = array_map(function ($product) {
            $data = ['name' => $product->title, 'price' => $product->price, 'id' => $product->id,'img' => $product->img_name,'alt' => $product->description];
            return $data;
        }, $product_imgs);
        return $items;
    }

    public function textQuery($products, $query)
    {
        return $products
            ->select(DB::raw('ts_rank(
                        setweight(to_tsvector(\'english\', product."name"), \'A\') || 
                        setweight(to_tsvector(\'english\', product."description"), \'B\'), 
                        plainto_tsquery(\'english\', ?)
                    ) AS ranking'),'product.name as title','*')
            ->setBindings([$query]);
    }

}