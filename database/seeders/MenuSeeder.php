<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\StokBahan;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $coffee = KategoriMenu::where('nama', 'Coffee')->first();
        $nonCoffee = KategoriMenu::where('nama', 'Non Coffee')->first();

        $bahan = StokBahan::pluck('id', 'nama'); // ['Biji Kopi' => 1, 'Susu' => 2, ...]

        $menuData = [

            [
                'nama' => 'Espresso',
                'gambar' => 'menu/Espresso.png',
                'kategori' => $coffee->id,
                'harga' => 18000,
                'resep' => [
                    ['Biji Kopi', 18],
                ]
            ],

            [
                'nama' => 'Americano',
                'gambar' => 'menu/Americano.jpg',
                'kategori' => $coffee->id,
                'harga' => 20000,
                'resep' => [
                    ['Biji Kopi', 18],
                ]
            ],

            [
                'nama' => 'Cappuccino',
                'gambar' => 'menu/Cappuccino.jpg',
                'kategori' => $coffee->id,
                'harga' => 25000,
                'resep' => [
                    ['Biji Kopi',18],
                    ['Susu',150],
                ]
            ],

            [
                'nama' => 'Cafe Latte',
                'gambar' => 'menu/CafeLatte.jpg',
                'kategori' => $coffee->id,
                'harga' => 25000,
                'resep' => [
                    ['Biji Kopi',18],
                    ['Susu',200],
                ]
            ],

            [
                'nama' => 'Kopi Gula Aren',
                'gambar' => 'menu/GulaAren.jpg',
                'kategori' => $coffee->id,
                'harga' => 22000,
                'resep' => [
                    ['Biji Kopi',18],
                    ['Susu',150],
                    ['Gula Aren',30],
                ]
            ],

            [
                'nama' => 'Mocha',
                'gambar' => 'menu/Mocha.jpg',
                'kategori' => $coffee->id,
                'harga' => 27000,
                'resep' => [
                    ['Biji Kopi',18],
                    ['Susu',150],
                    ['Bubuk Coklat',20],
                ]
            ],

            [
                'nama' => 'Caramel Macchiato',
                'gambar' => 'menu/CaramelMacchiato.jpg',
                'kategori' => $coffee->id,
                'harga' => 28000,
                'resep' => [
                    ['Biji Kopi',18],
                    ['Susu',150],
                    ['Syrup Caramel',20],
                ]
            ],

            [
                'nama' => 'Matcha Latte',
                'gambar' => 'menu/MatchaLatte.jpg',
                'kategori' => $nonCoffee->id,
                'harga' => 26000,
                'resep' => [
                    ['Bubuk Matcha',15],
                    ['Susu',200],
                ]
            ],

            [
                'nama' => 'Chocolate',
                'gambar' => 'menu/Chocolate.jpg',
                'kategori' => $nonCoffee->id,
                'harga' => 24000,
                'resep' => [
                    ['Bubuk Coklat',30],
                    ['Susu',200],
                ]
            ],

            [
                'nama' => 'Red Velvet',
                'gambar' => 'menu/RedVelvet.jpg',
                'kategori' => $nonCoffee->id,
                'harga' => 26000,
                'resep' => [
                    ['Bubuk Red Velvet',25],
                    ['Susu',200],
                ]
            ],

            [
                'nama' => 'Taro Latte',
                'gambar' => 'menu/TaroLatte.jpg',
                'kategori' => $nonCoffee->id,
                'harga' => 26000,
                'resep' => [
                    ['Bubuk Taro',25],
                    ['Susu',200],
                ]
            ],

            [
                'nama' => 'Lemon Tea',
                'gambar' => 'menu/LemonTea.jpg',
                'kategori' => $nonCoffee->id,
                'harga' => 15000,
                'resep' => [
                    ['Teh Celup',1],
                ]
            ],

        ];

        foreach ($menuData as $m) {
            $menu = Menu::create([
                'kategori_menu_id' => $m['kategori'],
                'nama' => $m['nama'],
                'harga' => $m['harga'],
                'gambar' => $m['gambar'],
                'status' => true,
            ]);

            foreach ($m['resep'] as [$namaBahan, $jumlahPakai]) {
                $menu->bahanUsage()->create([
                    'stok_bahan_id' => $bahan[$namaBahan],
                    'jumlah_pakai' => $jumlahPakai,
                ]);
            }
        }
    }
}