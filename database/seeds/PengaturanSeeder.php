<?php

use Illuminate\Database\Seeder;
use App\Pengaturan;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengaturan::create([
            'nama' => 'default_lat',
            'value' => '-8.251889'
        ]);
        Pengaturan::create([
            'nama' => 'default_lng',
            'value' => '115.076818'
        ]);
        Pengaturan::create([
            'nama' => 'default_zoom',
            'value' => '10'
        ]);
    }
}
