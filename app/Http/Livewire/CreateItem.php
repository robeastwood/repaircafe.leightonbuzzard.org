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

    public function rules()
    {
        return [
            "category" => "required|exists:categories,id",
            "description" => "required",
            "issue" => "required",
            "powered" => ["required", Rule::in(Item::powerOptions())],
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
        if (!$this->anonymous) {
            $item->user_id = Auth::id();
        }
        $item->category_id = $this->category;
        $item->description = $this->description;
        $item->issue = $this->issue;
        $item->powered = $this->powered;
        $item->status = "broken";
        $item->notes =
            Carbon::now() . ": Item record created by " . Auth::user()->name;
        $item->save();
        if ($this->event) {
            $item->events()->syncWithoutDetaching($this->event);
        }

        $this->showModal = false;

        $this->emit("saved");
        $this->emit("itemCreated");
    }

    public function render()
    {
        return view("livewire.create-item");
    }
}
