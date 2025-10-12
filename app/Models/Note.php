<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'status_orig', 'status_new', 'note'];

    /**
     * The item this note is about
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * The user this note was added by
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
