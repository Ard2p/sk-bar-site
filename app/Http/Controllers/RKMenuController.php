<?php

namespace App\Http\Controllers;

use App\Models\RKCategory;
use App\Services\RKService;

class RKMenuController extends Controller
{
    public function index()
    {

        $rkService = new RKService();
        $catalog = $rkService->getCatalog();
        dd($catalog);
        return view('rkmenu.index', [
            'menu' => RKCategory::order()->get(),
        ]);
    }
}
