<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $startsAt = Carbon::parse($data['date'].' '.$data['start_time']);
        $data['starts_at'] = $startsAt;
        $data['ends_at'] = $startsAt->copy()->addHours((float) $data['duration']);

        unset($data['date'], $data['start_time'], $data['duration']);

        return $data;
    }
}
