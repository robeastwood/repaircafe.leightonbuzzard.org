<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HideSoftDeletedForNonSuperAdmins implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // If user is not authenticated OR doesn't have super-admin permission
        // hide soft-deleted records
        if (! auth()->check() || ! auth()->user()->can('super-admin')) {
            $builder->whereNull($model->getQualifiedDeletedAtColumn());
        }
    }
}
