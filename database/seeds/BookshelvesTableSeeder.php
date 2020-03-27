<?php
use Illuminate\Database\Seeder;

    class BookshelvesTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="BookshelvesTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Bookshelve::create([
					"user_id" => $faker->randomDigit(),
					"novel_id" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }