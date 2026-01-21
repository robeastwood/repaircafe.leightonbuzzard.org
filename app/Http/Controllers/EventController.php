<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function show($id)
    {
        return view('event', ['event' => Event::findOrFail($id)]);
    }

    public function checkin($id)
    {
        return view('checkin', ['event' => Event::findOrFail($id)]);
    }

    public function list()
    {
        return view('events');
    }

    public function cards($id)
    {
        return view('event-cards', ['items' => Event::findOrFail($id)->items()->get()]);
    }
}
