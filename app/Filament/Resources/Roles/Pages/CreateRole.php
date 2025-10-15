<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Permission;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
