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

            DB::table('paper_novels')->insert(
            [
                "hero_id" => 1,
                "user_id" => 2,
                "user_paper_order" => 1,
                "title" => "テストタイトル",
                "first_sentence" => "テストです。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 2,
                "user_id" => 1,
                "user_paper_order" => 1,
                "title" => "テストタイトル",
                "first_sentence" => "テストです。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 1,
                "user_id" => 2,
                "user_paper_order" => 2,
                "title" => "テストタイトル",
                "first_sentence" => "テストです。",
                "status" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 2,
                "user_id" => 1,
                "user_paper_order" => 2,
                "title" => "テストタイトル",
                "first_sentence" => "テストです。",
                "status" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );

        }
    }