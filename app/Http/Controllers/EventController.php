<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($id)
    {
        return view("event", ["event" => Event::findOrFail($id)]);
    }

    public function checkin($id)
    {
        return view("checkin", ["event" => Event::findOrFail($id)]);
    }

    public function list()
    {
        return view("events");
    }
}
