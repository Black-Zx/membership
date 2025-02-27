<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('address_types')->insert([
            ['name' => 'Residential Address', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Correspondence Address', 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
