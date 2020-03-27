<?php
use Illuminate\Database\Seeder;

    class NovelsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="NovelsTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Novel::create([
					"hero_id" => $faker->randomDigit(),
					"writer_id" => $faker->randomDigit(),
					"title" => $faker->randomDigit(),
					"episode_id" => $faker->randomDigit(),
					"viewer_count" => $faker->randomDigit(),
					"status" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }