<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('comments')->insert([
            [
                'post_id' => 1,
                'user_id' => 1,
                'content' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'post_id' => 2,
                'user_id' => 1,
                'content' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
