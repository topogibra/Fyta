<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Discount extends Model
{
    public $timestamps  = false;

    protected $table = 'discount';

    public function products()
    {
        return $this->belongsToMany('App\Product', 'apply_discount', 'id_discount', 'id_product');
    }

    public static function getCurrentSales($page, &$count)
    {
        $sales = DB::table('discount')->where('date_end', '>=', now())->orderBy('date_begin');
        $count = $sales->count();
        $sales = $sales->limit(10)->offset(($page - 1) * 10)->get()->all();
        return $sales;
    }

    public static function checkConflicts($id)
    {
        $conflicts = DB::table('discount')
            ->join('apply_discount', 'apply_discount.id_discount', '=', 'discount.id')
            ->join('discount as new_discount', 'new_discount.id', '<>', 'discount.id')
            ->join('apply_discount as new_apply', 'new_apply.id_discount', '=', 'new_discount.id')
            ->where('discount.id', $id)
            ->whereRaw('new_apply.id_product = apply_discount.id_product')
            ->where(function ($query) {
                $query->whereRaw('discount.date_begin >= new_discount.date_begin')
                    ->whereRaw('discount.date_begin <= new_discount.date_end');
            })
            ->orWhere(function ($query) {
                $query->whereRaw('new_discount.date_begin >= discount.date_begin')
                    ->whereRaw('new_discount.date_begin <= discount.date_end');
            })
            ->count();
        return $conflicts > 0;
    }
}
