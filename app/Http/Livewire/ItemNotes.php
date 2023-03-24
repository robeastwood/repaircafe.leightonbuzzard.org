<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\Note;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemNotes extends Component
{
    public $item;
    public $newNote;
    public $newStatus;

    public function rules()
    {
        return [
            "newNote" => "required",
            "newStatus" => [
                "required",
                Rule::in(array_keys(Item::statusOptions())),
            ],
        ];
    }

    public function render()
    {
        $this->newStatus = $this->item->status;

        return view("livewire.item-notes");
    }

    public function addNote()
    {
        $this->validate();

        // user must be a volunteer, an admin, or own this item
        if (
            !Auth::user()->volunteer ||
            !Auth::user()->is_admin ||
            $this->item->user_id != Auth::id()
        ) {
            abort("403", "Permission denied");
        }

        $note = new Note();
        $note->user_id = Auth::id();
        $note->item_id = $this->item->id;
        $note->status_orig = $this->item->status;
        $note->status_new = $this->newStatus;
        $note->note = $this->newNote;
        $note->save();

        if ($this->item->status != $this->newStatus) {
            $item = Item::findOrFail($this->item->id);
            $item->status = $this->newStatus;
            $item->save();
            $this->item->status = $this->newStatus;
        }

        $this->item->notes->push($note);

        $this->newNote = "";

        $this->emit("note_created");
    }
}
