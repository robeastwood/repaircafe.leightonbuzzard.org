<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Events\Schemas\EventInfolist;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    public function getTitle(): string
    {
        return $this->record->starts_at->format('l jS F Y');
    }

    public function infolist(Schema $schema): Schema
    {
        return EventInfolist::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->mutateRecordDataUsing(function (array $data): array {
                    if (isset($data['starts_at'], $data['ends_at'])) {
                        $startsAt = Carbon::parse($data['starts_at']);
                        $endsAt = Carbon::parse($data['ends_at']);

                        $data['date'] = $startsAt->format('Y-m-d');
                        $data['start_time'] = $startsAt->format('H:i:s');
                        $data['duration'] = $startsAt->floatDiffInHours($endsAt);
                    }

                    return $data;
                })
                ->using(function (array $data, $record): mixed {
                    $startsAt = Carbon::parse($data['date'].' '.$data['start_time']);
                    $data['starts_at'] = $startsAt;
                    $data['ends_at'] = $startsAt->copy()->addHours((float) $data['duration']);

                    unset($data['date'], $data['start_time'], $data['duration']);

                    $record->update($data);

                    return $record;
                }),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
