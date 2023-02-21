<?php

use App\Http\Controllers\Controller;
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
    return view("welcome");
});

Route::get("/test", "App\Http\Controllers\VenueController@test");

// logged in users:

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    Route::get("/dashboard", function () {
        return view("dashboard");
    })->name("dashboard");
    Route::get("/events", function () {
        return view("events");
    })->name("events");
});

// admins:
Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
    "isAdmin",
])->group(function () {
    Route::get("/admin", function () {
        return view("admin");
    })->name("admin");
});
