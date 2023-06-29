<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $role_id = Role::where('role','Warehouse')->first();

        $faker = Faker::create();

        DB::table('users')->insert([
            'id' => Str::uuid(),
            'email' => 'ware@gmail.com',
            'password' => Hash::make('1234'),
            'fname' => $faker->firstName,
            'mname' => null,
            'lname' => $faker->lastName,
            'suffix' => null,
            'bday' => $faker->date,
            'contact_no' => $faker->phoneNumber,
            'address' => $faker->address,
            'role_id' => $role_id->role_id,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
