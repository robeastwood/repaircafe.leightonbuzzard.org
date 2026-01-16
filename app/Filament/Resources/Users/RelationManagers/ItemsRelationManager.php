<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Items\ItemResource;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\Item;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items belonging to this user';

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $pageClass === ViewUser::class;
    }

    public function form(Schema $schema): Schema
    {
        // Build form with user_id pre-filled and disabled for this user
        return $schema
            ->components([
                TextInput::make('owner_name')
                    ->label('Owner')
                    ->default($this->getOwnerRecord()->name)
                    ->disabled()
                    ->dehydrated(false),
                Select::make('user_id')
                    ->label('User ID')
                    ->default($this->getOwnerRecord()->id)
                    ->required()
                    ->hidden()
                    ->dehydrated(),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable()
                    ->url(fn ($record) => ItemResource::getUrl('view', ['record' => $record]))
                    ->color('primary')
                    ->wrap(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => Item::statusOptions()[$state] ?? $state)
                    ->badge()
                    ->color(fn ($state) => Item::statusDetails($state)['color'])
                    ->sortable()
                    ->toggleable(),
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
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(Item::statusOptions())
                    ->multiple(),
                SelectFilter::make('category')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->multiple(),
                SelectFilter::make('powered')
                    ->label('Power Source')
                    ->options(Item::powerOptions())
                    ->multiple(),
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Item')
                    ->modalHeading('Create New Item')
                    ->modalDescription('Add a new item for this user')
                    ->authorize('create'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
