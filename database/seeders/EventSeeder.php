<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create some events
        $events = \App\Models\Event::factory(20)->create();

        // add some users to each event, some volunteering
        foreach ($events as $event) {
            $users = User::inRandomOrder()
                ->limit(rand(5, 100))
                ->get();
            foreach ($users as $user) {
                $event->users()->attach($user, [
                    "volunteer" => rand(0, 1),
                ]);
            }
        }

        // add some items to each event
        foreach ($events as $event) {
            $items = Item::inRandomOrder()
                ->limit(rand(5, 100))
                ->get();
            $event->items()->attach($items);
        }
    }
}
