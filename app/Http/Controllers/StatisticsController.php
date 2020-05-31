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
    public function statistics(Request $request){
        $request->validate([
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => ['required', 'date_format:Y-m-d'],
            'limit' => ['nullable', 'between:5,10', 'numeric']
        ]);

        $limit = $request->input('limit');
        if(!$limit)
            $limit = 5;


        $start = $request->input('start');
        $end = $request->input('end');

        return response()->json(['most_sold' => $this->getMostStatistics('"product_order".quantity', 'sold', $start, $end, $limit),
         'top_views' => $this->getMostStatistics('"product".views', 'sold', $start, $end, $limit)]);
    }

    public function getMostStatistics($tableRow, $name, $start, $end, $limit){
        $most = DB::table('product')
            ->select('product.id')
            ->selectRaw("sum($tableRow) as $name")
            ->join('product_order', 'product.id', '=', 'product_order.id_product')
            ->join('order', 'product_order.id_order', '=', 'order.id')
            ->where('order.order_date', '>=', $start)
            ->where('order.order_date', '<=', $end)
            ->groupBy('product.id')
            ->orderByDesc("$name")
            ->limit($limit)
            ->get()
            ->all();

        $grouped = array_map(function ($product) use ($tableRow, $name, $start, $end) {
            return DB::table('product')
                ->select('product.name', 'product.id')
                ->selectRaw("sum($tableRow) as $name")
                ->selectRaw("date_trunc('month', \"order\".order_date) as order_date")
                ->join('product_order', 'product.id', '=', 'product_order.id_product')
                ->join('order', 'product_order.id_order', '=', 'order.id')
                ->where('order.order_date', '>=', $start)
                ->where('order.order_date', '<=', $end)
                ->where('product.id', '=', $product->id)
                ->groupBy('product.id')
                ->groupBy('order_date')
                ->get()
                ->all();
        }, $most);

        return $grouped;
    }

}