<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create some owned items
        Item::factory(20)->create();
        // create some annonymously owned items
        Item::factory(10)
            ->annon()
            ->create();
    }
}
