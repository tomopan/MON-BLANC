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
            
            DB::table('episodes')->insert(
            [
                "novel_id" => 1,
                "episode_number" => 1,
                "episode_title" => "デカルトのはじまり",
                "text" => "我思う故に我あり",
                "status" => "1",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('episodes')->insert(
            [
                "novel_id" => 2,
                "episode_number" => 1,
                "episode_title" => "玉井のはじまり",
                "text" => "玉井 詩織（たまい しおり、1995年6月4日 - ）は、ももいろクローバーZのメンバー、女優である。グループでのイメージカラーは黄色で、ボーカル・ギター・ピアノ担当。",
                "status" => "1",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );


					


        }
    }