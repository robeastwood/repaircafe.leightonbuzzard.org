<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class EventList extends Component
{
    public $futureEvents;

    protected $listeners = ["eventCreated" => "render"];

    public function render()
    {
        // get future events
        $this->futureEvents = Event::where("ends_at", ">", Carbon::now())
            ->with("venue")
            ->with("users")
            ->withCount("items")
            ->orderBy("ends_at")
            ->get();

        return view("livewire.event-list");
    }
}
