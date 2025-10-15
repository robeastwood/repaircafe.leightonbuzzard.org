<?php

namespace App\Models;

use App\Models\Scopes\HideSoftDeletedForNonSuperAdmins;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'category_id', 'status', 'description', 'issue', 'powered'];

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new HideSoftDeletedForNonSuperAdmins);
    }

    public static function statusOptions(): array
    {
        return [
            'broken' => 'Broken',
            'assessed' => 'Assessed',
            'fixed' => 'Fixed!',
            'awaitingparts' => 'Awaiting Parts',
            'unfixable' => 'Unfixable',
        ];
    }

    public static function statusDetails($status): array
    {
        $statuses = [
            'broken' => [
                'color' => 'gray',
                'icon' => 'heroicon-o-exclamation-triangle',
            ],
            'assessed' => [
                'color' => 'info',
                'icon' => 'heroicon-o-magnifying-glass',
            ],
            'fixed' => [
                'color' => 'success',
                'icon' => 'heroicon-o-face-smile',
            ],
            'awaitingparts' => [
                'color' => 'warning',
                'icon' => 'heroicon-o-clock',
            ],
            'unfixable' => [
                'color' => 'danger',
                'icon' => 'heroicon-o-face-frown',
            ],
        ];

        return $statuses[$status] ?? [
            'color' => 'gray',
            'icon' => 'heroicon-o-question-mark-circle',
        ];
    }

    public static function powerOptions(): array
    {
        return [
            'no' => 'Not Powered',
            'mains' => 'Mains',
            'batteries' => 'Batteries',
            'other' => 'Other',
            'unknown' => 'Unknown',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)
            ->withPivot('repairer_id', 'checkedin')
            ->using(EventItem::class);
    }

    public function checkedin(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->wherePivot('checkedin', true);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
