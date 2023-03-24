<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The item this note is about
     */
    public function item()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The user this note was added by
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
