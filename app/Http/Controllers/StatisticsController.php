<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\OrderHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StatisticsController extends Controller{
    public function most_sold(Request $request){
        $request->validate([
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d'],
            'limit' => ['nullable', 'between:5,10', 'numeric']
        ]);

        $limit = $request->input('limit');
        if(!$limit)
            $limit = 5;

        $most_sold = DB::table('product')
            ->select('product.id')
            ->selectRaw('sum("product_order".quantity) as sold')
            ->join('product_order', 'product.id', '=', 'product_order.id_product')
            ->join('order', 'product_order.id_order', '=', 'order.id')
            ->where('order.order_date', '>=', $request->input('start'))
            ->where('order.order_date', '<=', $request->input('end'))
            ->groupBy('product.id')
            ->orderByDesc('sold')
            ->limit($limit)
            ->get()
            ->all();

        $grouped_sold = array_map(function ($product) use($request) {
            return DB::table('product')
                ->select('product.name', 'product.id')
                ->selectRaw('sum("product_order".quantity) as sold')
                ->selectRaw("date_trunc('month', \"order\".order_date) as order_date") 
                ->join('product_order', 'product.id', '=', 'product_order.id_product')
                ->join('order', 'product_order.id_order', '=', 'order.id')
                ->where('order.order_date', '>=', $request->input('start'))
                ->where('order.order_date', '<=', $request->input('end'))
                ->where('product.id', '=', $product->id)
                ->groupBy('product.id')
                ->groupBy('order_date')
                ->get()
                ->all();
        }, $most_sold);

        return response()->json($grouped_sold);
    }

}