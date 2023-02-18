<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The venue hosting this event
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * The user this item belongs to, if set.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
