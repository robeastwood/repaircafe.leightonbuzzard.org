<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public static function statusOptions()
    {
        $statuses = [
            "broken" => [
                "display" => "Broken",
                "colour" => "bg-gray-200 text-gray-800",
                "icon" => "fas fa-heart-crack",
            ],
            "assessed" => [
                "display" => "Assessed",
                "colour" => "bg-blue-200 text-blue-800",
                "icon" => "fas fa-magnifying-glass",
            ],
            "fixed" => [
                "display" => "Fixed!",
                "colour" => "bg-green-200 text-green-800",
                "icon" => "far fa-face-grin",
            ],
            "awaitingparts" => [
                "display" => "Awaiting Parts",
                "colour" => "bg-yellow-200 text-yellow-800",
                "icon" => "far fa-hourglass",
            ],
            "unfixable" => [
                "display" => "Unfixable",
                "colour" => "bg-red-200 text-red-800",
                "icon" => "fas fa-skull-crossbones",
            ],
        ];

        return $statuses;
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

    /**
     * the events this item is booked into
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
