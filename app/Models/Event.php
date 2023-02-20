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
     * The users attending this event
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot("volunteer");
    }

    /**
     * The items booked into this event
     */
    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot("repairer_id")
            ->withPivot("outcome")
            ->withPivot("notes");
    }

    /**
     * return collection of skills that are available at this event
     */
    public function skills()
    {
        $volunteers = $this->users()
            ->wherePivot("volunteer", true)
            ->with("skills")
            ->get();
        $skills = Skill::whereHas("users", function ($query) use ($volunteers) {
            $query->whereIn("id", $volunteers->pluck("id"));
        })->get();
        return $skills;
    }
}
