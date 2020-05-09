<?php
use Illuminate\Database\Seeder;

    class BookmarksTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="BookmarksTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '1',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);

            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '2',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);

            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '5',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);

            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '6',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);

            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '7',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);

            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '8',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '9',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            DB::table('bookmarks')->insert(
                [
					"user_id" => '1',
					"paper_novel_id" => '10',
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
        }
    }