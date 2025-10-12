<?php

namespace App\Filament\Resources\Items\RelationManagers;

use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Users\UserResource;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EventsRelationManager extends RelationManager
{
    protected static string $relationship = 'events';

    protected static ?string $title = 'Events booked into';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Toggle::make('is_checked_in')
                    ->label('Checked In')
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $record) {
                        if ($state) {
                            $set('checkedin', $record->ends_at);
                        } else {
                            $set('checkedin', null);
                        }
                    })
                    ->default(fn ($record) => $record?->pivot?->checkedin !== null),
                Radio::make('repairer_id')
                    ->label('Repairer')
                    ->options(function ($record) {
                        return $record->fixers()->pluck('name', 'id');
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('starts_at')
            ->defaultSort('starts_at', 'asc')
            ->paginated(false)
            ->columns([
                TextColumn::make('starts_at')
                    ->label('Event Date')
                    ->dateTime('jS F Y')
                    ->sortable()
                    ->url(fn ($record) => EventResource::getUrl('view', ['record' => $record]))
                    ->color('primary'),
                IconColumn::make('checkedin')
                    ->label('Checked In')
                    ->getStateUsing(fn ($record) => $record->pivot->checkedin !== null)
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),
                TextColumn::make('repairer_id')
                    ->label('Repairer')
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
            ->headerActions([
                AttachAction::make()
                    ->label('Book into event')
                    ->modalHeading('Book into Event')
                    ->modalDescription('Select an event to book this item into')
                    ->attachAnother(false)
                    ->recordSelect(fn (Select $select) => $select
                        ->placeholder('Select an event')
                        ->searchable(false)
                        ->native(false)
                        ->options(function () {
                            return \App\Models\Event::orderBy('starts_at', 'asc')
                                ->get()
                                ->mapWithKeys(fn ($event) => [
                                    $event->id => $event->starts_at->format('jS F Y'),
                                ]);
                        })),
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
        return Auth::user()?->can('manage-items') ? false : true;
    }
}
