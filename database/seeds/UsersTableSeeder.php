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
            'name' => '佐藤智哉',
            'email' => 'user1@gmail.com',
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
            'password' => Hash::make('22222222'),
            'api_token' => Str::random(80),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")


        ]
        );
    }
}
