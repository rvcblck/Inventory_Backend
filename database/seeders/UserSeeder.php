<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $adminRoleId = Role::where('role', 'Admin')->first();
        $requestorRoleId = Role::where('role', 'Requestor')->first();
        $financeRoleId = Role::where('role', 'Finance')->first();
        $warehouseRoleId = Role::where('role', 'Warehouse')->first();
        $supplierRoleId = Role::where('role', 'Supplier')->first();

        $comp = DB::table('company')->pluck('company_id')->toArray();

        $companies = Company::get();


        $faker = Faker::create('en_PH');

        //admin seeder
        foreach ($companies as $index => $company) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'company_id' => $company->company_id,
                'email' => 'admin' . ($index + 1) . '@gmail.com',
                'password' => Hash::make('1234'),
                'fname' => $faker->firstName,
                'mname' => null,
                'lname' => $faker->lastName,
                'suffix' => null,
                'bday' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'role_id' => $adminRoleId->role_id,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //requestor seeder
        foreach ($companies as $index => $company) {
            for ($i = 1; $i <= 5; $i++) {
                $email = 'requestor' . ($index + 1) . '_' . $i . '@gmail.com';

                DB::table('users')->insert([
                    'id' => Str::uuid(),
                    'company_id' => $company->company_id,
                    'email' => $email,
                    'password' => Hash::make('1234'),
                    'fname' => $faker->firstName,
                    'mname' => null,
                    'lname' => $faker->lastName,
                    'suffix' => null,
                    'bday' => $faker->date,
                    'contact_no' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'role_id' => $requestorRoleId->role_id,
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        //finance seeder
        foreach ($companies as $index => $company) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'company_id' => $company->company_id,
                'email' => 'finance' . ($index + 1) . '@gmail.com',
                'password' => Hash::make('1234'),
                'fname' => $faker->firstName,
                'mname' => null,
                'lname' => $faker->lastName,
                'suffix' => null,
                'bday' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'role_id' => $financeRoleId->role_id,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //warehouse seeder
        foreach ($companies as $index => $company) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'company_id' => $company->company_id,
                'email' => 'warehouse' . ($index + 1) . '@gmail.com',
                'password' => Hash::make('1234'),
                'fname' => $faker->firstName,
                'mname' => null,
                'lname' => $faker->lastName,
                'suffix' => null,
                'bday' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'role_id' => $warehouseRoleId->role_id,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //supplier seeder
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'company_id' => $comp[array_rand($comp)],
                'email' => 'supplier' . $i . '@gmail.com',
                'password' => Hash::make('1234'),
                'fname' => $faker->firstName,
                'mname' => null,
                'lname' => $faker->lastName,
                'suffix' => null,
                'bday' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'role_id' => $supplierRoleId->role_id,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
