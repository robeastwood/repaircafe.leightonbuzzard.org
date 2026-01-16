<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Filament\Resources\Users\UserResource;
use App\Models\Item;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Item Details')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        TextEntry::make('issue')
                            ->label('Issue')
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Owner')
                                    ->url(fn ($record) => $record->user ? UserResource::getUrl('view', ['record' => $record->user]) : null)
                                    ->color('primary'),
                                TextEntry::make('category.name')
                                    ->label('Category'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->formatStateUsing(fn ($state) => Item::statusOptions()[$state] ?? $state)
                                    ->badge()
                                    ->color(fn ($state) => Item::statusDetails($state)['color']),
                                TextEntry::make('powered')
                                    ->label('Power Source')
                                    ->formatStateUsing(fn ($state) => Item::powerOptions()[$state] ?? $state),
                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime(),

                                TextEntry::make('updated_at')
                                    ->label('Last Update')
                                    ->dateTime(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
