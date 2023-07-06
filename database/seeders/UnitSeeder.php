<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Count
            [
                'type' => 'count',
                'unit' => 'piece',
                'shorthand' => 'pcs'
            ],
            [
                'type' => 'count',
                'unit' => 'set',
                'shorthand' => 'set'
            ],
            [
                'type' => 'count',
                'unit' => 'bundle',
                'shorthand' => 'bdl'
            ],
            [
                'type' => 'count',
                'unit' => 'box',
                'shorthand' => 'box'
            ],
            // Length
            [
                'type' => 'length',
                'unit' => 'meter',
                'shorthand' => 'm'
            ],
            [
                'type' => 'length',
                'unit' => 'centimeter',
                'shorthand' => 'cm'
            ],
            [
                'type' => 'length',
                'unit' => 'millimeter',
                'shorthand' => 'mm'
            ],
            [
                'type' => 'length',
                'unit' => 'inch',
                'shorthand' => 'in'
            ],
            [
                'type' => 'length',
                'unit' => 'foot',
                'shorthand' => 'ft'
            ],

            // Area
            [
                'type' => 'area',
                'unit' => 'square meter',
                'shorthand' => 'm²'
            ],
            [
                'type' => 'area',
                'unit' => 'square foot',
                'shorthand' => 'ft²'
            ],
            [
                'type' => 'area',
                'unit' => 'square yard',
                'shorthand' => 'yd²'
            ],

            // Volume
            [
                'type' => 'volume',
                'unit' => 'cubic meter',
                'shorthand' => 'm³'
            ],
            [
                'type' => 'volume',
                'unit' => 'cubic foot',
                'shorthand' => 'ft³'
            ],
            [
                'type' => 'volume',
                'unit' => 'liter',
                'shorthand' => 'L'
            ],
            [
                'type' => 'volume',
                'unit' => 'gallon',
                'shorthand' => 'gal'
            ],

            // Weight/Mass
            [
                'type' => 'weight/mass',
                'unit' => 'kilogram',
                'shorthand' => 'kg'
            ],
            [
                'type' => 'weight/mass',
                'unit' => 'gram',
                'shorthand' => 'g'
            ],
            [
                'type' => 'weight/mass',
                'unit' => 'pound',
                'shorthand' => 'lb'
            ],
            [
                'type' => 'weight/mass',
                'unit' => 'ton',
                'shorthand' => 't'
            ],

        ];

        foreach ($data as $item) {
            $item['unit_id'] = Str::uuid(); // Generate UUID for unit_id column
            Unit::create($item);
        }
    }
}
