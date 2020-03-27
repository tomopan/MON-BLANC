<?php
use Illuminate\Database\Seeder;

    class EpisodesTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="EpisodesTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Episode::create([
					"novel_id" => $faker->randomDigit(),
					"episode_number" => $faker->randomDigit(),
					"episode_title" => $faker->randomDigit(),
					"text" => $faker->randomDigit(),
					"status" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }