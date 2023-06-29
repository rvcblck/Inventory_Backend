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
        $role_id = Role::where('role','Supplier')->first();
        $categories = DB::table('categories')->pluck('category_id')->toArray();
        $supplier = DB::table('users')->where('role_id',$role_id->role_id)->pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $items[] = [
                'item_id' => Str::uuid()->toString(),
                'item_name' => 'Item ' . $i,
                'item_description' => 'Description of Item ' . $i,
                'item_price' => rand(10, 100),
                'item_quantity' => rand(1, 100),
                'item_image' => "sample-item.png",
                'category_id' => $categories[array_rand($categories)],
                'supplier_id' => $supplier[array_rand($supplier)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('items')->insert($items);
    }
}
