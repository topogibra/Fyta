<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use App\User;
use Exception;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function getOnGoingSales($begin, $end)
    {
        $onGoing = DB::table('discount')->select('id')->where([['date_begin', '>=', $begin], ['date_begin', '<=', $end]])
            ->orWhere([['date_begin', '<=', $begin], ['date_end', '>=', $begin]])->get()->all();
        $onGoingClean = [];
        foreach ($onGoing as $sale)
            array_push($onGoingClean, $sale->id);
        return $onGoingClean;
    }
}
