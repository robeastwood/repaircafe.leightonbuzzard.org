<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;


    /**
     * The user this note was added by
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
