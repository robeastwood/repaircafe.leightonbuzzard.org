<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Resources\Items\ItemResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\Item;
use App\Models\User;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items booked into this event';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Toggle::make('checkedin')
                    ->label('Checked In')
                    ->formatStateUsing(function ($state, $record) {
                        // When editing, check if the pivot checkedin value is not null
                        if ($record && $record->pivot) {
                            return $record->pivot->checkedin !== null;
                        }

                        return $state !== null;
                    })
                    ->dehydrateStateUsing(fn ($state) => $state ? now() : null),
                Radio::make('repairer_id')
                    ->label('Repairer')
                    ->options(function () {
                        return $this->getOwnerRecord()->fixers()->pluck('name', 'id');
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->defaultSort('created_at', 'desc')
            ->paginated(false)
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->toggleable()
                    ->url(fn ($record) => $record->user ? UserResource::getUrl('view', ['record' => $record->user]) : null)
                    ->color('primary'),
                TextColumn::make('user.email')
                    ->label('Owner Email')
                    ->searchable()
                    ->copyable()
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')
                    ->label('Item Description')
                    ->searchable()
                    ->toggleable()
                    ->url(fn ($record) => ItemResource::getUrl('view', ['record' => $record]))
                    ->color('primary')
                    ->wrap(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->toggleable()
                    ->badge()
                    ->colors([
                        'danger' => 'broken',
                        'warning' => 'assessed',
                        'success' => 'fixed',
                        'info' => 'awaitingparts',
                        'gray' => 'unfixable',
                    ])
                    ->toggleable(),
                IconColumn::make('checkedin')
                    ->label('Checked In')
                    ->getStateUsing(fn ($record) => $record->pivot->checkedin !== null)
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->toggleable()
                    ->falseColor('gray'),
                TextColumn::make('repairer_id')
                    ->label('Repairer')
                    ->toggleable()
                    ->getStateUsing(function ($record) {
                        if (! $record->pivot->repairer_id) {
                            return null;
                        }
                        $repairer = User::find($record->pivot->repairer_id);

                        return $repairer ? $repairer->name : null;
                    })
                    ->placeholder('Not assigned')
                    ->url(function ($record) {
                        if (! $record->pivot->repairer_id) {
                            return null;
                        }
                        $repairer = User::find($record->pivot->repairer_id);

                        return $repairer ? UserResource::getUrl('view', ['record' => $repairer]) : null;
                    })
                    ->color('primary'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(Item::statusOptions())
                    ->multiple(),
                TernaryFilter::make('checkedin')
                    ->label('Checked In')
                    ->placeholder('All items')
                    ->trueLabel('Checked in')
                    ->native(false)
                    ->falseLabel('Not checked in')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('event_item.checkedin'),
                        false: fn (Builder $query) => $query->whereNull('event_item.checkedin'),
                        blank: fn (Builder $query) => $query,
                    ),
                SelectFilter::make('repairer_assigned')
                    ->label('Repairer')
                    ->placeholder('All items')
                    ->native(false)
                    ->options(function () {
                        $fixers = $this->getOwnerRecord()
                            ->fixers()
                            ->pluck('name', 'id')
                            ->toArray();

                        return ['unassigned' => 'Not assigned'] + $fixers;
                    })
                    ->query(function (Builder $query, array $data) {
                        if (! isset($data['value']) || $data['value'] === '') {
                            return $query;
                        }

                        if ($data['value'] === 'unassigned') {
                            return $query->whereNull('event_item.repairer_id');
                        }

                        return $query->where('event_item.repairer_id', $data['value']);
                    }),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Book item into event')
                    ->modalHeading('Book Item into Event')
                    ->modalDescription('Select an item to book into this event')
                    ->attachAnother(false)
                    ->recordSelect(fn (Select $select) => $select
                        ->placeholder('Select an item')
                        ->searchable()
                        ->native(false)
                        ->getSearchResultsUsing(function (string $search) {
                            return \App\Models\Item::where('description', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($query) use ($search) {
                                    $query->where('name', 'like', "%{$search}%");
                                })
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(fn ($item) => [
                                    $item->id => $item->description.' - '.$item->user?->name,
                                ]);
                        })
                        ->getOptionLabelUsing(fn ($value) => \App\Models\Item::find($value)?->description))
                    ->failureNotificationTitle('Failed to book item')
                    ->before(function (AttachAction $action, array $data) {
                        $recordId = $data['recordId'] ?? null;

                        if ($recordId && $this->getOwnerRecord()->items()->where('items.id', $recordId)->exists()) {
                            \Filament\Notifications\Notification::make()
                                ->danger()
                                ->title('Item already booked')
                                ->body('This item is already booked into this event.')
                                ->send();

                            $action->halt();
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }

    public function isReadOnly(): bool
    {
        return Auth::user()?->can('manage-events') ? false : true;
    }
}
