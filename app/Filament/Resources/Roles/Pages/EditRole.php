<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Permission;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove super-admin permission if user doesn't have it
        if (! auth()->user()?->can('super-admin') && isset($data['permissions'])) {
            $superAdminPermission = Permission::where('name', 'super-admin')->first();
            if ($superAdminPermission) {
                $data['permissions'] = array_diff($data['permissions'], [$superAdminPermission->id]);
            }
        }

        return $data;
    }
}
