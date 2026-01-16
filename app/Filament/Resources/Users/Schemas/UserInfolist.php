<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Name'),
                                TextEntry::make('email')
                                    ->label('Email')
                                    ->copyable(),
                                TextEntry::make('created_at')
                                    ->label('Joined')
                                    ->dateTime('jS F Y g:ia'),
                                TextEntry::make('roles.name')
                                    ->badge()
                                    ->separator(',')
                                    ->label('Roles'),
                            ]),
                    ]),
                Section::make('Skills')
                    ->schema([
                        TextEntry::make('skills.name')
                            ->badge()
                            ->separator(',')
                            ->label('Skills'),
                    ])
                    ->visible(fn ($record): bool => $record->hasPermissionTo('can-fix') && $record->skills()->exists()),
            ]);
    }
}
