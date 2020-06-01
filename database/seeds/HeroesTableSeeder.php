<?php
use Illuminate\Database\Seeder;

    class HeroesTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
        //
        $faker = Faker\Factory::create("ja_JP");

            DB::table('heroes')->insert(
            [
            'img_url' => 'AKIRA.png',
            'hero_name' => 'AKIRA',
            'hero_birth' => '28',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'SUMIRE.png',
            'hero_name' => 'SUMIRE',
            'hero_birth' => '28',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'JUN.png',
            'hero_name' => 'JUN',
            'hero_birth' => '24',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'MARI.png',
            'hero_name' => 'MARI',
            'hero_birth' => '35',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'MICHI.png',
            'hero_name' => 'MICHI',
            'hero_birth' => '27',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'NANA.png',
            'hero_name' => 'NANA',
            'hero_birth' => '25',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'KEITA.png',
            'hero_name' => 'KEITA',
            'hero_birth' => '32',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'DAIKI.png',
            'hero_name' => 'DAIKI',
            'hero_birth' => '30',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
        }
    }