<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class ItemList extends Component
{
    public $items;
    public $event;

    protected $listeners = ["itemCreated" => "created"];

    public function created(Item $newItem)
    {
        $this->items->push($newItem);
        $this->render();
    }

    public function render()
    {
        return view("livewire.item-list");
    }
}
