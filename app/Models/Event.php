<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['venue_id', 'starts_at', 'ends_at'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * The venue hosting the event
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * The users attending the event
     */
    public function users(): BelongsToMany
    {
        // todo: check this actually returns users who are not volunteers or fixers
        return $this->belongsToMany(User::class)->withPivot('volunteer', 'fixer');
    }

    /**
     * The items being repaired at the event
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('repairer_id', 'checkedin')
            ->using(EventItem::class);
    }

    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivot('volunteer', true);
    }

    public function fixers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->wherePivot('fixer', true);
    }

    /**
     * The skills being offered at the event
     */
    public function skills(): array
    {
        $volunteers = $this->users()->wherePivot('fixer', true)->with('skills')->get();
        $skills = $volunteers->map(function ($volunteer) {
            return $volunteer->skills->pluck('name');
        });

        return $skills->unique()->toArray();
    }
}
