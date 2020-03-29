<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //********************************************
        // Cmd:[ php artisan db:seed ]
        //********************************************
        // $this->call(UsersTableSeeder::class);
		$this->call(NovelsTableSeeder::class);
		$this->call(HeroesTableSeeder::class);
		$this->call(EpisodesTableSeeder::class);
		$this->call(UsersTableSeeder::class);

   }
}