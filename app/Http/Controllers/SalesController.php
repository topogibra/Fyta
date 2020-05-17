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
    public function sales(Request $request)
    {
        $request->validate(['page' => ['required', 'numeric', 'min:0']]);

        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to access stocks section'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have access to this section'], 403);

        $count = 0;
        $sales = Discount::getCurrentSales($request->input('page'), $count);
        $clean_sales = array_map(function ($sale) {
            $data = ['id' => $sale->id, 'percentage' => $sale->percentage, 'begin' => $sale->date_begin, 'end' => $sale->date_end];
            return $data;
        }, $sales);

        return ['sales' => $clean_sales, 'pages' => ceil($count / 10)];
    }

    public function delete($id)
    {

        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'The discount does not exist.'], 404);
        }

        $this->authorize('delete', $discount);

        $discount->delete();

        return response()->json(['message' => 'The discount was deleted successfully.'], 200);
    }

    public function add()
    {
        if (User::checkUser() != User::$MANAGER)
            return back();

        return view('pages.sales-form', [
            'method' => 'POST'
        ]);
    }

    public function create(Request $request)
    {
        return $this->upsertSale($request, true);
    }

    public function edit($id)
    {
        $discount = Discount::find($id);
        $this->authorize('show', $discount);

        return view('pages.sales-form', [
            'method' => 'PUT',
            'percentage' => $discount->percentage,
            'begin' => $discount->date_begin,
            'end' => $discount->date_end,
            'id' => $discount->id
        ]);
    }

    public function update(Request $request)
    {
        return $this->upsertSale($request, false);
    }

    public function updateProductsList($discount, $products, $onGoing)
    {
        foreach ($products as $id) {
            $product = Product::find($id);
            $nSalesApplied = $product->discounts()->count();
            $conf = $product->discounts()->whereNotIn('apply_discount.id_discount', $onGoing)->get();
            if ($nSalesApplied == 0 || count($conf) > 0) $product->discounts()->attach($discount);
        }
    }

    public function availableProducts(Request $request)
    {
        $role = User::checkUser();
        if ($role == User::$GUEST) {
            return response()->json(['message' => 'You must login to perform this action'], 401);
        } else if ($role == User::$CUSTOMER)
            return response()->json(['message' => 'You do not have permission to this action'], 403);

        DB::beginTransaction();

        $request->validate([
            'begin' => 'required|date',
            'end' => 'required|date',
            'id' => 'nullable|numeric|min:1',
            'page' => 'required|numeric|min:0'
        ]);

        $begin = $request->input('begin');
        $end = $request->input('end');
        $id = $request->input('id');
        $page = $request->input('page');

        $onGoing = $this->getOnGoingSales($begin, $end);

        $unavailableProducts = DB::table('product')
            ->select('product.id')
            ->join('apply_discount', 'apply_discount.id_product', 'product.id')
            ->whereIn('id_discount', $onGoing)
            ->get()
            ->all();
        $unavailableProducts = array_map(function ($prod) {
            return $prod->id;
        }, $unavailableProducts);

        $availableProducts = DB::table('product')
            ->distinct()
            ->select('product.id', 'name', 'price', 'img_name', 'image.description as alt')
            ->join('apply_discount', 'id_product', 'product.id')
            ->join('product_image', 'product_image.id_product', 'product.id')
            ->join('image', 'image.id', 'product_image.id_image')
            ->get()
            ->whereNotIn('id', $unavailableProducts)->all();
        $availableProducts = array_values($availableProducts);
        $cleanProducts = array_map(function ($product) {
            $data = ['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'img' => $product->img_name, 'alt' => $product->alt, 'applied' => false];
            return $data;
        }, $availableProducts);

        if ($id) {
            $discount = Discount::find($id);
            $appliedProducts = $discount->products()
                ->select('product.id', 'name', 'price', 'img_name', 'image.description as alt')
                ->join('product_image', 'product_image.id_product', 'product.id')
                ->join('image', 'image.id', 'product_image.id_image')
                ->get()
                ->all();

            $cleanApplied = array_map(function ($product) {
                $data = ['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'img' => $product->img_name, 'alt' => $product->alt, 'applied' => true];
                return $data;
            }, $appliedProducts);

            $cleanProducts = array_merge($cleanApplied, $cleanProducts);
        }

        DB::commit();

        $nProds = count($cleanProducts);
        $cleanProducts = array_splice($cleanProducts, 5 * ($page - 1), 5);
        return ['products' => $cleanProducts, 'pages' => ceil($nProds / 5)];
    }

    public function getOnGoingSales($begin, $end)
    {
        $onGoing = DB::table('discount')->select('id')->where([['date_begin', '>=', $begin], ['date_begin', '<=', $end]])
            ->orWhere([['date_begin', '<=', $begin], ['date_end', '>=', $begin]])->get()->all();
        $onGoingClean = [];
        foreach ($onGoing as $sale)
            array_push($onGoingClean, $sale->id);
        return $onGoingClean;
    }

    public function upsertSale(Request $request, $insert)
    {
        $request->validate([
            'sale-id' => ['required', 'numeric', 'min:-1'],
            'percentage' => ['required', 'numeric', 'min:1', 'max:99'],
            'begin' => ['required', 'date'],
            'end' => ['required', 'date'],
            'products' => ['nullable', 'string']
        ]);

        $id = $request->input('sale-id');

        DB::beginTransaction();

        if ($insert)
            $discount = new Discount();
        else
            $discount = Discount::find($id);
        $this->authorize('upsert', $discount);


        $percentage = $request->input('percentage');
        $begin = $request->input('begin');
        $end = $request->input('end');
        $products = $request->input('products');

        if ($begin > $end)
            return response()->json(['message' => 'Begin date can\'t be after End date'], 400);


        $discount->percentage = $percentage;
        $discount->date_begin = $begin;
        $discount->date_end = $end;
        $onGoing = $this->getOnGoingSales($begin, $end); //get sales onGoing before creating
        $discount->save();

        $discount->products()->detach();

        if ($products) {
            $products = preg_split('/,/', $products);
            $this->updateProductsList($discount->id, $products, $onGoing);
        }

        DB::commit();

        return redirect('/manager/');
    }
}
