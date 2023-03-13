<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public static function statusOptions()
    {
        return ["broken", "assessed", "fixed", "awaitingparts", "unfixable"];
    }

    public static function powerOptions()
    {
        return ["no", "mains", "batteries", "other", "unknown"];
    }

    /**
     * The user this item belongs to, if set
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The category this item belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * the events this item is booked into
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
