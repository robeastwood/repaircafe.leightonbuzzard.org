<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateRepaircafeUserSettingsForm extends Component
{

    public bool $volunteer;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->volunteer = Auth::user()->volunteer;
    }

    /**
     * Update the user's profile information.
     *
     * @return void
     */
    public function updateRepaircafeUserSettings()
    {
        $user = Auth::user();
        $user->volunteer = $this->volunteer;
        $user->save();
    }


    public function render()
    {
        return view('livewire.update-repaircafe-user-settings-form');
    }
}
