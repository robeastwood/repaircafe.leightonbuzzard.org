<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['starts_at'], $data['ends_at'])) {
            $startsAt = Carbon::parse($data['starts_at']);
            $endsAt = Carbon::parse($data['ends_at']);

            $data['date'] = $startsAt->format('Y-m-d');
            $data['start_time'] = $startsAt->format('H:i:s');
            $data['duration'] = $startsAt->floatDiffInHours($endsAt);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $startsAt = Carbon::parse($data['date'].' '.$data['start_time']);
        $data['starts_at'] = $startsAt;
        $data['ends_at'] = $startsAt->copy()->addHours((float) $data['duration']);

        unset($data['date'], $data['start_time'], $data['duration']);

        return $data;
    }
}
