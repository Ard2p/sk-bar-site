<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Enums\EventStatusEnum;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'events' => Event::general()->skbar()->paginate(16),
        ]);
    }

    public function show($id)
    {
        $event = Event::general()->where('id', $id)->first();
        if (!$event) return to_route('events.index');

        return view('events.show', [
            'event' => $event,
            'recommended_events' => Event::general()->recommendation()->limit(4)->get()
        ]);
    }
}
