<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ItemList extends Component
{
    public $items;
    
    public function render()
    {
        return view('livewire.item-list');
    }
}
