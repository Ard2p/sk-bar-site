<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'events' => Event::paginate(15),
        ]);
    }

    public function show(Event $event)
    {
        return view('events.show', [
            'event' => $event,
            'recommended_events' => Event::limit(4)->get()
        ]);
    }
}
