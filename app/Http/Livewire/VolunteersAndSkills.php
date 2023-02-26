<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VolunteersAndSkills extends Component
{
    public $event;

    protected $listeners = ["rsvp"];

    public function rsvp()
    {
        $this->render();
    }

    public function render()
    {
        return view("livewire.volunteers-and-skills");
    }
}
