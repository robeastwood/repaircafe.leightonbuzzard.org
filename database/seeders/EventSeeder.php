<?php

namespace Database\Seeders;

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
        $events = \App\Models\Event::factory(20)->create();

        // add some users to each event
        foreach($events as $event){
            $users = User::inRandomOrder()->limit(20)->get();
            $event->users()->sync($users);
        }
    }
}
