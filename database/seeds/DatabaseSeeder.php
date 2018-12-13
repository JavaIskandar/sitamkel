<?php

use Illuminate\Database\Seeder;
use illuminate\Database\eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PengaturanSeeder::class);
         $this->call(UserSeeder::class);
    }
}
