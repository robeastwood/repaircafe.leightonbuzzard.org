<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Pages\ViewEvent;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canView($record): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('manage-events') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('manage-events') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('manage-events') ?? false;
    }

    public static function canForceDelete($record): bool
    {
        return auth()->user()?->can('super-admin') ?? false;
    }

    public static function canRestore($record): bool
    {
        return auth()->user()?->can('super-admin') ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'view' => ViewEvent::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        $query = parent::getRecordRouteBindingEloquentQuery();

        // Only super-admins can access soft-deleted records directly by ID
        if (auth()->check() && auth()->user()->can('super-admin')) {
            $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }

        return $query;
    }
}
