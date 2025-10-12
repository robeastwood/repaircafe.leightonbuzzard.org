<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->label('Date')
                    ->native(false)
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->native(false)
                    ->required()
                    ->seconds(false)
                    ->minutesStep(10),
                TextInput::make('duration')
                    ->label('Duration (hours)')
                    ->numeric()
                    ->required()
                    ->minValue(0.5)
                    ->maxValue(24)
                    ->step(0.5)
                    ->suffix('hours')
                    ->helperText('Enter the duration in hours (e.g., 2.5 for 2 hours 30 minutes)'),
            ]);
    }
}
