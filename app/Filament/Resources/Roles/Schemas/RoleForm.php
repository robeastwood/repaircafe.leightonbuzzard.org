<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                CheckboxList::make('permissions')
                    ->relationship('permissions', 'name')
                    ->options(fn () => Permission::all()->pluck('name', 'id'))
                    ->label('Permissions')
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
