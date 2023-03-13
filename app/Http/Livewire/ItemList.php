<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class ItemList extends Component
{
    public $items;
    public $event;

    protected $listeners = ["itemCreated" => "created"];

    public function created()
    {
        if ($this->event) {
            $this->event->refresh();
            $this->items = $this->event->items;
        } else {
            $this->items = Item::all();
        }
        $this->render();
    }

    public function render()
    {
        return view("livewire.item-list");
    }
}
