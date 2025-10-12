<?php

namespace App\Filament\App\Resources\Items\Pages;

use App\Filament\App\Resources\Items\ItemResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewItem extends ViewRecord
{
    protected static string $resource = ItemResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Item ID: '.$this->record->id;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->modal(),
            DeleteAction::make(),
        ];
    }
}
