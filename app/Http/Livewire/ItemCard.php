<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ItemCard extends Component
{

    public $item;

    public function render()
    {
        return view('livewire.item-card');
    }
}
