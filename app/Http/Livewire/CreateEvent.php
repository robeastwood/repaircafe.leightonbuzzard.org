<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateEvent extends Component
{
    public $showModal = false;

    public $venues;
    public $venue;
    public $date;
    public $startTime;
    public $endTime;

    protected $rules = [
        "venue" => "required|exists:venues,id",
        "date" => "required|date_format:Y-m-d|after:today",
        "startTime" => "required|date_format:H:i",
        "endTime" => "required|date_format:H:i|after:startTime",
    ];

    public function mount()
    {
        $this->venues = Venue::all();
        $this->venue = null;
    }

    public function createEvent()
    {
        if (!Auth::user()->is_admin) {
            Abort(403, "You're not an admin");
        }

        $this->validate();

        // create new event
        $event = new Event();
        $event->venue_id = $this->venue;
        $event->starts_at = Carbon::parse($this->date . " " . $this->startTime);
        $event->ends_at = Carbon::parse($this->date . " " . $this->endTime);
        $event->save();
        $this->emit("saved");
        $this->emit("eventCreated");
        $this->showModal = false;
    }

    public function render()
    {
        return view("livewire.create-event");
    }
}
