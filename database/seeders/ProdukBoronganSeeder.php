<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukBoronganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_produkborong')->insert([
            ['name' => 'Brokoli', 'harga' => 250],
            ['name' => 'Cabai Rawit', 'harga' => 350],
            ['name' => 'Cabai Merah Besar', 'harga' => 350],
            ['name' => 'Cabai Kriting', 'harga' => 350],
            ['name' => 'Gambas', 'harga' => 250],
            ['name' => 'Labu Air', 'harga' => 250],
            ['name' => 'Labu Kuning', 'harga' => 250],
            ['name' => 'Labu Waluh', 'harga' => 250],
            ['name' => 'Labu Madu', 'harga' => 0], // As no harga provided
            ['name' => 'Tomat', 'harga' => 350],
            ['name' => 'Terong Kecil', 'harga' => 250],
            ['name' => 'Terong Ungu', 'harga' => 250],
            ['name' => 'Terong Hijau', 'harga' => 250],
            ['name' => 'Timun Suri', 'harga' => 250],
            ['name' => 'Timun Lalap', 'harga' => 250],
            ['name' => 'Melon Golden (Daging Putih)', 'harga' => 600],
            ['name' => 'Melon Daging Putih', 'harga' => 600],
            ['name' => 'Melon Jumbo Daging Oranye', 'harga' => 600],
            ['name' => 'Sawi Putih', 'harga' => 250],
            ['name' => 'Sawi Hijau', 'harga' => 250],
            ['name' => 'Sawi Packcoy', 'harga' => 250],
            ['name' => 'Sawi Manis/Caisim', 'harga' => 250],
            ['name' => 'Semangka Tanpa Biji', 'harga' => 250],
            ['name' => 'Semangka Merah', 'harga' => 250],
            ['name' => 'Semangka Kuning', 'harga' => 250],
            ['name' => 'Kacang Panjang', 'harga' => 250],
        ]);
    }
}
