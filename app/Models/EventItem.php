<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventItem extends Pivot
{
    protected $casts = [
        'checkedin' => 'datetime',
    ];
}
