<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('roles')->delete();

        $roles = [
            ['role_id' => Str::uuid(), 'role' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => Str::uuid(), 'role' => 'Requestor', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => Str::uuid(), 'role' => 'Warehouse', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => Str::uuid(), 'role' => 'Supplier', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('roles')->insert($roles);
    }
}
