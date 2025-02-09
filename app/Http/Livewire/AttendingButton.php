<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AttendingButton extends Component
{
    public $event;
    public $status;
    public $user;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user();

        if (!$this->user) {
            $this->status = "nouser";
            return;
        }

        $this->status = "notattending"; // not attending by default

        if (
            $this->event
                ->users()
                ->wherePivot("fixer", true)
                ->get()
                ->contains($this->user)
        ) {
            $this->status = "fixing";
        } elseif (
            $this->event
                ->users()
                ->wherePivot("volunteer", true)
                ->get()
                ->contains($this->user)
        ) {
            $this->status = "helping";
        } elseif ($this->event->users->contains($this->user)) {
            $this->status = "attending";
        }
    }

    public function render()
    {
        return view("livewire.attending-button");
    }

    public function updatedStatus($newStatus)
    {
        switch ($newStatus) {
            case "attending":
                $this->event->users()->syncWithoutDetaching([
                    $this->user->id => ["volunteer" => false, "fixer" => false],
                ]);
                $this->status = "attending";
                break;
            case "helping":
                if (!$this->user->volunteer) {
                    abort("400", "You are not a volunteer");
                }
                $this->event->users()->syncWithoutDetaching([
                    $this->user->id => ["volunteer" => true, "fixer" => false],
                ]);
                $this->status = "helping";
                break;
            case "fixing":
                if (!$this->user->fixer) {
                    abort("400", "You are not a fixer");
                }
                $this->event->users()->syncWithoutDetaching([
                    $this->user->id => ["volunteer" => true, "fixer" => true],
                ]);
                $this->status = "fixing";
                break;
            default:
                $this->event->users()->detach(Auth::user());
                $this->status = "notattending";
                break;
        }
        $this->emit("rsvp");
    }
}
