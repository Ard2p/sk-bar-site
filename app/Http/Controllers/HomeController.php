<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'coming_events' => Event::limit(4)->get(),
            'recommended_events' => Event::limit(4)->get()
        ]);
    }
}
