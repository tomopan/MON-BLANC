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
            
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 1,
                "story_number" => 1,
                "text" => "テストデータですよ①",
                "status" => "1",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 2,
                "story_number" => 1,
                "text" => "テストデータですよ②。",
                "status" => "1",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 3,
                "story_number" => 1,
                "text" => "テストデータですよ③",
                "status" => "0",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 4,
                "story_number" => 1,
                "text" => "テストデータですよ④",
                "status" => "0",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );


					


        }
    }