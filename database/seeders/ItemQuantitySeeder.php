<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Item;
use App\Models\ItemQuantity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_quantity')->delete();

        $companies = Company::all();

        foreach ($companies as $company) {
            $items = Item::all();

            foreach ($items as $item) {
                ItemQuantity::create([
                    'item_quantity_id' => Str::uuid()->toString(),
                    'company_id' => $company->company_id,
                    'item_id' => $item->item_id,
                    'item_quantity' => rand(500, 5000)
                ]);
            }
        }
    }
}
