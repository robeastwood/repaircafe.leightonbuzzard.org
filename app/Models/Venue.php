<?php

namespace App\Models;

use App\Models\Scopes\HideSoftDeletedForNonSuperAdmins;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A venue for an event
 */
class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new HideSoftDeletedForNonSuperAdmins);
    }

    /**
     * The events at this venue
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
