<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('venue.name')
                                    ->label('Venue'),
                                TextEntry::make('starts_at')
                                    ->label('Date')
                                    ->date('jS F Y'),
                                TextEntry::make('times')
                                    ->label('Time')
                                    ->state(function ($record): string {
                                        return $record->starts_at?->format('g:ia').' - '.$record->ends_at?->format('g:ia');
                                    }),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
