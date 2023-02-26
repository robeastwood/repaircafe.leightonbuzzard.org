<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AttendingButton extends Component
{
    public $event;
    public $status;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $user = Auth::user();

        $this->status = "notattending"; // not attending by default

        if (
            $this->event
                ->users()
                ->wherePivot("volunteer", true)
                ->get()
                ->contains($user)
        ) {
            $this->status = "volunteering";
        } elseif ($this->event->users->contains($user)) {
            $this->status = "attending";
        }
    }

    public function render()
    {
        return view("livewire.attending-button");
    }

    public function rsvp($status)
    {
        switch ($status) {
            case "attending":
                $this->event->users()->syncWithoutDetaching([
                    Auth::id() => ["volunteer" => false],
                ]);
                $this->status = "attending";
                break;
            case "volunteering":
                $this->event->users()->syncWithoutDetaching([
                    Auth::id() => ["volunteer" => true],
                ]);
                $this->status = "volunteering";
                break;
            default:
                $this->event->users()->detach(Auth::user());
                $this->status = "notattending";
                break;
        }
        $this->emit('rsvp');
    }
}
