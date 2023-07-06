<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('company')->delete();

        for ($i = 0; $i < 10; $i++) {
            DB::table('company')->insert([
                'company_id' => Str::uuid(),
                'company_name' => $faker->company,
                'company_contact_no' => $faker->phoneNumber,
                'company_address' => $faker->address,
                'company_info' =>  $faker->sentence,
            ]);
        }
    }
}
