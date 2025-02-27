<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $statuses = ['pending', 'approved', 'rejected', 'terminated'];

        for ($i = 1; $i <= 10; $i++) {
            Member::create([
                'name'  => "Member $i",
                'email' => "member$i@example.com",
                'phone' => $faker->phoneNumber,
                'referral_code' => Str::random(8),
                'status' => $statuses[array_rand($statuses)],
            ]);
        }

    }
}
