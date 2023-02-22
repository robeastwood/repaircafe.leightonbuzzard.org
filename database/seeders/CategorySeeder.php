<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name" => "Kitchen Electricals",
            "description" =>
                "Toasters, Kettles, Blenders, Mixers, Coffee machines, and other such items",
            "powered" => "mains",
        ]);
        Category::create([
            "name" => "Household Electricals",
            "description" => "General electricals such as lamps, fans etc",
            "powered" => "no",
        ]);
        Category::create([
            "name" => "Electronic Toys & Games",
            "description" => "Electronic Toys & Games",
            "powered" => "batteries",
        ]);
        Category::create([
            "name" => "Wooden Furniture",
            "description" => "Wooden Furniture frames",
            "powered" => "no",
        ]);
        Category::create([
            "name" => "Metal Furniture",
            "description" => "Metal Furniture frames",
            "powered" => "no",
        ]);
        Category::create([
            "name" => "Furniture uphostery",
            "description" => "Fabric or leather furniture uphostery",
            "powered" => "no",
        ]);
        Category::create([
            "name" => "Audio/Video systems",
            "description" =>
                "Amplifiers, Speakers, VCRs, CD/DVD/BluRay Players, Media Players, Set top boxes etc",
            "powered" => "mains",
        ]);
        Category::create([
            "name" => "Desktop PCs",
            "description" => "Desktop PCs (windows/mac/linux)",
            "powered" => "mains",
        ]);
        Category::create([
            "name" => "Laptop PCs",
            "description" => "Windows laptops and chromebooks",
            "powered" => "batteries",
        ]);
        Category::create([
            "name" => "Macbooks",
            "description" => "Apple Laptops",
            "powered" => "batteries",
        ]);
        Category::create([
            "name" => "Tablets",
            "description" => "Android or Apple tablets",
            "powered" => "batteries",
        ]);
        Category::create([
            "name" => "Other Electronics",
            "description" =>
                "Anything electronic that doesn't fit in the other categories",
            "powered" => "batteries",
        ]);
        Category::create([
            "name" => "Other",
            "description" =>
                "Anything else that doesn't fit in the other categories",
            "powered" => "no",
        ]);
    }
}
