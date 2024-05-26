<?php

namespace App\Http\Controllers;

use App\Models\RKCategory;

class RKMenuController extends Controller
{
    public function index()
    {
        return view('rkmenu.index', [
            'menu' => RKCategory::order()->get(),
        ]);
    }
}
