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
                    ->options(function () {
                        $permissions = Permission::all();

                        // Hide super-admin permission from users who don't have it
                        if (! auth()->user()?->can('super-admin')) {
                            $permissions = $permissions->reject(fn ($permission) => $permission->name === 'super-admin');
                        }

                        return $permissions->pluck('name', 'id');
                    })
                    ->label('Permissions')
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
