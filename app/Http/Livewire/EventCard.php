<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EventCard extends Component
{
    public $event;

    public function render()
    {
        return view('livewire.event-card');
    }
}
