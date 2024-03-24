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
    public $fixer;
    public $allSkills = [];
    public $userSkills = [];
    public $newSkill;

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
        $this->fixer = $user->fixer;
        $this->userSkills = $user->skills->pluck("id")->toArray();
    }

    /**
     * Update the user's profile information.
     *
     * @return void
     */
    public function updateVolunteer()
    {
        $user = Auth::user();
        $user->volunteer = $this->volunteer;
        $user->fixer = $this->fixer;
        $user->skills()->sync($this->userSkills);
        $user->save();
        $this->emit('saved');
    }

    public function addSkill()
    {
        $newskill = Skill::create([
            "name" => $this->newSkill,
            "description" =>
                $this->newSkill . " (Added by: " . Auth::user()->name . ")",
        ]);
        $this->allSkills->push($newskill);
        $this->userSkills[] = $newskill->id;
        $this->newSkill = "";
    }

    public function render()
    {
        return view("livewire.update-volunteer-form");
    }
}
