<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

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
}
