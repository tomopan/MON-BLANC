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
            'img_url' => 'img/books/hero1.png',
            'hero_name' => 'AKIRA',
            'hero_birth' => '1992',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/books/hero2.png',
            'hero_name' => 'LISA',
            'hero_birth' => '1996',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/books/hero3.png',
            'hero_name' => 'AMI',
            'hero_birth' => '1863',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/books/hero4.png',
            'hero_name' => 'MARI',
            'hero_birth' => '1995',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/books/hero5.png',
            'hero_name' => 'KARIN',
            'hero_birth' => '2016',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/books/hero6.png',
            'hero_name' => 'RUI',
            'hero_birth' => '1986',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );


        }
    }