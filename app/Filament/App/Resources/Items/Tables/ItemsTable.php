<?php

namespace App\Filament\App\Resources\Items\Tables;

use App\Filament\App\Resources\Items\ItemResource;
use App\Models\Item;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => Item::statusOptions()[$state] ?? $state)
                    ->badge()
                    ->color(fn ($state) => Item::statusDetails($state)['color'])
                    ->sortable(),
                TextColumn::make('powered')
                    ->label('Power Source')
                    ->formatStateUsing(fn ($state) => Item::powerOptions()[$state] ?? $state)
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('issue')
                    ->label('Issue')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(Item::statusOptions())->native(false),
                SelectFilter::make('powered')
                    ->options(Item::powerOptions())->native(false),
                SelectFilter::make('category')
                    ->relationship('category', 'name')->native(false),
            ])
            ->recordUrl(fn (Item $record): string => ItemResource::getUrl('view', ['record' => $record]))
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
