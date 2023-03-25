<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateItem extends Component
{
    public $showModal = false;

    public $event;

    public $anonymous;
    public $categories;
    public $category;
    public $description;
    public $issue;
    public $powerOptions;
    public $powered;
    public $disclaimer;

    public function rules()
    {
        return [
            "category" => "required|exists:categories,id",
            "description" => "required",
            "issue" => "required",
            "powered" => ["required", Rule::in(Item::powerOptions())],
            "disclaimer" => "accepted",
        ];
    }

    public function mount()
    {
        $this->powerOptions = Item::powerOptions();
        $this->categories = Category::all();
        $this->category = null;
    }

    public function createItem()
    {
        $this->validate();

        // create new item
        $item = new Item();
        if (!$this->anonymous || !Auth::user()->is_admin) {
            $item->user_id = Auth::id();
        }
        $item->category_id = $this->category;
        $item->description = $this->description;
        $item->issue = $this->issue;
        $item->powered = $this->powered;
        $item->status = "broken";
        $item->save();
        if ($this->event) {
            $item->events()->syncWithoutDetaching($this->event);
            Auth::user()
                ->events()
                ->syncWithoutDetaching($this->event);
        }
        $this->showModal = false;
        $this->emit("item");
        $this->emit("itemCreated", $item->id);
    }

    public function render()
    {
        return view("livewire.create-item");
    }
}
