<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\RKProduct;
use App\Models\RKCategory;
use App\Services\RKService;
use Illuminate\Support\Facades\DB;

class RKMenuController extends Controller
{
    public function index()
    {
        // $rkService = new RKService();
        // $menu = $rkService->getMenu();

        // $categories = [];
        // $products = [];

        // $now = Carbon::now();

        // foreach ($menu as $category) {
        //     foreach ($category->products as $product) {
        //         $product->created_at = $now;
        //         $product->updated_at = $now;
        //         $products[] = (array)$product;
        //     }
        //     unset($category->products);
        //     $category->created_at = $now;
        //     $category->updated_at = $now;
        //     $categories[] = (array)$category;
        // }

        // DB::transaction(function () use ($categories, $products) {
        //     RKCategory::truncate();
        //     RKCategory::insert($categories);

        //     RKProduct::truncate();
        //     RKProduct::insert($products);
        // });

        // dd(RKCategory::orderBy('position')->get());
        return view('rkmenu.index', [
            'menu' => RKCategory::orderBy('position')->get(),
        ]);
    }
}
