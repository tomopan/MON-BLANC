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

            DB::table('novels')->insert(
            [
                "hero_id" => 1,
                "writer_id" => 2,
                "title" => "デカルトの冒険",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('novels')->insert(
            [
                "hero_id" => 2,
                "writer_id" => 1,
                "title" => "しおりんの冒険",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('novels')->insert(
            [
                "hero_id" => 1,
                "writer_id" => 2,
                "title" => "下書きデカルトの冒険",
                "status" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('novels')->insert(
            [
                "hero_id" => 2,
                "writer_id" => 1,
                "title" => "下書きしおりんの冒険",
                "status" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );

        }
    }