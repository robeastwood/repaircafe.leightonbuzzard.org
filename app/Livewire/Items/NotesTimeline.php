<?php

namespace App\Livewire\Items;

use App\Models\Item;
use App\Models\Note;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NotesTimeline extends Component implements HasForms
{
    use InteractsWithForms;

    public Item $item;

    public ?array $data = [];

    public function mount(Item $item): void
    {
        $this->item = $item;
        $this->data = [
            'note' => null,
            'status_new' => $item->status,
        ];
    }

    protected function getFormSchema(): array
    {
        $schema = [
            Textarea::make('note')
                ->label('Type your note here...')
                ->placeholder('Add a note about this item...')
                ->required()
                ->rows(3),
        ];

        // Only show status field if user has permission to update item status
        if ($this->canUpdateItemStatus()) {
            $schema[] = Select::make('status_new')
                ->label('Current Status')
                ->options(Item::statusOptions())
                ->required()
                ->native(false);
        }

        return $schema;
    }

    public function canAddNote(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        // Users can add notes to their own items
        if ($this->item->user_id === $user->id) {
            return true;
        }

        // Users with add-notes permission can add notes to any item
        return $user->can('add-notes');
    }

    public function canUpdateItemStatus(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        // Users can update status of their own items
        if ($this->item->user_id === $user->id) {
            return true;
        }

        // Users with update-item-status permission can update any item status
        return $user->can('update-item-status');
    }

    #[On('note-added')]
    public function refreshComponent(): void
    {
        // This will trigger a re-render
    }

    public function addNote(): void
    {
        if (! $this->canAddNote()) {
            Notification::make()
                ->danger()
                ->title('Unauthorized')
                ->body('You do not have permission to add notes to this item.')
                ->send();

            return;
        }

        // Validate the form data
        $validationRules = [
            'data.note' => ['required', 'string'],
        ];

        // Only validate status if user has permission to update it
        if ($this->canUpdateItemStatus()) {
            $validationRules['data.status_new'] = ['required', 'string'];
        }

        $this->validate($validationRules);

        // Determine the status to use
        $statusNew = $this->canUpdateItemStatus()
            ? $this->data['status_new']
            : $this->item->status;

        Note::create([
            'item_id' => $this->item->id,
            'user_id' => Auth::id(),
            'status_orig' => $this->item->status,
            'status_new' => $statusNew,
            'note' => $this->data['note'],
        ]);

        // Update item status if user has permission and it changed
        if ($this->canUpdateItemStatus() && $statusNew !== $this->item->status) {
            $this->item->update([
                'status' => $statusNew,
            ]);
        }

        // Reset form
        $this->data = [
            'note' => null,
            'status_new' => $this->item->fresh()->status,
        ];

        Notification::make()
            ->success()
            ->title('Note added')
            ->body('Your note has been added successfully.')
            ->send();

        // Refresh the component
        $this->dispatch('note-added');
    }

    public function render()
    {
        $notes = $this->item->notes()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.items.notes-timeline', [
            'notes' => $notes,
        ]);
    }
}
