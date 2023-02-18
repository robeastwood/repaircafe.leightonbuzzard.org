<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class EventList extends Component
{

    public $futureEvents, $skillList;


    public function render()
    {
        // get future events
        $this->futureEvents = Event::where('starts_at', '>', Carbon::now())->with('venue')->orderBy('starts_at', 'DESC')->get();

        // get skills at this
        return view('livewire.event-list');
    }
}
