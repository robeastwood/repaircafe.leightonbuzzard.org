<?php

namespace App\Filament\App\Resources\Items\Schemas;

use App\Models\Category;
use App\Models\Item;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id()),
                Hidden::make('status')
                    ->default('broken'),
                Radio::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->inlineLabel(true)
                    ->required(),
                Textarea::make('description')
                    ->label('Item Description"')
                    ->helperText('Please enter a short description of the item, eg: "Kenwood KF-1000 Kettle"')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Radio::make('powered')
                    ->label('Power Source')
                    ->helperText('Please let us know how the item is powered. This helps us to handle the item safely.')
                    ->options(Item::powerOptions())
                    ->required()
                    ->inlineLabel(true),
                Textarea::make('issue')
                    ->label('Issue')
                    ->helperText('Please let us know about the problem you\'re having with the item in as much detail as you can. This helps us to more quickly diagnose the issue, find the repairer with the best match of skills, and prepare any tools or parts needed in advance.')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
