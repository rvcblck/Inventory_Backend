<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_id = Role::where('role', 'Supplier')->first();

        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'email' => 'sup' . $i . '@gmail.com',
                'password' => Hash::make('1234'),
                'fname' => $faker->firstName,
                'mname' => null,
                'lname' => $faker->lastName,
                'suffix' => null,
                'bday' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'company_name' => $faker->company,
                'company_contact_no' => $faker->phoneNumber,
                'company_address' => $faker->address,
                'company_info' =>  $faker->sentence,
                'role_id' => $role_id->role_id,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
