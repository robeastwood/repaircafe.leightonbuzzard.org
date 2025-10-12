<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255)
                            ->visible(fn (string $operation): bool => $operation === 'create'),
                        Placeholder::make('email_verified_at')
                            ->label('Email Verified At')
                            ->content(fn ($record): string => $record?->email_verified_at?->format('F j, Y g:i A') ?? 'Not verified')
                            ->visible(fn (string $operation): bool => $operation === 'edit'),
                    ]),
                Section::make('Roles & Permissions')
                    ->schema([
                        CheckboxList::make('roles')
                            ->relationship('roles', 'name')
                            ->options(fn () => Role::all()->pluck('name', 'id'))
                            ->label('Roles')
                            ->columns(2),
                    ]),
            ]);
    }
}
