<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckinPage extends Component
{
    public $event;
    public $email;
    public $name;
    public $user;
    public $newItem;

    public function mount()
    {
        $this->newItem["status"] = "broken";
    }

    public function rules()
    {
        return [
            "email" => "email",
            "name" => "required",
            "newItem.category" => "required|exists:categories,id",
            "newItem.description" => "required",
            "newItem.issue" => "required",
            "newItem.powered" => ["required", Rule::in(Item::powerOptions())],
            "newItem.status" => [
                "required",
                Rule::in(array_keys(Item::statusOptions())),
            ],
            "newItem.disclaimer" => "accepted",
        ];
    }

    public function updatedEmail()
    {
        if (!Auth::user()->is_admin) {
            abort(403, "Access Denied");
        }

        $this->validateOnly("email");

        $user = User::where("email", $this->email)->first();

        if ($user) {
            $this->user = $user;
            $this->name = $user->name;
        } else {
            $this->user = null;
            $this->name = null;
        }
    }

    public function checkin(Item $item, $checkedin)
    {
        if (!Auth::user()->is_admin) {
            abort(403, "Access Denied");
        }

        if ($checkedin) {
            $item->events()->syncWithoutDetaching([
                $this->event->id => ["checkedin" => Carbon::now()],
            ]);
        } else {
            $item->events()->detach($this->event->id);
        }
        // refresh user
        $this->user = User::findOrFail($this->user->id);
    }

    /**
     * Auto complete the power option
     */
    public function updatedNewItemCategory($cat)
    {
        $this->newItem["powered"] = Category::find($cat)->powered;
    }

    public function createItem()
    {
        if (!Auth::user()->is_admin) {
            abort(403, "Access Denied");
        }

        $this->validate();

        // create a new user?
        if (!$this->user) {
            $this->user = new User();
            $this->user->email = $this->email;
            $this->user->name = $this->name;
            $this->user->password = Hash::make(Str::random(16));
            $this->user->save();
        }

        // attach user to this event
        $this->user->events()->syncWithoutDetaching($this->event);

        // create new item
        $item = new Item();
        $item->user_id = $this->user->id;
        $item->category_id = $this->newItem["category"];
        $item->description = $this->newItem["description"];
        $item->issue = $this->newItem["issue"];
        $item->powered = $this->newItem["powered"];
        $item->status = $this->newItem["status"];
        $item->save();

        // attach to this event and checkin
        $item->events()->attach($this->event, ["checkedin" => 1]);

        // refresh user
        $this->user = User::findOrFail($this->user->id);

        // reset form
        $this->newItem = null;
        $this->newItem["status"] = "broken";
        $this->emit("itemCreated");
    }

    public function render()
    {
        return view("livewire.checkin-page");
    }
}
