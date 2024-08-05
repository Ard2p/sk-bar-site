<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'events' => Event::active()->actual()->orderBy('event_start')->paginate(16),
        ]);
    }

    public function show(Event $event)
    {
        return view('events.show', [
            'event' => $event,
            'recommended_events' => Event::active()->actual()->orderBy('event_start')->recommendation()->limit(4)->get()
        ]);
    }
}
