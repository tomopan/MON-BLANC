<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create("ja_JP");
        //
                DB::table('users')->insert(
            [
            'name' => 'モンブラン',
            'email' => 'user1@gmail.com',
            'user_name' => 'tomopan',
            'bio' => '将来の夢はムキムキな人です',
            'follow_count' => 33,
            'follower_count' => 66,
            'password' => Hash::make('11111111'),
            'api_token' => Str::random(80),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
        ]
        );
        DB::table('users')->insert(
            [
            'name' => '青木遊',
            'email' => 'user2@gmail.com',
            'user_name' => 'yoo',
            'bio' => '将来の夢は小説家です',
            'follow_count' => 99,
            'follower_count' => 123,
            'password' => Hash::make('22222222'),
            'api_token' => Str::random(80),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
        ]
        );
    }
}
