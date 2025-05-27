<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('messages')->insert([
            [
                'sender_id' => 1,
                'reciever_id' => 2,
                'message_content' => $faker->text(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'sender_id' => 1,
                'reciever_id' => 3,
                'message_content' => $faker->text(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
