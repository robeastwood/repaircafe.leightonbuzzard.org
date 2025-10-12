<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Models\Item;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Owner')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->native(false)
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->native(false)
                    ->options(Item::statusOptions())
                    ->required(),
                Select::make('powered')
                    ->label('Power Source')
                    ->native(false)
                    ->options(Item::powerOptions())
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('issue')
                    ->label('Issue')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
