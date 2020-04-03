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
            'img_url' => 'img/hero1.png',
            'hero_name' => 'Lisa & Alisa',
            'hero_birth' => '1992',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/hero2.png',
            'hero_name' => 'Izumi',
            'hero_birth' => '1996',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/hero3.png',
            'hero_name' => 'Kyohei',
            'hero_birth' => '1863',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/hero4.png',
            'hero_name' => 'Aki',
            'hero_birth' => '1995',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/hero5.png',
            'hero_name' => 'Shun',
            'hero_birth' => '2016',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('heroes')->insert(
            [
            'img_url' => 'img/hero6.png',
            'hero_name' => 'Kei',
            'hero_birth' => '1986',
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")
            ]
            );


        }
    }