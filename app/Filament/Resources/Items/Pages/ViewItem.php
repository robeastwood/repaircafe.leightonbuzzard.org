<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;

class ViewItem extends ViewRecord
{
    protected static string $resource = ItemResource::class;

    #[On('note-added')]
    public function refreshItem(): void
    {
        $this->refreshFormData(['status']);
    }

    public function getTitle(): string|Htmlable
    {
        $title = 'Item ID: '.$this->record->id;

        if ($this->record->trashed()) {
            return new \Illuminate\Support\HtmlString(
                $title.' <span style="display: inline-block; padding: 0.25rem 0.5rem; margin-left: 0.5rem; font-size: 0.875rem; font-weight: 600; color: #dc2626; background-color: #fee2e2; border: 1px solid #fca5a5; border-radius: 0.375rem; vertical-align: baseline; transform: translateY(-0.375rem);">DELETED</span>'
            );
        }

        return $title;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->modal(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
