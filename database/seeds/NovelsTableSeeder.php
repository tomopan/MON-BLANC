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
                "title" => "コーンファームでつかまえて",
                "first_sentence" => "完璧な文章などといったものは存在しない。 完璧な絶望が存在しないようにね。",
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
                "title" => "おかっぱな私",
                "first_sentence" => "初めて自分が「おかっぱ」だと気づいたのは、25歳の冬のことだった。",
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
                "title" => "あきらの仮タイトル",
                "first_sentence" => "彼が後にお盆を股間にあてがう芸人になろうとは、誰も予想できなかった。",
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
                "title" => "すみれの仮タイトル",
                "first_sentence" => "ラーメンみたいな名前をつけられて、呼ばれるたびに私はお腹が空く。",
                "status" => 0,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 3,
                "user_id" => 1,
                "user_paper_order" => 3,
                "title" => "ニートの品格",
                "first_sentence" => "ニートにも品格がある。ひとつ、決して労働しない。ふたつ、できる限り家にいる。みっつ、未来のことを考えない。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 4,
                "user_id" => 1,
                "user_paper_order" => 4,
                "title" => "ジャアナ！",
                "first_sentence" => "",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 5,
                "user_id" => 1,
                "user_paper_order" => 5,
                "title" => "土と煙とメガネ",
                "first_sentence" => "ラーメンみたいな名前をつけられて、呼ばれるたびに私はお腹が空く。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 6,
                "user_id" => 1,
                "user_paper_order" => 6,
                "title" => "ナナ宇宙へ",
                "first_sentence" => "ラーメンみたいな名前をつけられて、呼ばれるたびに私はお腹が空く。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 7,
                "user_id" => 1,
                "user_paper_order" => 7,
                "title" => "スチールロッカー・ベイビーズ",
                "first_sentence" => "ラーメンみたいな名前をつけられて、呼ばれるたびに私はお腹が空く。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );
            DB::table('paper_novels')->insert(
            [
                "hero_id" => 8,
                "user_id" => 1,
                "user_paper_order" => 8,
                "title" => "頼むから飯塚に言ってくれ",
                "first_sentence" => "ラーメンみたいな名前をつけられて、呼ばれるたびに私はお腹が空く。",
                "status" => 1,
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now")
            ]
            );

        }
    }