<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function show($id)
    {
        $item = Item::findOrFail($id);

        // $user = Auth::user();
        // if (!$user->is_admin && $item->user_id != $user->id) {
        //     abort(403, "You do not have permission to view this item");
        // }

        return view("item", ["item" => $item]);
    }

    public function myItems()
    {
        $items = Item::where("user_id", Auth::id())->get();
        return view("items", ["items" => $items]);
    }
}
