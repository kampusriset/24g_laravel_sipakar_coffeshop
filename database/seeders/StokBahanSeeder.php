<?php

namespace Database\Seeders;

use App\Models\StokBahan;
use Illuminate\Database\Seeder;

class StokBahanSeeder extends Seeder
{
    public function run(): void
    {
        $bahan = [
            ['nama' => 'Biji Kopi', 'jumlah' => 5000, 'satuan' => 'Gram'],
            ['nama' => 'Susu', 'jumlah' => 10000, 'satuan' => 'Ml'],
            ['nama' => 'Gula Aren', 'jumlah' => 2000, 'satuan' => 'Gram'],
            ['nama' => 'Syrup Caramel', 'jumlah' => 1500, 'satuan' => 'Ml'],
            ['nama' => 'Bubuk Matcha', 'jumlah' => 1000, 'satuan' => 'Gram'],
            ['nama' => 'Bubuk Coklat', 'jumlah' => 1000, 'satuan' => 'Gram'],
            ['nama' => 'Bubuk Taro', 'jumlah' => 1000, 'satuan' => 'Gram'],
            ['nama' => 'Bubuk Red Velvet', 'jumlah' => 1000, 'satuan' => 'Gram'],
            ['nama' => 'Teh Celup', 'jumlah' => 200, 'satuan' => 'Pcs'],
        ];

        foreach ($bahan as $b) {
            StokBahan::create($b);
        }
    }
}