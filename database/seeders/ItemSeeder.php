<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('items')->delete();

        $items = [];
        $categories = DB::table('categories')->pluck('category_id')->toArray();
        $unit = DB::table('units')->pluck('unit_id')->toArray();


        for ($i = 1; $i <= 50; $i++) {
            $items[] = [
                'item_id' => Str::uuid()->toString(),
                'item_name' => 'Item ' . $i,
                'item_description' => 'Description of Item ' . $i,
                'unit_id' => $unit[array_rand($unit)],
                'item_image' => "sample-item.png",
                'category_id' => $categories[array_rand($categories)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('items')->insert($items);
    }
}
