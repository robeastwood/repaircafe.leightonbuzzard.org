<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class EventList extends Component
{
    public $futureEvents;

    public function render()
    {
        // get future events
        $this->futureEvents = Event::where("starts_at", ">", Carbon::now())
            ->with("venue")
            ->with("users")
            ->withCount("items")
            ->orderBy("starts_at", "ASC")
            ->get();

        return view("livewire.event-list");
    }
}
