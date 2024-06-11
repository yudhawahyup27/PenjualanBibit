<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LuasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['luas_area' => 175, 'jumlah_batang' => 400, 'status' => 'm2'],
            ['luas_area' => 180, 'jumlah_batang' => 420, 'status' => 'm2'],
            ['luas_area' => 200, 'jumlah_batang' => 460, 'status' => 'm2'],
            ['luas_area' => 250, 'jumlah_batang' => 680, 'status' => 'm2'],
            ['luas_area' => 300, 'jumlah_batang' => 700, 'status' => 'm2'],
            ['luas_area' => 350, 'jumlah_batang' => 800, 'status' => 'm2'],
            ['luas_area' => 400, 'jumlah_batang' => 820, 'status' => 'm2'],
            ['luas_area' => 450, 'jumlah_batang' => 1040, 'status' => 'm2'],
            ['luas_area' => 500, 'jumlah_batang' => 1150, 'status' => 'm2'],
            ['luas_area' => 550, 'jumlah_batang' => 1265, 'status' => 'm2'],
            ['luas_area' => 600, 'jumlah_batang' => 1480, 'status' => 'm2'],
            ['luas_area' => 650, 'jumlah_batang' => 1495, 'status' => 'm2'],
            ['luas_area' => 700, 'jumlah_batang' => 1600, 'status' => 'm2'],
            ['luas_area' => 750, 'jumlah_batang' => 1750, 'status' => 'm2'],
            ['luas_area' => 800, 'jumlah_batang' => 1835, 'status' => 'm2'],
            ['luas_area' => 850, 'jumlah_batang' => 1950, 'status' => 'm2'],
            ['luas_area' => 900, 'jumlah_batang' => 2065, 'status' => 'm2'],
            ['luas_area' => 950, 'jumlah_batang' => 2180, 'status' => 'm2'],
            ['luas_area' => 1000, 'jumlah_batang' => 2295, 'status' => 'm2'],
            ['luas_area' => 1180, 'jumlah_batang' => 2410, 'status' => 'm2'],
            ['luas_area' => 1200, 'jumlah_batang' => 2520, 'status' => 'm2'],
            ['luas_area' => 1250, 'jumlah_batang' => 2635, 'status' => 'm2'],
            ['luas_area' => 1300, 'jumlah_batang' => 2750, 'status' => 'm2'],
            ['luas_area' => 1350, 'jumlah_batang' => 2865, 'status' => 'm2'],
            ['luas_area' => 1, 'jumlah_batang' => 3200, 'status' => 'hektar'],
            ['luas_area' => 2, 'jumlah_batang' => 6400, 'status' => 'hektar'],
            ['luas_area' => 3, 'jumlah_batang' => 9600, 'status' => 'hektar'],
            ['luas_area' => 4, 'jumlah_batang' => 12800, 'status' => 'hektar'],
            ['luas_area' => 5, 'jumlah_batang' => 16000, 'status' => 'hektar'],
       ];

        DB::table('luas_tb')->insert($data);
    }
}
