<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    $nextEvent = Event::where("ends_at", ">=", Carbon::now())
        ->with("venue")
        ->with("users")
        ->withCount("items")
        ->orderBy("ends_at")
        ->first();
    return view("welcome", ["nextEvent" => $nextEvent]);
});
Route::get("/events/{id}", "EventController@showEvent");

// logged in users:
Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    Route::get("/dashboard", function () {
        return view("dashboard");
    })->name("dashboard");
    Route::get("/events/{id}", [EventController::class, "show"])->name("event");
    Route::get("/events", [EventController::class, "list"])->name("events");
    Route::get("/items/{id}", [ItemController::class, "show"])->name("item");
});

// admins:
Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
    "isAdmin",
])->group(function () {
    Route::get("/admin", [AdminController::class, "show"])->name("admin");
});
