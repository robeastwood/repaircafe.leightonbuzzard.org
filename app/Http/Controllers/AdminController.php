<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display Admin dashboard
     */
    public function show()
    {
        return view("admin", [
            "users" => User::all(),
            "categories" => Category::all(),
            "skills" => Skill::all(),
            "venues" => Venue::all(),
        ]);
    }
}
