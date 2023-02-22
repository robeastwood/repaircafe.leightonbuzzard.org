<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateVolunteerForm extends Component
{
    private User $user;
    public $volunteer;
    public $allSkills = [];
    public $userSkills = [];

    protected $rules = [
        "userSkills" => "",
    ];

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $user = Auth::user()->load("skills");
        $this->allSkills = Skill::all();
        $this->volunteer = $user->volunteer;
        $this->userSkills = $user->skills->pluck("id")->toArray();

        //dd($this->userSkills);
    }

    /**
     * Update the user's profile information.
     *
     * @return void
     */
    public function updateVolunteer()
    {
        //dd($this->user->skills);
        // $this->user->volunteer = $this->volunteer;

        $user = Auth::user();
        // $newSkills = $this->userSkills;
        $user->volunteer = $this->volunteer;
        $user->skills()->sync($this->userSkills);
        $user->save();
    }

    public function render()
    {
        return view("livewire.update-volunteer-form");
    }
}
