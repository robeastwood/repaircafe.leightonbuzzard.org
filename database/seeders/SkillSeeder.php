<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create([
            'name' => 'Woodwork',
            'description' => 'Woodwork skill description',
        ]);
        Skill::create([
            'name' => 'Metalwork',
            'description' => 'Metalwork skill description',
        ]);
        Skill::create([
            'name' => 'Uphostery',
            'description' => 'Uphostery skill description',
        ]);
        Skill::create([
            'name' => 'Clothing',
            'description' => 'Clothing skill description',
        ]);
        Skill::create([
            'name' => 'Textiles',
            'description' => 'Textiles skill description',
        ]);
        Skill::create([
            'name' => 'Electricals',
            'description' => 'Electricals skill description',
        ]);
        Skill::create([
            'name' => 'Mechanicals',
            'description' => 'Mechanicals skill description',
        ]);
        Skill::create([
            'name' => 'Electronics',
            'description' => 'Electronics skill description',
        ]);
        Skill::create([
            'name' => 'Windows PCs',
            'description' => 'Windows PCs skill description',
        ]);
        Skill::create([
            'name' => 'Macs',
            'description' => 'Macs skill description',
        ]);
    }
}
