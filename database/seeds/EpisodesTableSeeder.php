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
                "text" => "「テスト」と言っても、学生時代と今とでは、随分と意味が違ったように聞こえる。しかし、早く「テスト」から抜け出したいという思いは、変わらない。",
                "status" => "1",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 2,
                "story_number" => 1,
                "text" => "私はパンケーキなど食べたくない、と言えたら幸せだった。写真だけ撮ることができれば、それで良かった。桜のように、パンケーキも散って地にかえれば良いのに。",
                "status" => "1",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 3,
                "story_number" => 1,
                "text" => "彼が後にお盆を股間にあてがう芸人になろうとは、誰も予想できなかった。",
                "status" => "0",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('story_papers')->insert(
            [
                "paper_novel_id" => 4,
                "story_number" => 1,
                "text" => "ラーメンみたいな名前をつけられて、呼ばれるたびに私はお腹が空く。",
                "status" => "0",
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );


					


        }
    }