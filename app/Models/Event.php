<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Get the venue hosting this event
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
