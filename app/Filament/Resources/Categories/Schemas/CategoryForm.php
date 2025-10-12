<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Item;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->columnSpanFull(),
                Radio::make('powered')
                    ->label('Power Type')
                    ->options(Item::powerOptions())
                    ->helperText('Select the typical power type for items in this category'),
            ]);
    }
}
